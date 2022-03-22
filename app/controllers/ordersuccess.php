<?php
if($routeParams['payment_id'] != ''){
    $url = API_URL.'api/WPHostedCheckout/VerifyPayment';
    $data = array(
        "MerchantID"=>"",
        "Password"=>"",
        "PaymentId"=>$routeParams['payment_id'],
        "StoreId"=>$storeId
    );
    //print_r($data);
    $curl = curl_init();
    $response = api_call($curl, $url, $data);

    $payment_verification_response = json_decode($response);
    //print_r($payment_verification_response);
    
    /*$curl = curl_init();
    $response = api_call($curl, $url, $data);

    $payment_verification_response = json_decode($response);
    */
    if($payment_verification_response->ErrorDetail !=''){
        create_session($appId, $storeId);
        //print_r($_SESSION);
        //unset($_SESSION['SESSION_ID']);
        //header("Location: ".$siteUrl."/cart");

        $curl = curl_init();
        $response = api_call($curl, $url, $data);

        $payment_verification_response = json_decode($response);
    }else{
	    $payment_verification_response->Data->TransactionId = $routeParams['payment_id'];
	    //$payment_verification_response->Data->StatusMessage = 'AP*';
	    if($payment_verification_response->Data->DisplayMessage == 'Your transaction has been approved.'){
	    if($_SESSION['CartId'] == ''){$_SESSION['CartId']=$routeParams['cart_id'];}
             $url = API_URL.'api/Cart/OrderInsert';
            $data = array("StoreId"=>$storeId,"AppId"=>$appId,"CardInfo"=>$payment_verification_response->Data, "SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"CartId"=>$_SESSION['CartId'],"DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W", "OrderTypeId"=>$_SESSION['OrderTypeId'], "PaymentTypeId"=>8, "UserRemarks"=>addslashes($_SESSION['remarks']));
            $curl = curl_init();
            //print_r(json_encode($data));exit;
            $response = api_call($curl, $url, $data);

            $payment_response = json_decode($response);
            if($payment_response->ErrorMessage != ''){
                create_session($appId, $storeId);
                $data = array("StoreId"=>$storeId,"AppId"=>$appId,"CardInfo"=>$payment_verification_response->Data, "SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"CartId"=>$_SESSION['CartId'],"DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W", "OrderTypeId"=>$_SESSION['OrderTypeId'], "PaymentTypeId"=>8, "UserRemarks"=>addslashes($_SESSION['remarks']));
                
                $curl = curl_init();
                //print_r($data);exit;
                $response = api_call($curl, $url, $data);

                $payment_response = json_decode($response);

            }else{
                $_SESSION['CartId'] = '';
                $cache = CACHE."/Products.cache"; 
                unlink($cache);

                $cache = CACHE."/StoreHome.cache"; 
                unlink($cache);

            }
        }
    }
}
?>
