<?php
if(isset($routeParams['func'])){
    $func = $routeParams['func'];
    
    if($func  == 'setStore'){
        $_SESSION['STORE_ID'] = $routeParams['category'];


        $url = API_URL.'api/Login/LoginCustomer';
        $data = array("StoreId"=>$routeParams['category'],"AppId"=>$appId,"AppVersion"=>"8.5", "EmailId"=>$_SESSION['USER_EMAIL'], "Password"=>$_SESSION['USER_PWD'], "LoginType"=>"E", "SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>"","DeviceId"=>$_SESSION['DEVICE_ID'], "DeviceType"=>"W");
        $curl = curl_init();
        $response = api_call($curl, $url, $data);
        $json_res = json_decode($response);
        
        if($json_res->SessionId != ''){
            $_SESSION['SESSION_ID'] = $json_res->SessionId;
            $_SESSION['USER_ID'] = $json_res->UserId;
            $_SESSION['USER_EMAIL'] = $_SESSION['USER_EMAIL'];
            /*$_SESSION['FirstName'] = $email;
            $_SESSION['LastName'] = $email;
            $_SESSION['ContactNo'] = $email;
            $_SESSION['Gender'] = $email;
            $_SESSION['DOB'] = $email;*/
            //$_SESSION['USER_NAME'] = $email;
        }else{
        if(create_session($appId, $storeId)){
          $curl = curl_init();
          $data = array("StoreId"=>$routeParams['category'],"AppId"=>$appId,"AppVersion"=>"8.5", "EmailId"=>$_SESSION['USER_EMAIL'], "Password"=>$_SESSION['USER_PWD'], "LoginType"=>"E", "SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>"","DeviceId"=>$_SESSION['DEVICE_ID'], "DeviceType"=>"W");
          $response = api_call($curl, $url, $data);
          $json_res = json_decode($response);

          if($json_res->SessionId != ''){
            $_SESSION['SESSION_ID'] = $json_res->SessionId;
            $_SESSION['USER_ID'] = $json_res->UserId;
            $_SESSION['USER_EMAIL'] = $_SESSION['USER_EMAIL'];
          }
        }
        }

        $cache = CACHE."/Products.cache"; 
        unlink($cache);

        $cache = CACHE."/StoreHome.cache"; 
        unlink($cache);

        $cache = CACHE."/Stores.cache"; 
        unlink($cache);

        //header('Location: '.$siteUrl);
        //print_r($data);print_r($json_res);print_r($_SESSION);exit;
    }

    if($func == 'getReviews'){
        $pid = $routeParams['status'];
        $page = $routeParams['pid'];

        $url = API_URL.'api/Review/ReviewGetList';

        if($page == 1){
            $page_size = 3;
        }else{
            $page_size = 3;
        }

        $data = array("StoreId"=>$storeId,"AppId"=>$appId,"PID"=>$pid,"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W", "PageNumber"=>$page, "PageSize"=>$page_size);

        $ch = curl_init();
        $results = api_call($ch, $url, $data);

        $json_res = json_decode($results);
        $reviews = $json_res;
        //print_r($reviews);
        //print_r($output);
        if($json_res->ErrorDetail !=''){
            if(create_session($appId, $storeId)){
                $redirect = $siteUrl."/".$product_type."/".$category;
                header("Location: ".$redirect);
            }
        }
        
    }

    if($func == 'relatedProducts'){
        $category = $routeParams['status'];
        $page = $routeParams['pid'];
        
        $out = explode('-',$page);
        $page = $out[0];
	$type = $out[1];
	
        $url = API_URL.'api/Product/ProductGetList';

        $data = array("StoreId"=>$storeId,"AppId"=>$appId,"PageSize"=>4,"PageNumber"=>$page,"IsClub"=>0,"CategoryId"=>$category,"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"SizeId"=>"","TypeId"=>$type,"VarietalId"=>"","CountryId"=>"","RegionId"=>"","IsFavorite"=>0,"IsFeatureProduct"=>0,"MaxPrice"=>"","MinPrice"=>"","KeyWord"=>"","DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W");

        $ch = curl_init();
        $results = api_call($ch, $url, $data);

        $json_res = json_decode($results);
        $output = $json_res;
        //print_r($output);
        if($json_res->ErrorDetail !=''){
            if(create_session($appId, $storeId)){
                $redirect = $siteUrl."/".$product_type."/".$category;
                header("Location: ".$redirect);
            }
        }

    }

    if($func == 'login'){
        $email = $routeParams['status'];
        $password = $routeParams['pid'];
	
	$dets = explode("-", $password);
        $password = $dets[0];
        $remember = $dets[1];

        
        if($remember){
            $passkey = 'G)w9:3qga>:U#v(';
            $method = 'aes128';
            setcookie("remember","1",time() + (10 * 365 * 24 * 60 * 60));
            setcookie("userid",openssl_encrypt($email, $method, $passkey),time() + (10 * 365 * 24 * 60 * 60), '/');
            setcookie("userkey",openssl_encrypt($password, $method, $passkey),time() + (10 * 365 * 24 * 60 * 60), '/');
	}

        if(isset($_SESSION['CartId']) && $_SESSION['CartId'] != '') {
            $cart_id = $_SESSION['CartId'];
        }
        else {
            $cart_id = 0;
        }

        $url = API_URL.'api/Login/LoginCustomer';
        $data = array("StoreId"=>$storeId,"AppId"=>$appId,"AppVersion"=>"8.5", "EmailId"=>$email, "Password"=>$password, "LoginType"=>"E", "SessionId"=>"","UserId"=>0,"DeviceId"=>$_SESSION['DEVICE_ID'], "DeviceType"=>"W");
        $curl = curl_init();
        $response = api_call($curl, $url, $data);
        $json_res = json_decode($response);
        
    
        if($json_res->SessionId != ''){
            $_SESSION['SESSION_ID'] = $json_res->SessionId;
            $_SESSION['USER_ID'] = $json_res->UserId;
            $_SESSION['USER_EMAIL'] = $email;
            $_SESSION['USER_PWD'] = $password;

            $url = API_URL.'api/Customer/ProfileGetDetail';
            $data = array("StoreId"=>$storeId, "AppId"=>$appId, "SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"DeviceId"=>$_SESSION['DEVICE_ID'], "DeviceType"=>"W");
            $curl = curl_init();
            $profile_response = api_call($curl, $url, $data);
            $profile_json_res = json_decode($profile_response);

            if($profile_json_res->FirstName !=''){
                $_SESSION['FirstName'] = $profile_json_res->FirstName;
                $_SESSION['LastName'] = $profile_json_res->LastName;
                $_SESSION['Gender'] = $profile_json_res->Gender;
                $_SESSION['DOBDt'] = $profile_json_res->DOBDt;
                $_SESSION['ContactNo'] = $profile_json_res->ContactNo;
                $_SESSION['ProfileImage'] = $profile_json_res->ProfileImage;
            }
           
        }
        else{
            //return false;
        }

    }

    if($func == 'signup'){
        $email = $routeParams['status'];
        $password = $routeParams['pid'];

        if(isset($_SESSION['CartId']) && $_SESSION['CartId'] != '') {
            $cart_id = $_SESSION['CartId'];
        }
        else {
            $cart_id = 0;
        }
        
        $url = API_URL.'api/Login/LoginCustomer';
        $data = array("StoreId"=>$storeId,"AppId"=>$appId,"AppVersion"=>"8.5", "EmailId"=>$email, "Password"=>$password, "LoginType"=>"S", "SessionId"=>"","UserId"=>"","DeviceId"=>$_SESSION['DEVICE_ID'], "DeviceType"=>"W", "SourceId"=>"", "UserIp"=>"");
        $curl = curl_init();
        $response = api_call($curl, $url, $data);
        $json_res = json_decode($response);
        //print_r($data);
        //print_r($json_res);
    
        if($json_res->SessionId != ''){
            $_SESSION['SESSION_ID'] = $json_res->SessionId;
            $_SESSION['USER_ID'] = $json_res->UserId;
            $_SESSION['USER_EMAIL'] = $email;
            $_SESSION['USER_PWD'] = $password;
            //$_SESSION['USER_NAME'] = $email;
        }
        else{
            //return false;
        }
    }

    if($func == 'logout'){
        
        $url = API_URL.'api/Login/LoginCustomer';
        $data = array("StoreId"=>$storeId,"AppId"=>$appId,"AppVersion"=>"8.5", "EmailId"=>"", "Password"=>"", "LoginType"=>"B", "SessionId"=>"","UserId"=>"","DeviceId"=>$_SESSION['DEVICE_ID'], "DeviceType"=>"W");
        $curl = curl_init();
        $response = api_call($curl, $url, $data);
        $json_res = json_decode($response);
        
        $_SESSION['SESSION_ID'] = $json_res->SessionId;
        //$_SESSION['USER_ID'] = $json_res->UserId;
	    $_SESSION['USER_ID'] = '';
	    $_SESSION['CartId'] = $_SESSION['CartId'] = 0;
        $_SESSION['USER_EMAIL'] = '';
        $_SESSION['USER_PWD'] = '';
        $_SESSION['ProfileImage'] = '';
    }

    if($func  == 'AddToCart'){

        $quanity = $routeParams['status'];
        $PID = $routeParams['pid'];
        
        if(isset($_SESSION['CartId']) && $_SESSION['CartId'] != '') {
            $cart_id = $_SESSION['CartId'];
        }
        else {
            $cart_id = 0;
        }

        $url = API_URL.'api/Cart/CartAddItem';
        $data = array("StoreId"=>$storeId,"AppId"=>$appId,"CartId"=>$cart_id,"PID"=>$PID,"Quantity"=>$quanity, "SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"DeviceId"=>$_SESSION['DEVICE_ID'], "DeviceType"=>"W");
        $curl = curl_init();
        $response = api_call($curl, $url, $data);
        $json_res = json_decode($response);
        if($json_res->ErrorDetail == 'Invalid Session.'){
            create_session($appId, $storeId);
            $response = api_call($curl, $url, $data);
            $json_res = json_decode($response);
        }
        //print_r($json_res);
        if($json_res->CartId != '' && $json_res->CartId != 0 && $json_res->CartId != '0'){
            $_SESSION['CartId'] = $json_res->CartId;
            //$_SESSION['CartItemId'] = $json_res->CartItemId;
            //$_SESSION['DealId'] = $json_res->DealId;
        }
        $cache = CACHE."/Products.cache"; 
        unlink($cache);

        //$cache = CACHE."/StoreHome.cache"; 
        //unlink($cache);
        
    }

    if($func  == 'DeleteFromCart'){

        $PID = $routeParams['pid'];
        $CartItemId = $routeParams['status'];
        
        if(isset($_SESSION['CartId']) && $_SESSION['CartId'] != '') {
            $cart_id = $_SESSION['CartId'];
        }
        else {
            $cart_id = 0;
        }

        $url = API_URL.'api/Cart/CartRemoveItem';
        $data = array("StoreId"=>$storeId,"AppId"=>$appId,"CartId"=>$cart_id,"PID"=>$PID,"CartItemId"=>$CartItemId, "DealId"=>0, "Quantity"=>1, "SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"DeviceId"=>$_SESSION['DEVICE_ID'], "DeviceType"=>"W");
        $curl = curl_init();
        $response = api_call($curl, $url, $data);
        $json_res = json_decode($response);
        if($json_res->ErrorDetail == 'Invalid Session.'){
            create_session($appId, $storeId);
            $response = api_call($curl, $url, $data);
            $json_res = json_decode($response);
        }
        //print_r($json_res);
        if($json_res->CartId != '' && $json_res->CartId != 0 && $json_res->CartId != '0'){
            $_SESSION['CartId'] = $json_res->CartId;
            //$_SESSION['CartItemId'] = $json_res->CartItemId;
            //$_SESSION['DealId'] = $json_res->DealId;
        }
        $cache = CACHE."/Products.cache"; 
        unlink($cache);

        //$cache = CACHE."/StoreHome.cache"; 
        //unlink($cache);
        
    }

    if($func == 'search'){
        $keyword = $routeParams['category'];
        
        $url = API_URL.'api/values/SearchTextValue';
        //$url = 'https://api.accrueretail.com/api/values/SearchTextValue';
        $data = array("StoreId"=>$storeId,"SearchWord"=>$keyword);

        //print_r($data);
        $curl = curl_init();
        $response = api_call($curl, $url, $data);
        $json_res = json_decode($response);
        if($json_res->ErrorDetail == 'Invalid Session.'){
            create_session($appId, $storeId);
            $response = api_call($curl, $url, $data);
            $json_res = json_decode($response);
        }
        $search_results = $json_res->hits;
        //print_r($search_results);
    }
    
    if($func  == 'getProductsByCategoryId'){
        $category = $routeParams['category'];
        if($category == 0){$category='';}

        $url = API_URL.'api/Product/ProductGetList';
        $data = array("StoreId"=>$storeId,"AppId"=>$appId,"PageSize"=>12,"PageNumber"=>1,"IsClub"=>0,"CategoryId"=>$category,"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"SizeId"=>"","TypeId"=>"","VarietalId"=>"","CountryId"=>"","RegionId"=>"","IsFavorite"=>0,"IsFeatureProduct"=>1,"MaxPrice"=>0,"MinPrice"=>0,"KeyWord"=>"","DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W");
        $curl = curl_init();
        $response = api_call($curl, $url, $data);
        $json_res = json_decode($response);
        if($json_res->ErrorDetail == 'Invalid Session.'){
            create_session($appId, $storeId);
            $response = api_call($curl, $url, $data);
            $json_res = json_decode($response);
        }
    }

    if($func  == 'getRelatedProductsByCategory'){
        $category = $routeParams['category'];
        if($category == 0){$category='';}

        $url = API_URL.'api/Product/ProductGetList';
        $data = array("StoreId"=>$storeId,"AppId"=>$appId,"PageSize"=>4,"PageNumber"=>1,"IsClub"=>0,"CategoryId"=>$category,"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"SizeId"=>"","TypeId"=>"","VarietalId"=>"","CountryId"=>"","RegionId"=>"","IsFavorite"=>0,"IsFeatureProduct"=>0,"MaxPrice"=>0,"MinPrice"=>0,"KeyWord"=>"","DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W");
        $curl = curl_init();
        $response = api_call($curl, $url, $data);
        $json_res = json_decode($response);
        if($json_res->ErrorDetail == 'Invalid Session.'){
            create_session($appId, $storeId);
            $response = api_call($curl, $url, $data);
            $json_res = json_decode($response);
        }
    }

    if($func  == 'FavoriteProductUpdate'){

        $status = $routeParams['status'];
        $PID = $routeParams['pid'];
        

        $url = API_URL.'api/Product/FavoriteProductUpdate';
        if($status == '1'){
            $wishStatus = true;
        }
        else {
            $wishStatus = false;
        }
        $data = array("StoreId"=>$storeId,"AppId"=>$appId,"FavoriteStatus"=>$wishStatus,"PID"=>$PID,"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID']);
        $curl = curl_init();
        $response = api_call($curl, $url, $data);
        $json_res = json_decode($response);
        if($json_res->ErrorDetail == 'Invalid Session.'){
            create_session($appId, $storeId);
            $response = api_call($curl, $url, $data);
            $json_res = json_decode($response);
        }
        $cache = CACHE."/Products.cache"; 
        unlink($cache);

        
    }

    if($func  == 'AddRemoveFromCart'){

        $status = $routeParams['status'];
        $PID = $routeParams['pid'];
        
        if(isset($_SESSION['CartId']) && $_SESSION['CartId'] != '') {
            $cart_id = $_SESSION['CartId'];
        }
        else {
            $cart_id = 0;
        }

        if($status == '1'){
            $wishStatus = true;
            $url = API_URL.'api/Cart/CartAddItem';
            $data = array("StoreId"=>$storeId,"AppId"=>$appId,"CartId"=>$cart_id,"PID"=>$PID,"Quantity"=>1,"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"DeviceId"=>$_SESSION['DEVICE_ID'], "DeviceType"=>"W");
        }
        else {
            $wishStatus = false;
            $url = API_URL.'api/Cart/CartRemoveItem';
            $data = array("StoreId"=>$storeId,"AppId"=>$appId,"CartId"=>$cart_id,"DealId"=>0,"PID"=>$PID,"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"DeviceId"=>$_SESSION['DEVICE_ID'], "DeviceType"=>"W");
        }
        //$data = array("StoreId"=>$storeId,"AppId"=>$appId,"CartId"=>$cart_id,"PID"=>$PID,"Quantity"=>1,"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>0,"DeviceId"=>'k96rtv92cnq', "DeviceType"=>"W");
        $curl = curl_init();
        $response = api_call($curl, $url, $data);
        $json_res = json_decode($response);
        if($json_res->ErrorDetail == 'Invalid Session.'){
            create_session($appId, $storeId);
            $response = api_call($curl, $url, $data);
            $json_res = json_decode($response);
        }
        //print_r($json_res);
        if($json_res->CartId != '' && $json_res->CartId != 0 && $json_res->CartId != '0'){
            $_SESSION['CartId'] = $json_res->CartId;
            //$_SESSION['CartItemId'] = $json_res->CartItemId;
            //$_SESSION['DealId'] = $json_res->DealId;
        }
        $cache = CACHE."/Products.cache"; 
        unlink($cache);

        //$cache = CACHE."/StoreHome.cache"; 
        //unlink($cache);
        
    }
    if($func  == 'getStoreDetails'){

        $url = API_URL.'api/Store/StoreGetHome';
        
        $data = array("StoreId"=>$storeId, "AppId"=>$appId, "IsFeatureProduct"=>1, "SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'], "DeviceId"=>$_SESSION['DEVICE_ID'], "DeviceType"=>"W");
        //print_r($data);
        $curl = curl_init();
        $response = api_call($curl, $url, $data);
        $json_res = json_decode($response);
        if($json_res->ErrorDetail == 'Invalid Session.'){
            create_session($appId, $storeId);
            $response = api_call($curl, $url, $data);
            $json_res = json_decode($response);
        }
        //print_r($json_res);
    }

    if($func  == 'AddressDelete'){
        $addressId = $routeParams['status'];
        $url = API_URL.'api/Customer/AddressDelete';

        $data = array("AddressId"=>$addressId, "StoreId"=>$storeId,"AppId"=>$appId,"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W");

        $curl = curl_init();
		$response = api_call($curl, $url, $data);
	
		$addresses = json_decode($response, true);
		
		if($orders['Response']['ErrorDetail'] !=''){
			create_session($appId, $storeId);
			$redirect_url = $siteUrl."/myaccount/manage-addresses";
			header("Location: ".$redirect_url);
		}
    }

    if($func  == 'AddressFav'){
        $addressId = $routeParams['status'];
        

        $url = API_URL.'api/Customer/CustomerAddressGetList';
		$data = array("StoreId"=>$storeId,"AppId"=>$appId,"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W");
	
		$curl = curl_init();
		$response = api_call($curl, $url, $data);
	
		$addresses = json_decode($response, true);
        //print_r($addresses);
        foreach($addresses['ListAddress'] as $address){
            if($address['AddressId'] == $addressId){
                $cur_addr = $address;
                break;
            }
        }
        //exit;
        $url = API_URL.'api/Customer/AddressUpdate';
       
        $data = array("AddressId"=>$addressId, "StoreId"=>$storeId,"AppId"=>$appId,"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W", "Address1"=>($cur_addr['Address1']), "Address2"=>($cur_addr['Address2']), "AddressName"=>($cur_addr['AddressName']), "City"=>($cur_addr['City']), "ContactNo"=>($cur_addr['ContactNo']), "Country"=>($cur_addr['Country']), "State"=>($cur_addr['State']), "Zip"=>($cur_addr['Zip']), "FirstName"=>($cur_addr['FirstName']), "LastName"=>($cur_addr['LastName']), "IsDefault"=>1, "IsProfileUpdate"=>"false" );
        $curl = curl_init();
		$response = api_call($curl, $url, $data);
	
		$addresses = json_decode($response, true);
		
		if($orders['Response']['ErrorDetail'] !=''){
			create_session($appId, $storeId);
			$redirect_url = $siteUrl."/myaccount/manage-addresses";
			header("Location: ".$redirect_url);
		}
    }

    if($func  == 'EventRegister'){
        $eventID = $routeParams['status'];
        
        $url = API_URL.'api/Login/EventCustomerLogin';
       
        $data = array("EventId"=>$eventID, "StoreId"=>$storeId, "UserId"=>$_SESSION['USER_ID']);
        $curl = curl_init();
		$response = api_call($curl, $url, $data);
	
		$event_check = json_decode($response, true);
		//print_r($event_check);
		/*if($event_check['ErrorDetail'] !=''){
			create_session($appId, $storeId);
			$redirect_url = $siteUrl."/events";
			header("Location: ".$redirect_url);
		}*/
    }

    if($func  == 'OrderCancel'){
        $orderID = $routeParams['status'];
        
        $url = API_URL.'api/Order/OrderCancel';
       
        $data = array("OrderId"=>$orderID, "StatusId"=>"1", "StoreId"=>$storeId,"AppId"=>$appId,"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W");
        $curl = curl_init();
  
		$response = api_call($curl, $url, $data);
	
		$json_res = json_decode($response, true);
        
		
		if($json_res['ErrorDetail'] !=''){
			create_session($appId, $storeId);
			$redirect_url = $siteUrl."/myaccount/myorders";
			header("Location: ".$redirect_url);
		}
    }

    if($func  == 'ReOrder'){
        $orderID = $routeParams['status'];
        
        $url = API_URL.'api/Cart/ReOrderCart';
       
        $data = array("OrderId"=>$orderID, "ListPID"=>"", "StoreId"=>$storeId,"AppId"=>$appId,"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W");
        $curl = curl_init();
  
		$response = api_call($curl, $url, $data);
	
		$json_res = json_decode($response, true);
        
		
		if($json_res['ErrorDetail'] !=''){
			create_session($appId, $storeId);
			$redirect_url = $siteUrl."/myaccount/myorders";
			header("Location: ".$redirect_url);
		}
    }

    if($func  == 'cartUpdate'){
        $addressId = $routeParams['status'];
        
        $url = API_URL.'api/Cart/CartGetDetail';
        $data = array("StoreId"=>$storeId,"AppId"=>$appId,"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"CartId"=>$_SESSION['CartId'],"DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W", "IsCredentialOff"=>true, "CartDsp"=>'Y', "IsFromCheckOut"=>false, "IsToCallDSP"=>false);

        $curl = curl_init();
        $response = api_call($curl, $url, $data);

        $json_res = json_decode($response);

        if($json_res->ErrorDetail !=''){
            create_session($appId, $storeId);
            //print_r($_SESSION);
            //unset($_SESSION['SESSION_ID']);
            header("Location: ".$siteUrl."/cart");
        }
        
        $json_res->AddressId = $addressId;
        $cart_update_url = API_URL.'api/Cart/CartUpdate';
        $curl = curl_init();
        $cart_update_json_response = api_call($curl, $cart_update_url, $json_res);
        $cart_update_response = json_decode($cart_update_json_response);
        if($cart_update_response->ErrorDetail !=''){
            create_session($appId, $storeId);
            //print_r($_SESSION);
            //unset($_SESSION['SESSION_ID']);
            header("Location: ".$siteUrl."/cart");
        }else{
            ?>
            <html><body><script>
            localStorage.setItem('checkout_data', '<?php echo $cart_update_json_response;?>'); 
            </script></body></html>
        <?php }
    }

}else{
	echo '';
}

?>
