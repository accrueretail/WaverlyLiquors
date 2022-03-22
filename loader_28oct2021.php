<?php
header("Cache-Control: max-age=31536000"); 

define ('HOME', dirname(__FILE__));
define ('SECRET_KEY','safkjasgfgjksad#f');
define ('CACHE', __DIR__.'/cache');
define ('API_URL', 'https://api.accrueretail.com/');
//define ('API_URL', 'https://stagingapi.accrueretail.com/');

//Start the session
session_start();


//$siteUrl = "http://phpdemo.accrueretail.com";
//$siteUrl = "http://ec2-100-25-161-21.compute-1.amazonaws.com";
$siteUrl = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'];

$siteName = "Atlantic Systems";

$_SESSION['siteUrl'] = $siteUrl;
$appId = $_SESSION['APP_ID'] = 10006;
if(!isset($_SESSION['STORE_ID']) || $_SESSION['STORE_ID']==''){
	$storeId = $_SESSION['STORE_ID'] = 10006;
}
else{
	$storeId = $_SESSION['STORE_ID'];
}

if(!isset($_SESSION['USER_ID']) || $_SESSION['USER_ID']==''){
	$userId = $_SESSION['USER_ID'];
}
else{
	$userId = $_SESSION['USER_ID'];
}

if(!isset($_SESSION['DEVICE_ID']) || $_SESSION['DEVICE_ID']=='') {
	$unique_bytes = random_bytes(5);
	$unique_code  = bin2hex($unique_bytes);
	$_SESSION['DEVICE_ID'] = $unique_code;
}
//print_r($_SESSION);
//require_once('includes/db.php');
require_once('includes/functions.php');
require_once('includes/routes.php');
//require_once('precheck.php');
//print_r($_SESSION);
//session check
if(!isset($_SESSION['SESSION_ID']) || $_SESSION['SESSION_ID']=='' || is_null($_SESSION['SESSION_ID']))
{
create_session($appId, $storeId);
}

error_reporting(~E_ALL);

$store_details = getCurrentStoreDetails();
$store_home_details = StoreGetDetails();

$errors = 0;
$errorMessages = array();
$routeParams = [];


// settings
$_SESSION['force_refresh'] = false; // dev
$_SESSION['refresh'] = 60*60;

if($_GET['refresh'] == '1'){
	$_SESSION['force_refresh'] = true;

}
else{
	$_SESSION['force_refresh'] = false;
}

if(isset($_GET['_route']) && !empty($_GET['_route'])){
	$route = rtrim($_GET['_route'],'/');
	
}else{
	$route = 'index';
}


if(strpos($route,'/')){
	$path = explode('/',$route);
}

//Prepare get
$getVariables = array();


unset($_GET['_route']);
foreach($_GET as $key => $value){
	$getVariables[$key] = strip_tags($value);
}

//Prepare post
$postVariables = array();
foreach($_POST as $key => $value){
	$postVariables[$key] = strip_tags($value);
}

if(is_dir('app/controllers/'.$route)){
	$route = $route.'/index';
}

$_currentRoute = $route;




//Sanitize the inputs
foreach($_GET as $key => $value){
	$_GETRequest[$key] = htmlentities($value); 
}

foreach($_POST as $key => $value){
	$_POSTRequest[$key] = htmlentities($value); 
}

//Create
$_done = 0;

//check in our routes table first

if($resolver = match_route($route,$_routes)){
	$route = $resolver['route'];
	$routeParams = $resolver['params'];

}

if(file_exists('app/controllers/'.$route.'.php')){
	include('app/controllers/'.$route.'.php');
	$_done = 1;
}

if(file_exists('app/views/'.$route.'.php')){
	include('app/views/'.$route.'.php');
	$_done = 1;
}

if($_done == 0){
	//echo "resolver";
	//print_r(match_route($route,$_routes));
	http_response_code(404);
	//include('my_404.php'); // provide your own HTML for the error page

	die('ERROR: Cannot load controller or view :'.$route);
}



//$curl = curl_init();
function api_call($curl, $url, $data){
	curl_setopt($curl, CURLOPT_URL, $url);

	// Set the CURLOPT_RETURNTRANSFER option to true
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	// Set the CURLOPT_POST option to true for POST request
	curl_setopt($curl, CURLOPT_POST, true);

	// Set the request data as JSON using json_encode function
	curl_setopt($curl, CURLOPT_POSTFIELDS,  json_encode($data));
	curl_setopt($curl, CURLOPT_FRESH_CONNECT, TRUE);

	// Set custom headers for RapidAPI Auth and Content-Type header
	curl_setopt($curl, CURLOPT_HTTPHEADER, [
	'Content-Type: application/json'
	]);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);


	curl_setopt($curl, CURLOPT_ENCODING, 'gzip');

	// Execute cURL request with all previous settings
	$response = curl_exec($curl);
	if(curl_errno($curl)){
    echo 'Curl error: ' . curl_error($curl);
	}
	return $response;	
}


function doRequests($urls) {
	$cache = __DIR__."/cache/Products.cache"; 
	if ($_SESSION['force_refresh'] || ((time() - filectime($cache)) > ($_SESSION['refresh']) || 0 == filesize($cache))) {
	
		$multi = curl_multi_init();
		$channels = array();

		// Loop through the URLs so request, create curl-handles,
		// attach the handle to our multi-request
		foreach ($urls as $url => $data) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS,  json_encode($data));
			curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
			curl_setopt($ch, CURLOPT_HTTPHEADER, [
				'Content-Type: application/json'
				]);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);	

			curl_multi_add_handle($multi, $ch);

			$channels[$url] = $ch;
		}
		

		// While we're still active, execute curl
		$active = null;
		do {
			$mrc = curl_multi_exec($multi, $active);
		} while ($mrc == CURLM_CALL_MULTI_PERFORM);

		while ($active && $mrc == CURLM_OK) {
			// Wait for activity on any curl-connection
			if (curl_multi_select($multi) == -1) {
				continue;
			}

			// Continue to exec until curl is ready to
			// give us more data
			do {
				$mrc = curl_multi_exec($multi, $active);
			} while ($mrc == CURLM_CALL_MULTI_PERFORM);
		}

		// Loop through the channels and retrieve the received
		// content, then remove the handle from the multi-handle
		$results = array();
		foreach ($channels as $url => $channel) {
			$results[$url] = curl_multi_getcontent($channel);
			

			/* Caching starts */
			$type = getCacheType($url, $urls[$url]);
			$cache = __DIR__."/cache/".$type.".cache"; 

			$handle = fopen($cache, 'w+') or die('no fopen');	
			$json_cache = $results[$url];
			fwrite($handle, $json_cache);
			fclose($handle);
			/* Caching Ends */

			curl_multi_remove_handle($multi, $channel);
		}

		// Close the multi-handle and return our results
		curl_multi_close($multi);
		return $results;
	}
	else {
		$results = array();
		foreach ($urls as $url => $data) {
			$type = getCacheType($url, $data);
			$cache = __DIR__."/cache/".$type.".cache"; 

			$json_cache = file_get_contents($cache); //locally
			$results[$url] = $json_cache;
		}
		return $results;
	}
}


function cachedData($type, $data){
	
	$cache = __DIR__."/cache/".$type.".cache"; 
	return file_get_contents($cache); //locally
}

function getCacheType($url, $requestLoad){
	if($url == API_URL.'api/banner/GetBanner') {
		return 'Banners';
	}
	else if($url == API_URL.'api/Product/ProductGetList') {
		return 'Products';
	}
	else if($url == API_URL.'api/Store/StoreGetList') {
		return 'Stores';
	}
	else if($url == API_URL.'api/Store/StoreGetHome') {
		return 'StoreHome';
	}
	else if($url == API_URL.'api/Store/StoreGetDetail') {
		return 'StoreGetDetail';
	}
}


function create_session($appId, $storeId){
    // API url
    $url = API_URL.'api/Login/LoginCustomer';

	if($_SESSION['USER_ID']){
		// data object
		$data = [
			'AppId' => $appId,
			'AppVersion' => 8.5,
			'DeviceId' => $_SESSION['DEVICE_ID'],
			'DeviceType' => 'W',
			'EmailId'=>$_SESSION['USER_EMAIL'],
			'LoginType'=>'E',
			'Password'=>$_SESSION['USER_PWD'],
			'StoreId'=>$_SESSION['STORE_ID'],
			'SourceId'=>'',
			'SessionId'=>'',
			'UserId'=>'',
			'UserIp'=>''
		];
	}else{
		// data object
		$data = [
			'AppId' => $appId,
			'AppVersion' => 8.5,
			'DeviceId' => $_SESSION['DEVICE_ID'],
			'DeviceType' => 'W',
			'EmailId'=>$_SESSION['USER_EMAIL'],
			'LoginType'=>'B',
			'Password'=>$_SESSION['USER_PWD'],
			'StoreId'=>$_SESSION['STORE_ID'],
			'SourceId'=>'',
			'SessionId'=>'',
			'UserId'=>'',
			'UserIp'=>''
		];
	}
//print_r($data);
    $curl = curl_init();
    $response = api_call($curl, $url, $data);
	//echo "login <br>";print_r($response);
	$session_info = json_decode($response, true);
//print_r($session_info);exit;	
	if($session_info['SessionId']){
		$_SESSION['SESSION_ID'] = $session_info['SessionId'];
		$_SESSION['USER_ID'] = $session_info['UserId'];
		$cache = __DIR__."/cache/Products.cache"; 
		unlink($cache);
		return $_SESSION['SESSION_ID'];
	}
	return $_SESSION['SESSION_ID'];
}

function slugify($title) {
	return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
}
function unslugify($title) {
	return strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', ' ', $title)));
}


function modify_url($params = [], $url = FALSE, $query_only = false) {
	// If $url wasn't passed in, use the current url
	if($url == FALSE){
	$scheme = $_SERVER['SERVER_PORT'] == 80 ? 'http' : 'https';
	$url = $scheme.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	}

	$request_arr = explode('/', $_SERVER['REQUEST_URI']);
	$length_of_uri = count($request_arr);
	if($length_of_uri>=3){
		$last_part = $request_arr[$length_of_uri-1];

		$last_part_arr = explode('?',$last_part);
		$request_arr[$length_of_uri-1] = '?'.$last_part_arr[1];
		
		$url = $scheme.'://'.$_SERVER['HTTP_HOST'].implode('/', $request_arr);
	}

	// Parse the url into pieces
	$url_array = parse_url($url);


	// The original URL had a query string, modify it.
	if(!empty($url_array['query'])){
		parse_str($url_array['query'], $query_array);
		foreach ($params as $key => $value) {
		if ($value == null) {
		unset($query_array[$key]);
		} else {
		$query_array[$key] = $value;
		}
		}
	}


	// The original URL didn't have a query string, add it.
	else{
	$query_array = $params;
	}


	if ($query_only) {
	return '?' . http_build_query($query_array);
	}


	return $url_array['scheme'].'://'.$url_array['host']. $url_array['path'].'?'.urldecode(http_build_query($query_array));
}


function http_strip_query_param($url, $param, $paramVal)
{
	$pieces = parse_url($url);
	
    $query = [];
    if ($pieces['query']) {
		parse_str($pieces['query'], $query);

		$params_arr = explode(',',$query[$param]);
		//print_r($params_arr);

		if (($key = array_search($paramVal, $params_arr)) !== false) {
			unset($params_arr[$key]);
		}
		$newparam = implode(',', $params_arr);
        $query[$param] = $newparam;
        $pieces['query'] = urldecode(http_build_query($query));
    }
	//print_r($pieces);
	//return $pieces;
	
	return $pieces['scheme'].'://'.$pieces['host']. $pieces['path'].'?'.$pieces['query'];
}

function getStoresList() {
	$store_url = API_URL.'api/Store/StoreGetList';
	$data = array("StoreId"=>$_SESSION['STORE_ID'],"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"AppId"=>$appId,"DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W");

	$type = getCacheType($store_url, $data);
	$cache = __DIR__."/cache/".$type.".cache"; 

	if(0 == filesize($cache)) {
		$ch = curl_init();
		$results = api_call($ch, $store_url, $data);

		$json_res = json_decode($results);
		//echo "SL--->";print_r($json_res);
		if($json_res->ErrorDetail !=''){
			if(create_session($appId, $storeId)){
				$redirect = $siteUrl;
				header("Location: ".$redirect);
			}
		}
		return $json_res;
	
	}
	else {
		$json_cache = file_get_contents($cache); //locally
		return json_decode($json_cache);

	}
}

function getCurrentStoreDetails(){
	$store_url = API_URL.'api/Store/StoreGetHome';
	$data = array("StoreId"=>$_SESSION['STORE_ID'],"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"AppId"=>$_SESSION['APP_ID'],"DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W");
	
	$type = getCacheType($store_url, $data);
	$cache = __DIR__."/cache/".$type.".cache"; 
	$cache_off = 1;
	if(!file_exists($cache) || 0 == filesize($cache) || $cache_off == 1) {
		$ch = curl_init();
		$results = api_call($ch, $store_url, $data);
		$json_res = json_decode($results);
		if($json_res->ErrorDetail !=''){
			if(create_session($appId, $storeId)){
				$redirect = $siteUrl;
				header("Location: ".$redirect);
			}
		}else{
		/* Caching starts */
		$handle = fopen($cache, 'w+') or die('no fopen');	
		$json_cache = $results;
		fwrite($handle, $json_cache);
		fclose($handle);
		/* Caching Ends */
		if($_SESSION['CartId'] == '' || $_SESSION['CartId'] == '0'){
			$_SESSION['CartId'] = $json_res->CustomerInfo->CartId;
		}
		return $json_res;
		}
	
	}
	else {
		$json_cache = file_get_contents($cache); //locally
		$json_res = json_decode($json_cache);
		if($_SESSION['CartId'] == '' || $_SESSION['CartId'] == '0'){
			$_SESSION['CartId'] = $json_res->CustomerInfo->CartId;
		}
		return $json_res;
	}
}



function StoreGetDetails(){
	$store_url = API_URL.'api/Store/StoreGetDetail';
	$data = array("StoreId"=>$_SESSION['STORE_ID'],"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"AppId"=>$_SESSION['APP_ID'],"DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W");
	$type = getCacheType($store_url, $data);
	$cache = __DIR__."/cache/".$type.".cache";
	$cache_off = 1;
	if(!file_exists($cache) || 0 == filesize($cache) || $cache_off == 1) {
		$ch = curl_init();
		$results = api_call($ch, $store_url, $data);
		$json_res = json_decode($results);

		if($json_res->ErrorDetail !=''){
			if(create_session($appId, $storeId)){
				$redirect = $siteUrl;
				header("Location: ".$redirect);
			}
		}else{
		/* Caching starts */
		$handle = fopen($cache, 'w+') or die('no fopen');
		$json_cache = $results;
		fwrite($handle, $json_cache);
		fclose($handle);
		/* Caching Ends */
		return json_encode($json_res);
		}

	}
	else {
		$json_cache = file_get_contents($cache); //locally
		return json_decode($json_cache);
	}
}


/**
 * Filter an array of objects.
 *
 * You can pass in one or more properties on which to filter.
 *
 * If the key of an array is an array, then it will filtered down to that
 * level of node.
 *
 * Example usages:
 * <code>
 * ofilter($items, 'size'); // filter anything that has value in the 'size' property
 * ofilter($items, ['size' => 3, 'name']); // filter anything that has the size property === 3 and a 'name' property with value
 * ofilter($items, ['size', ['user', 'forename' => 'Bob'], ['user', 'age' => 30]) // filter w/ size, have the forename value of 'Bob' on the user object of and age of 30
 * ofilter($items, ['size' => function($prop) { return ($prop > 18 && $prop < 50); }]);
 * </code>
 *
 * @param  array $array
 * @param  string|array $properties
 * @return array
 */
function ofilter($array, $properties)
{
    if (empty($array)) {
        return;
    }
    if (is_string($properties)) {
        $properties = [$properties];
    }
    $isValid = function($obj, $propKey, $propVal) {
		
        if (is_int($propKey)) {
            if (!property_exists($obj, $propVal) || empty($obj->{$propVal})) {
                return false;
            }
        } else {
            if (!property_exists($obj, $propKey)) {
                return false;
            }
            if (is_callable($propVal)) {
                return call_user_func($propVal, $obj->{$propKey});
            }
            if (strtolower(slugify($obj->{$propKey})) != strtolower($propVal)) {
                return false;
            }
        }
        return true;
    };
    return array_filter($array, function($v) use ($properties, $isValid) {
        foreach ($properties as $propKey => $propVal) {
            if (is_array($propVal)) {
                $prop = array_shift($propVal);
                if (!property_exists($v, $prop)) {
                    return false;
                }
                reset($propVal);
                $key = key($propVal);
                if (!$isValid($v->{$prop}, $key, $propVal[$key])) {
                    return false;
                }
            } else {
                if (!$isValid($v, $propKey, $propVal)) {
                    return false;
                }
            }
        }
        return true;
    });
}

function getStoreFilters(){
	$filters = __DIR__."/assets/data/store-filters.json"; 
	$json_cache = file_get_contents($filters); //locally
	return json_decode($json_cache);
}

function is_profile_updated(){
	if($_SESSION['USER_ID'] > 0 && $_SESSION['FirstName']!='' && $_SESSION['LastName']!='' && $_SESSION['DOBDt']!='' && $_SESSION['ContactNo']!=''){
		return true;
	}
	else{
		return false;
	}
}

function getTypeIdByName($category, $type){
	$filters = __DIR__."/assets/data/store-filters.json";
	$json_cache = file_get_contents($filters); //locally
	$filter_array = json_decode($json_cache);

	//print_r($filter_array->StoreFilters);
	foreach($filter_array->StoreFilters as $filters){
		if($filters->CategoryName == $category){
			foreach($filters->ListType as $fil_type){

				if($fil_type->TypeName == $type){
					return $fil_type->TypeId;
				}
			}
		}
	}
}

function compareByName($a, $b) {
  return strcmp($a->ProductName, $b->ProductName);
}
