<?php
// API url
$url = API_URL.'api/Recipe/RecipeGetDetail';

if(isset($routeParams['recipeid']) && $routeParams['recipeid'] != '' && $routeParams['recipeid'] != '0'){
	$recipeid = $routeParams['recipeid'];
}

// data object
$data = [
	'AppId' => $appId,
	'RecipeId' => $recipeid,
	'SessionId' => $_SESSION['SESSION_ID'],
	'StoreId' => $_SESSION['STORE_ID'],
	'UserId' => $_SESSION['USER_ID'],
];

//print_r($data);

$curl = curl_init();
$response = api_call($curl, $url, $data);

$recipe = json_decode($response, true);
//print_r($recipe);

if($recipe->ErrorDetail !=''){
	create_session($appId, $storeId);
	$product_url = $siteUrl."/recipe-details/".$recipeid;
	header("Location: ".$product_url);
}
?>
