<?php
$title = $siteName;
$urls = array(
	API_URL.'api/banner/GetBanner' => array("StoreId"=>$storeId,"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"AppId"=>$appId,"DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W"),
	API_URL.'api/Product/ProductGetList' => array("StoreId"=>$storeId,"AppId"=>$appId,"PageSize"=>12,"PageNumber"=>1,"IsClub"=>0,"CategoryId"=>"","SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"SizeId"=>"","TypeId"=>"","VarietalId"=>"","CountryId"=>"","RegionId"=>"","IsFavorite"=>0,"IsFeatureProduct"=>1,"MaxPrice"=>0,"MinPrice"=>0,"KeyWord"=>"","DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W"),
	API_URL.'api/Store/StoreGetList' => array("StoreId"=>$storeId,"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"AppId"=>$appId,"DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W"),
	//API_URL.'api/Store/StoreGetDetail' => array("StoreId"=>$storeId,"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>0,"AppId"=>$appId,"DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W"),
	API_URL.'api/Store/StoreGetHome' => array("StoreId"=>$storeId,"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"AppId"=>$appId,"DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W", "IsFeatureProduct"=>1),
	
	);
	

$results = doRequests($urls);

foreach($results as $request => $response) {
	$json_res = json_decode($response);
	
	if($json_res->ErrorDetail !='' || $json_res->Message == 'An error has occurred.'){
		create_session($appId, $storeId);
		header("Location: ".$siteUrl);exit();
	}
	else {
		if($request == API_URL.'api/banner/GetBanner'){
			$banners = $json_res->ListBanner;
		}
		else if($request == API_URL.'api/Product/ProductGetList'){
			$products = $json_res->ListProduct;
			//usort($products, 'compareByName');
		}
		else if($request == API_URL.'api/Store/StoreGetList'){
			$stores = $json_res->ListStore;
		}
		else if($request == API_URL.'api/Store/StoreGetHome'){
			$store_details = $json_res;
		}
	}
}

