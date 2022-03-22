<?php
$title = 'Events';

$store_details = getCurrentStoreDetails();
// API url
$url = API_URL.'api/Event/CheckEventRegister';

// data object
$data = [
	'AppId' => $appId,
	'SessionId' => $_SESSION['SESSION_ID'],
	'StoreId' => $_SESSION['STORE_ID'],
	'UserId' => $_SESSION['USER_ID']
];


$curl = curl_init();
$response = api_call($curl, $url, $data);

$events = json_decode($response, true);

if($events['ErrorDetail'] !='' || $events['Message'] == 'An error has occurred.'){
	create_session($appId, $storeId);
	$events_url = $siteUrl."/events/";
	header("Location: ".$events_url);
}
