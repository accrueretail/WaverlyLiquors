<?php
$title = $siteName;

$url = API_URL.'api/Product/ProductGetList';

//pagination
if(!isset($_GET['pageNumber']) || $_GET['pageNumber']==''){
	$pageNumber = 1;
  }
  else{
	$pageNumber = $_GET['pageNumber'];
  }
  
  if(!isset($_GET['pageSize']) || $_GET['pageSize']==''){
	$pageSize = 12;
  }
  else{
	$pageSize = $_GET['pageSize'];
  }

$data = array("StoreId"=>$storeId,"AppId"=>$appId,"PageSize"=>$pageSize,"PageNumber"=>$pageNumber,"IsClub"=>0,"CategoryId"=>"","SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"SizeId"=>"","TypeId"=>"","VarietalId"=>"","CountryId"=>"","RegionId"=>"","IsFavorite"=>0,"IsFeatureProduct"=>1,"MaxPrice"=>0,"MinPrice"=>0,"KeyWord"=>"","DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W");

$curl = curl_init();
$response = api_call($curl, $url, $data);
$json_res = json_decode($response);
if($json_res->ErrorDetail == 'Invalid Session.'){
	create_session($appId, $storeId);
	$response = api_call($curl, $url, $data);
	$json_res = json_decode($response);
	
}
else {
	
	$products = $json_res->ListProduct;
	
	
}
$max_pages = ceil($json_res->TotalCount/$pageSize);
if($pageNumber > $max_pages){
	//$redirect = $siteUrl."/".$routeParams['product-type']."/".$routeParams['category'];
	$redirect = modify_url(array('pageNumber'=>$max_pages));
	header("Location: ".$redirect);
  }

if($json_res->ErrorDetail !=''){
	if(create_session($appId, $storeId)){
		$redirect = $siteUrl."/".$routeParams['product-type']."/".$routeParams['category'];
		header("Location: ".$redirect);
	}
}


