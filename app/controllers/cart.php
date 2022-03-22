<?php
$title = $siteName."-".Cart;

$url = API_URL.'api/Cart/CartGetDetail';
$data = array("StoreId"=>$storeId,"AppId"=>$appId,"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"CartId"=>$_SESSION['CartId'],"DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W", "IsCredentialOff"=>true, "CartDsp"=>'Y', "IsFromCheckOut"=>false, "IsToCallDSP"=>false);

$curl = curl_init();
$response = api_call($curl, $url, $data);
$json_res = json_decode($response);

if($json_res->ErrorDetail !=''){
	create_session($appId, $storeId);
	header("Location: ".$siteUrl."/cart");exit();
}
else {
	if($_SESSION['USER_ID']>0){
	  $_SESSION['CartId'] = $json_res->CartId;
	}
	$products = $json_res;
}

$cart_res = $json_res;
/* Caching starts */
?>
<script type="text/javascript">
localStorage.setItem('CartGetDetail', JSON.stringify(<?php echo $response;?>));  
</script>
