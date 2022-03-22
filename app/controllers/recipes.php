<?php
$title = 'Recipes';

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

// API url
$url = API_URL.'api/Recipe/RecipeGetList';

// data object
$data = [
	'AppId' => $appId,
	'SessionId' => $_SESSION['SESSION_ID'],
	'StoreId' => $_SESSION['STORE_ID'],
	'UserId' => $_SESSION['USER_ID'],
	"PageNumber" => $pageNumber,
	"PageSize" => $pageSize
];



$curl = curl_init();
$response = api_call($curl, $url, $data);

$recipes = json_decode($response, true);
//print_r($recipes);
if($recipes->ErrorDetail !=''){
	create_session($appId, $storeId);
	$recipes_url = $siteUrl."/recipes/";
	header("Location: ".$recipes_url);
}
