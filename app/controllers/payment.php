<?php
if($_SESSION['USER_ID'] == '' || $_SESSION['USER_ID'] == 0){
	$url = $siteUrl."/login?returnUrl=cart";
	header("Location: ".$url);
}
//print_r($_SESSION);
$title = $siteName."-".Cart;

$cart_update_response = json_decode($_POST['cartinfo']);
if(!isset($_POST['PaymentTypeId']) || $_POST['PaymentTypeId']==''){
    header("Location: ".$siteUrl."/cart");
}
else if($_POST['PaymentTypeId'] == 8){
    $pay_type='Online'; 
	$_SESSION['OrderTypeId'] = $cart_update_response->OrderTypeId;
	$_SESSION['remarks'] = $_POST['remarks'];
	
    $url = API_URL.'api/WPHostedCheckout/InitializePayment';
    $data = array(
        "CancelButton"=>"On",
        "CompleteUrl"=>$siteUrl."/success",
        "DefaultSwipe"=>"Manual",
        "DisplayStyle"=>"custom",
        "Frequency"=>"OneTime",
        "Invoice"=>"834288",
        "Memo"=>"First Name: ".$_SESSION['FirstName'].", Last Name: ".$_SESSION['LastName'].", Contact: ".$_SESSION['ContactNo'].", Email Id: ".$_SESSION['USER_EMAIL'],
        "MerchantID"=>"",
        "OperatorID"=>"834288",
        "Password"=>"",
        "ReturnUrl"=>$siteUrl."/failure",
        "StoreId"=>$storeId,
        "TaxAmount"=> $cart_update_response->TotalCharges,
        "TotalAmount"=> $cart_update_response->TotalValue,
        "TranType"=>"Sale"
);

    $curl = curl_init();
    $response = api_call($curl, $url, $data);

    $payment_initial_response = json_decode($response);

    if($payment_initial_response->ErrorDetail !=''){
        create_session($appId, $storeId);
        //print_r($_SESSION);
        //unset($_SESSION['SESSION_ID']);
        //header("Location: ".$siteUrl."/cart");exit;
    }

    //print_r($payment_initial_response);
    if($payment_initial_response->StatusCode == 200){
        $url = API_URL.'/api/WPHostedCheckout/VerifyPayment';
        $data = array(
            "MerchantID"=>"",
            "Password"=>"",
            "PaymentId"=>$payment_initial_response->Data->PaymentId,
            "StoreId"=>$storeId
        );
        //print_r($data);
        $curl = curl_init();
        $response = api_call($curl, $url, $data);

        $payment_verification_response = json_decode($response);
        //print_r($payment_verification_response);

        if($payment_verification_response->ErrorDetail !=''){
            create_session($appId, $storeId);
            //print_r($_SESSION);
            //unset($_SESSION['SESSION_ID']);
            //header("Location: ".$siteUrl."/cart");exit;
        }
    }else {
        $error = "Invalid payment method";
    }

}else if($_POST['PaymentTypeId'] == 2 || $_POST['PaymentTypeId'] == 9){
    $pay_type='Offline'; 

    $url = API_URL.'api/Cart/OrderInsert';
    $data = array("StoreId"=>$storeId,"AppId"=>$appId,"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"CartId"=>$_SESSION['CartId'],"DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W", "OrderTypeId"=>1, "PaymentTypeId"=>$_POST['PaymentTypeId'], "UserRemarks"=>addslashes($_POST['remarks']));
    $curl = curl_init();
    $response = api_call($curl, $url, $data);
    //print_r($response);
    $payment_response = json_decode($response);

    if($payment_response->ErrorDetail !=''){
        create_session($appId, $storeId);
        //print_r($_SESSION);
        //unset($_SESSION['SESSION_ID']);
        header("Location: ".$siteUrl."/cart");exit;
    }else{
        $_SESSION['CartId'] = '';
        $cache1 = CACHE."/Products.cache"; 
        unlink($cache1);

        //$cache2 = CACHE."/StoreHome.cache"; 
        //unlink($cache2);
    }

}
?>  
