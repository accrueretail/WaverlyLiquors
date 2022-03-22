<?php
$title = $siteName;
//$store_details = getCurrentStoreDetails();
$store_filters = getStoreFilters();
//print_r($store_details->StoreFilters);
$subs = $var_subs = $subs_keys  = $var_subs_keys = array();
foreach($store_filters->StoreFilters as $item){

foreach($item->ListType as $cats) {
    
    $subs[slugify($item->CategoryName)][slugify($cats->TypeName)] = $cats->TypeId;
    
    if(count($cats->ListVarietal)){
        
        foreach($cats->ListVarietal as $varity){
           $var_subs[slugify($item->CategoryName)][slugify($varity->VarietalName)] = $varity->VarietalId;
        }
    }

}
}

//print_r($subs);

if(isset($routeParams['product-type'])){
  $product_type = str_replace('buy-','', $routeParams['product-type']);
 
  $availables = ofilter($store_filters->StoreFilters, array('CategoryName' => $product_type));
  
  foreach($availables as $available){
  $category =  $available->CategoryId;
  break;
  }

}

if(isset($_GET['catId']) && $_GET['catId']>0){
  $category = $_GET['catId'];
}

if(isset($_GET['country_id']) && $_GET['country_id']>0){
  $country_id = $_GET['country_id'];
}

if(isset($_GET['region_id']) && $_GET['region_id']>0){
  $region_id = $_GET['region_id'];
}

if(isset($_GET['sizeId']) && $_GET['sizeId']>0){
  $sizeId = $_GET['sizeId'];
}
/*if(isset($_GET['catId']) && $_GET['catId']>0){
  $category = $_GET['catId'];
}*/

if(isset($routeParams['category'])){
  
  $type = $routeParams['category'];
  $typeId = $subs[$product_type][$type];
  if(!$typeId){
    $varietalId = $var_subs[$product_type][$type];
  }

} 

if(!isset($_GET['pageNumber']) || $_GET['pageNumber']==''){
	$pageNumber = 1;
  }
  else{
	$pageNumber = $_GET['pageNumber'];
  }
  
  if(!isset($_GET['pageSize']) || $_GET['pageSize']==''){
	$pageSize = 15;
  }
  else{
	$pageSize = $_GET['pageSize'];
  }
  
  
  /*if(isset($_GET['varietalId']) && $_GET['varietalId']!=''){
  $varietalId = $_GET['varietalId'];
  }

  if(isset($_GET['typeId']) && $_GET['typeId']!=''){
  $typeId = $_GET['typeId'];
  }*/

  if(isset($_GET['varietalId']) && $_GET['varietalId']!=''){
  $varietalId = implode(',', array_unique(explode(',',$_GET['varietalId'])));
  }else{
    if($varietalId)
    $_GET['varietalId'] = $varietalId;
  }

  if(isset($_GET['typeId']) && $_GET['typeId']!=''){
  $typeId = implode(',', array_unique(explode(',',$_GET['typeId'])));
  }else{
    if($typeId)
    $_GET['typeId'] = $typeId;
  }
  

 $prices = array('1'=>array('min'=>0, 'max'=>10), '2'=>array('min'=>10, 'max'=>25), '3'=>array('min'=>25, 'max'=>50), '4'=>array('min'=>50, 'max'=>100), '5'=>array('min'=>100, 'max'=>'Above'));
  
  if(!isset($_GET['price_id']) || $_GET['price_id']==''){
	$minPrice = $maxPrice = '';
  }
  else{
    if(isset($_GET['price_id']) && $_GET['price_id']!=''){
      $price_ids = explode(',',$_GET['price_id']);
      sort($price_ids);
      //print_r($price_ids);
      $min_id = min($price_ids);
      $max_id = max($price_ids);
      $minPrice = $prices[$min_id]['min'];
      if($prices[$max_id]['max'] == 'Above'){
        $maxPrice = 999999;
      }else{
        $maxPrice = $prices[$max_id]['max'];
      }
    }
  }

  if(!isset($_GET['keyword']) || $_GET['keyword']==''){
    $keyword = '';
    }
    else{
    $keyword = $_GET['keyword'];
    }

$url = API_URL.'api/Product/ProductGetList';

$data = array("StoreId"=>$storeId,"AppId"=>$appId,"PageSize"=>$pageSize,"PageNumber"=>$pageNumber,"IsClub"=>0,"CategoryId"=>$category,"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"SizeId"=>$sizeId,"TypeId"=>$typeId,"VarietalId"=>$varietalId,"CountryId"=>$country_id,"RegionId"=>$region_id,"IsFavorite"=>0,"IsFeatureProduct"=>0,"MaxPrice"=>$maxPrice,"MinPrice"=>$minPrice,"KeyWord"=>$keyword,"DeviceId"=>$_SESSION['DEVICE_ID'],"DeviceType"=>"W");

$ch = curl_init();
$results = api_call($ch, $url, $data);

$json_res = json_decode($results);
//print_r();
if($json_res->TotalCount > 0){
$max_pages = ceil($json_res->TotalCount/$pageSize);
if($pageNumber > $max_pages){
  //$redirect = $siteUrl."/".$routeParams['product-type']."/".$routeParams['category'];
  $redirect = modify_url(array('pageNumber'=>$max_pages));
  header("Location: ".$redirect);
}
}

if($json_res->ErrorDetail !=''){
	if(create_session($appId, $storeId)){
		$redirect = $siteUrl."/".$routeParams['product-type']."/".$routeParams['category'];
		header("Location: ".$redirect);
	}
}
