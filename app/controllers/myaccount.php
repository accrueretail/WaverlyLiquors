<?php
if(isset($routeParams['type'])){
	$type = $routeParams['type'];
	
}

if($_SESSION['USER_ID'] == '' || $_SESSION['USER_ID'] == 0){
	$url = $siteUrl."/login?returnUrl=myaccount/".$routeParams['type']."";
	header("Location: ".$url);
}

if($type == ''){
	$title = 'Profile';
	$url = API_URL.'api/Customer/ProfileGetDetail';
	$data = array("StoreId"=>$storeId,"AppId"=>$appId, "SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"DeviceId"=>$_SESSION['DEVICE_ID'], "DeviceType"=>"W");

	$curl = curl_init();
	$response = api_call($curl, $url, $data);

	$profile = json_decode($response, true);

	if($response->ErrorDetail !=''){
		create_session($appId, $storeId);
		$redirect_url = $siteUrl."/login?redirectUrl=myaccount";
		header("Location: ".$redirect_url);
	}

}
if($type == 'profile-edit'){
	$title = 'Profile';
	if(isset($_POST['pFirstName']) && $_POST['pFirstName']!=''){
		$filename = $_FILES['pImage']['name'];
    	$filedata = $_FILES['pImage']['tmp_name'];
    	$filesize = $_FILES['pImage']['size'];
		
		if(trim($_FILES['pImage']['tmp_name']) != ''){
			//$img_data = $_POST['profile_pic'];
			
			$mime_type = mime_content_type($_FILES['pImage']['tmp_name']);
			
			// Create a CURLFile object / oop method
			$cfile = new CURLFile($filedata, $mime_type, $filename); // uncomment and use if the upper procedural method is not working.

			// Assign POST data
			$imgdata = array('' => $cfile);

			$url = API_URL.'api/Customer/UploadImage';
			$headers = array("Content-Type:multipart/form-data", "Accept: application/json");
			
			$ch = curl_init();
			$options = array(
				CURLOPT_URL => $url,
				CURLOPT_HEADER => 0,
				//CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POST => 1,
				CURLOPT_HTTPHEADER => $headers,
				CURLOPT_POSTFIELDS => $imgdata,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_MAXREDIRS => 10,
  				CURLOPT_TIMEOUT => 30,
			); // cURL options
			curl_setopt_array($ch, $options);
			$response = curl_exec($ch);
			curl_close($ch);

			$profile_image = json_decode($response);
			$profile_img = $profile_image->SuccessMessage;
		}

		//profile update
		
		//profile update
		$url = API_URL."api/Customer/CustomerProfileUpdate";
		$data = array("StoreId"=>$storeId,"AppId"=>$appId, "SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"DeviceId"=>$_SESSION['DEVICE_ID'], "DeviceType"=>"W", "ContactNo"=>addslashes($_POST['pContactNo']), "DOB"=>$_POST['pDOB'], "EmailId"=>addslashes($_POST['pEmail']), "FirstName"=>addslashes($_POST['pFirstName']), "LastName"=>addslashes($_POST['pLastName']), "Gender"=>addslashes($_POST['pGender']), "UserIpAddress"=>"");
		
		if(isset($profile_img) && $profile_img!=''){
			$data["ProfileImage"] = $profile_img;
		}else{
			$data["ProfileImage"] = $_POST['profile_pic'];
		}
		
		$curl = curl_init();
		$response = api_call($curl, $url, $data);

		$profile_update = json_decode($response, true);

		if($_GET['returnURL'] != '' || $_GET['returnUrl'] != ''){
			if($_GET['returnURL'] != '')
			$url = $_GET['returnURL'];
			else
			$url = $_GET['returnUrl'];
			header("Location: ".$siteUrl."/".$url);
		}else{
			header("Location: ".$siteUrl."/myaccount");
		}

	}

	$url = API_URL.'api/Customer/ProfileGetDetail';
	$data = array("StoreId"=>$storeId,"AppId"=>$appId, "SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"DeviceId"=>$_SESSION['DEVICE_ID'], "DeviceType"=>"W");

	$curl = curl_init();
	$response = api_call($curl, $url, $data);

	$profile = json_decode($response, true);

	if($profile['ErrorDetail'] !=''){
		create_session($appId, $storeId);
		$redirect_url = $siteUrl."/login?redirectUrl=myaccount/profile-edit";
		header("Location: ".$redirect_url);
	}else{
		
		$_SESSION['FirstName'] = $profile['FirstName'];
		$_SESSION['LastName'] = $profile['LastName'];
		$_SESSION['Gender'] = $profile['Gender'];
		$_SESSION['DOBDt'] = $profile['DOBDt'];
		$_SESSION['ContactNo'] = $profile['ContactNo'];
    	$_SESSION['ProfileImage'] = $profile['ProfileImage'];
		
	}

}
if($type == 'logout'){
// API url
	$url = API_URL.'api/Login/LoginCustomer';
    $data = array("StoreId"=>$storeId,"AppId"=>$appId,"AppVersion"=>"8.5", "EmailId"=>"", "Password"=>"", "LoginType"=>"B", "SessionId"=>"","UserId"=>0,"DeviceId"=>$_SESSION['DEVICE_ID'], "DeviceType"=>"W");
    
	$_SESSION['USER_ID'] = 0;
	$_SESSION['FirstName'] = $_SESSION['LastName'] = $_SESSION['USER_NAME'] = $_SESSION['USER_PWD'] = $_SESSION['USER_EMAIL'] = $_SESSION['ProfileImage'] = '';
	$_SESSION['CartId'] = $_SESSION['CartId'] = 0;
	$curl = curl_init();
	$response = api_call($curl, $url, $data);

	$output = json_decode($response, true);
	$redirect_url = $siteUrl;
	header("Location: ".$redirect_url);
}

if($type == 'favorites'){
	$title = 'Favorites';
// API url
	$url = API_URL.'api/Product/ProductGetList';
	$pageNumber = $routeParams['addr_id'];
	if($pageNumber == '' || $pageNumber == '0'){
		$pageNumber = 1;
	}

	$data = array("StoreId"=>$storeId,"AppId"=>$appId,"PageSize"=>12,"PageNumber"=>$pageNumber,"IsClub"=>0,"CategoryId"=>"1,2,3,4","SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"SizeId"=>"","TypeId"=>"","VarietalId"=>"","CountryId"=>"","RegionId"=>"","IsFavorite"=>1,"IsFeatureProduct"=>0,"MaxPrice"=>"","MinPrice"=>"","KeyWord"=>"","DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W");

	//print_r($data);
	$curl = curl_init();
	$response = api_call($curl, $url, $data);

	$products = json_decode($response, true);
	//print_r($products);
	if($products->ErrorDetail !=''){
		create_session($appId, $storeId);
		$redirect_url = $siteUrl."/myaccount/favorites";
		header("Location: ".$redirect_url);
	}
}

if($type == 'myorders'){
		$title = 'My Orders';

		$page = $routeParams['addr_id'];
		if($page == '' || $page == '0'){
			$page = 1;
		}
		$pageSize = 10;
		// API url
		$url = API_URL.'api/Order/OrderGetList';
	
		$data = array("StoreId"=>$storeId,"AppId"=>$appId,"PageSize"=>$pageSize,"PageNumber"=>$page,"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W");
	
		$curl = curl_init();
		$response = api_call($curl, $url, $data);
	
		$orders = json_decode($response, true);
		//print_r($orders);exit;

		if($orders['Response']['ErrorDetail'] !=''){
			create_session($appId, $storeId);
			$redirect_url = $siteUrl."/myaccount/myorders";
			header("Location: ".$redirect_url);
		}
}

if($type == 'manage-addresses' || $type == 'edit-address'){
		$title = 'Manage Address';
		
		$addressId = $routeParams['addr_id'];
		$store_details = getCurrentStoreDetails();


		$url = API_URL.'api/Customer/CustomerAddressGetList';
		$data = array("StoreId"=>$storeId,"AppId"=>$appId,"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W");
	
		$curl = curl_init();
		$response = api_call($curl, $url, $data);
	
		$addresses = json_decode($response, true);
		
		if($orders['Response']['ErrorDetail'] !=''){
			create_session($appId, $storeId);
			$redirect_url = $siteUrl."/myaccount/manage-addresses";
			header("Location: ".$redirect_url);
		}

		if(isset($_POST['aAddress1']) && $_POST['aAddress1']!=''){
			if($_POST['AddressId'] == ''){
				$url = API_URL.'api/Customer/AddressInsert';
		
				$data = array("StoreId"=>$storeId,"AppId"=>$appId,"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W", "Address1"=>addslashes($_POST['aAddress1']), "Address2"=>addslashes($_POST['aAddress2']), "AddressName"=>addslashes($_POST['aAddressName']), "City"=>addslashes($_POST['aCity']), "ContactNo"=>addslashes($_POST['aContactNo']), "Country"=>addslashes($_POST['aCountry']), "State"=>addslashes($_POST['aState']), "Zip"=>addslashes($_POST['aZip']), "FirstName"=>addslashes($_POST['aFirstName']), "LastName"=>addslashes($_POST['aLastName']), "IsDefault"=>$_POST['aIsDefault'], "IsProfileUpdate"=>"false" );
				//exit;
				$curl = curl_init();
				$response = api_call($curl, $url, $data);
			
				$addresses = json_decode($response, true);
				//print_r($addresses);exit;
				if($addresses['ErrorDetail'] !=''){
					create_session($appId, $storeId);
					$redirect_url = $siteUrl."/myaccount/manage-addresses";
					//header("Location: ".$redirect_url);
				}
			}else{
				//update address
				$url = API_URL.'api/Customer/AddressUpdate';
		
				$data = array("AddressId"=>$_POST['AddressId'], "StoreId"=>$storeId,"AppId"=>$appId,"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W", "Address1"=>addslashes($_POST['aAddress1']), "Address2"=>addslashes($_POST['aAddress2']), "AddressName"=>addslashes($_POST['aAddressName']), "City"=>addslashes($_POST['aCity']), "ContactNo"=>addslashes($_POST['aContactNo']), "Country"=>addslashes($_POST['aCountry']), "State"=>addslashes($_POST['aState']), "Zip"=>addslashes($_POST['aZip']), "FirstName"=>addslashes($_POST['aFirstName']), "LastName"=>addslashes($_POST['aLastName']), "IsDefault"=>$_POST['aIsDefault'], "IsProfileUpdate"=>"false" );
				//exit;
				$curl = curl_init();
				$response = api_call($curl, $url, $data);
			
				$addresses = json_decode($response, true);
				//print_r($addresses);exit;
				if($addresses['ErrorDetail'] !=''){
					create_session($appId, $storeId);
					$redirect_url = $siteUrl."/myaccount/manage-addresses";
					//header("Location: ".$redirect_url);
				}

			}
		
		
			// if(isset($_POST['pFirstName']) && $_POST['pFirstName']!='') {
				// // API url
				// $url = API_URL.'api/Customer/CustomerProfileUpdate';
			
				// $data = array("StoreId"=>$storeId,"AppId"=>$appId,"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W", "FirstName"=>addslashes($_POST['pFirstName']), "LastName"=>addslashes($_POST['pLastName']), "Gender"=>addslashes($_POST['Gender']), "EmailId"=>addslashes($_POST['EmailId']), "ContactNo"=>addslashes($_POST['pContactNo']));
			
				// $curl = curl_init();
				// $response = api_call($curl, $url, $data);
			
				// $addresses = json_decode($response, true);
				// //print_r($addresses);exit;
				// if($addresses['ErrorDetail'] !=''){
					// create_session($appId, $storeId);
					// $redirect_url = $siteUrl."/myaccount/manage-addresses";
					// //header("Location: ".$redirect_url);
				// }
			// }

		if($_POST['redirectURL'] != '')
		$redirect_url = $siteUrl."/".$_POST['redirectURL'];
		else
		$redirect_url = $siteUrl."/myaccount/manage-addresses";
			
		header("Location: ".$redirect_url);
	}
}


function img_to_bin($file, $scale = 100, $fudge = 0) {

    if (!is_int($scale)) {
        throw new InvalidArgumentException('Scale argument invalid expecting int, got: '.gettype($scale));
    }

    $info = getimagesize($file);
    $mime = $info['mime'];

    switch ($mime) {
        case 'image/jpeg':
            $image_create = 'imagecreatefromjpeg';
            break;

        case 'image/png':
            $image_create = 'imagecreatefrompng';
            break;

        case 'image/gif':
            $image_create = 'imagecreatefromgif';
            break;

        default: 
            throw new InvalidArgumentException('Unsupported image type: '.$mime);
    }

    $return = null;

    $img = $image_create($file);
    $img = imagescale($img, $scale, $scale);

    $width = imagesx($img);
    $height = imagesy($img);

    for ($y=0; $y < $height; $y++) {
        $line = [];
        for ($x=0; $x < $width; $x++) {
            // get current pixel colour
            $rgb = imagecolorat($img, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8 ) & 0xFF;
            $b = $rgb & 0xFF;
            $pixel = ($r + $g + $b)/3;

            // value above 0(white) is 1 
            if ($pixel > $fudge) {
                $line[] = "1";
            } else {
                $line[] = "0";
            }
        }

        $return .= implode('', $line).PHP_EOL;
    }
    return $return;
}

?>
