<?php

if(isset($routeParams['pid'])){
	$pid_complete = $routeParams['pid'];
	$pid_struct = explode("-", $pid_complete);
	$pid_count = count($pid_struct)-1;
	//$pid = $pid_struct[$pid_count];

	$sid = $pid_struct[$pid_count];
	if(is_numeric($sid)){
		$storeId = $sid;
		$_SESSION['STORE_ID'] = $storeId;
	}
	
	$pid = $pid_struct[$pid_count-1];
}

if(isset($_POST['rating_score']) && $_POST['rating_score']>0){
	if($_SESSION['USER_ID'] == '' || $_SESSION['USER_ID'] == 0){
		$url = $siteUrl."/login?returnUrl=online/".$pid_complete;
		header("Location: ".$url);exit;
	}else{
		// API url
		if($_POST['ReviewId']>0)
		$url = API_URL.'api/Review/ReviewRatingUpdate';
		else
		$url = API_URL.'api/Review/ReviewRatingInsert';

		$data = array("StoreId"=>$storeId,"AppId"=>$appId, "PID"=>$pid, "ReviewDescription"=>addslashes($_POST['rDescription']), "ReviewRating"=>$_POST['rating_score'], "ReviewTitle"=>addslashes($_POST['rTitle']), "SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"DeviceId"=>$_SESSION['DEVICE_ID'], "DeviceType"=>"W","ReviewID"=>$_POST['ReviewId']);

		$curl = curl_init();
		$response = api_call($curl, $url, $data);
	}
	
}

// API url
$url = API_URL.'api/Product/ProductGetDetail';

// data object
$data = [
	'AppId' => $appId,
	'PID' => $pid,
	'SessionId' => $_SESSION['SESSION_ID'],
	'StoreId' => $_SESSION['STORE_ID'],
	'UserId' => $_SESSION['USER_ID'],
];
$curl = curl_init();
$response = api_call($curl, $url, $data);

$product = json_decode($response, true);
if($product['ErrorDetail'] !=''){
	create_session($appId, $storeId);
	$product_url = $siteUrl."/online/".$pid_complete;
	header("Location: ".$product_url);exit;
}
else{
if($product['Type']=='Craft Beer'){
$product['Type'] = 'Craft';
}
$product_type_id = getTypeIdByName($product['Category'], $product['Type']);
}



// API url
$rurl = API_URL.'api/Review/ReviewGetList';

// data object
$rdata = [
	'AppId' => $appId,
	'PID' => $pid,
	'SessionId' => $_SESSION['SESSION_ID'],
	'StoreId' => $_SESSION['STORE_ID'],
	'UserId' => $_SESSION['USER_ID'],
	'PageNumber' => 1,
	'PageSize' => 3,
	'DeviceId' => $_SESSION['DEVEICE_ID'],
	'DeviceType' => 'W'
];

$rcurl = curl_init();
$r_response = api_call($rcurl, $rurl, $rdata);

$reviews = json_decode($r_response, true);
?>
