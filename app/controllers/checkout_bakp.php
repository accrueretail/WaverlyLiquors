<?php
if($_SESSION['USER_ID'] == '' || $_SESSION['USER_ID'] == 0){
	$url = $siteUrl."/login?returnUrl=checkout/".$routeParams['type']."";
	header("Location: ".$url);exit;
}
$title = $siteName."-".Cart;

if(isset($routeParams['type'])){
    if($routeParams['type'] == 'pickup'){
        $orderTypeId = 1;
    }
    else if($routeParams['type'] == 'delivery'){
	 $orderTypeId = 2;
    }
    else {
        $orderTypeId = 3;
    }
}


if($orderTypeId == 2 || $orderTypeId == 3){
	$url = API_URL.'api/Customer/CustomerAddressGetList';
	$data = array("StoreId"=>$storeId,"AppId"=>$appId,"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W");

	$curl = curl_init();
	$response = api_call($curl, $url, $data);

	$addresses = json_decode($response, true);
	
	if($orders['Response']['ErrorDetail'] !=''){
		create_session($appId, $storeId);
		$redirect_url = $siteUrl."/checkout/delivery";
		header("Location: ".$redirect_url);exit;
	}
}


$store_details = getCurrentStoreDetails();

$url = API_URL.'api/Cart/CartGetDetail';
$data = array("StoreId"=>$storeId,"AppId"=>$appId,"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"CartId"=>$_SESSION['CartId'],"DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W", "IsCredentialOff"=>true, "CartDsp"=>'Y', "IsFromCheckOut"=>true, "IsToCallDSP"=>false);

$curl = curl_init();
$response = api_call($curl, $url, $data);

$json_res = json_decode($response);

if($json_res->ErrorDetail !=''){
	create_session($appId, $storeId);
	$redirect_path = $siteUrl."/checkout/".$routeParams['type'];
	header("Location: ".$redirect_path);exit;
}
else {
	$products = $json_res;
	if($json_res->TipForDriver == 0){
        $json_res->TipForDriver = -1;
        }
}

$cart_res = $json_res;

if(isset($routeParams['addr_id']) && $routeParams['addr_id'] != 't' && $routeParams['addr_id'] != 'to' && $routeParams['addr_id'] != 'sd' && $routeParams['addr_id'] != 'st'){
	$json_res->AddressId = $routeParams['addr_id'];

}
if(isset($routeParams['addr_id']) && $routeParams['addr_id'] == 't'){
	$tip_id = $routeParams['tip'];
	$cnt = 0;
	foreach($json_res->ListTipForDriver as $tip){
		if($cnt == $tip_id){
			$json_res->ListTipForDriver[$cnt]->IsDeafault = true;
			$tip_charge = $json_res->ListTipForDriver[$cnt]->TipAmount;
			$tip_charge_display = $json_res->ListTipForDriver[$cnt]->TipAmountDisplay;
		}
		else{
			$json_res->ListTipForDriver[$cnt]->IsDeafault = false;
		}
		$cnt++;
	}

	$charge_cnt = 0;
	foreach($json_res->ListCharge as 	$charge){
		if($charge->ChargeType == 'Tip For Driver'){
			$json_res->ListCharge[$charge_cnt]->ChargeAmount = $tip_charge;
			$json_res->ListCharge[$charge_cnt]->ChargeAmountDisplay = $tip_charge_display;
		}
		$charge_cnt++;
	}
	$json_res->TipForDriver = $tip_charge;
}
if(isset($routeParams['addr_id']) && $routeParams['addr_id'] == 'to'){
	$tip_amount = $routeParams['tip'];
	$tip_id = 3;
	$json_res->TipForDriver = $tip_amount;

	$cnt = 0;
	foreach($json_res->ListTipForDriver as $tip){
		if($cnt == $tip_id){
			$json_res->ListTipForDriver[$cnt]->IsDeafault = true;
			$json_res->ListTipForDriver[$cnt]->TipAmount = $tip_amount;
			$json_res->ListTipForDriver[$cnt]->TipAmountDisplay = "$".$tip_amount;
		}
		else{
			$json_res->ListTipForDriver[$cnt]->IsDeafault = false;
		}
		$cnt++;
	}

	$charge_cnt = 0;
	foreach($json_res->ListCharge as $charge){
		if($charge->ChargeType == 'Tip For Driver'){
			$json_res->ListCharge[$charge_cnt]->ChargeAmount = $tip_amount;
			$json_res->ListCharge[$charge_cnt]->ChargeAmountDisplay = "$".$tip_amount;
		}
		$charge_cnt++;
	}

}

//to set default delivery timeslot
//print_r($_SESSION);
//if($_SESSION['USER_ID']=='1385'){echo $json_res->DopDate;print_r($json_res);}
if($json_res->DoPDate == '' || $json_res->DoPDate == '01/01/1900'){
	$cnter = 0;
	foreach($json_res->ListDoPTimeSlot as $timeslots){
		if($cnter == 0){
			$json_res->DoPDate = $timeslots->DoPDate;
			$json_res->DoPTimeSlot = $timeslots->DoPSlot;
			break;
		}
		$cnter++;
	}
}

if(isset($routeParams['addr_id']) && $routeParams['addr_id'] == 'sd'){
	$slot_date = $routeParams['tip'];
	$slot_date = str_replace('-', '/', $slot_date);
	$json_res->DoPDate = $slot_date;
}

if(isset($routeParams['addr_id']) && $routeParams['addr_id'] == 'st'){
	$slot_time = $routeParams['tip'];
	$json_res->DoPTimeSlot = $slot_time;
}

$json_res->OrderTypeId = $orderTypeId;
$json_res->IsFromCheckOut = true;
$json_res->IsToCallDSP = true;
$json_res->CartDsp = 'Y';

$cart_update_url = API_URL.'api/Cart/CartUpdate';
$curl = curl_init();
$cart_update_json_response = api_call($curl, $cart_update_url, $json_res);
$cart_update_response = json_decode($cart_update_json_response);
if($cart_update_response->ErrorDetail !=''){
	create_session($appId, $storeId);
	header("Location: ".$siteUrl."/cart");exit;
}
?>
<script type="text/javascript">
localStorage.setItem('checkout_data', JSON.stringify(<?php echo $cart_update_json_response;?>)); 
</script>
<?php
//print_r($cart_update_json_response);


$payment_methods_url = API_URL.'api/Customer/CustomerGetPayMethods';
$payment_menthods_request = array("StoreId"=>$storeId,"AppId"=>$appId,"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W");
$curl = curl_init();
$payment_methods_json_response = api_call($curl, $payment_methods_url, $payment_menthods_request);
$payment_methods_response = json_decode($payment_methods_json_response);
if($payment_methods_response->ErrorDetail !=''){
	create_session($appId, $storeId);
	header("Location: ".$siteUrl."/cart");exit;
}
?>  
