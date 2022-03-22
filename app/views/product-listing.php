<?php
$title = ucfirst($product_type);

if($type!='')
{
  $type_title = ucwords(unslugify($type));
$pro_title = "Order or Buy ".$type_title." Online | ".$title." Delivered from ".$store_details->StoreName.", ".$store_details->City.", ".$store_details->State;
$meta_desc = "Order or buy ".$type_title." online from ".$store_details->StoreName." in ".$store_details->City.", ".$store_details->State. ". Get ".$title." delivered to your doorstep or for a curbside pick up from the leading ".$title." store - ".$store_details->StoreName.", ".$store_details->City.", ".$store_details->State;
}
else if($title!='Search'){
$pro_title = "Order or Buy ".$title." Online | ".$title." Delivered from ".$store_details->StoreName.", ".$store_details->City.", ".$store_details->State;
$meta_desc = "Order or buy ".$title." online from ".$store_details->StoreName." in ".$store_details->City.", ".$store_details->State. ". Get ".$title." delivered to your doorstep or for a curbside pick up from the leading ".$title." store - ".$store_details->StoreName.", ".$store_details->City.", ".$store_details->State;
}
else {
$pro_title = "Order or Buy Beer, Liquor, Wine Online | Beer, Liquor, Wine Delivered from ".$store_details->StoreName.", ".$store_details->City.", ".$store_details->State;
$meta_desc = "Order or buy Beer, Liquor, Wine online from ".$store_details->StoreName." in ".$store_details->City.", ".$store_details->State. ". Get Beer, Liquor, Wine delivered to your doorstep or for a curbside pick up from the leading store - ".$store_details->StoreName.", ".$store_details->City.", ".$store_details->State;
}
loadView('header', array('title' => $pro_title, 'store_details' => $store_details, 'meta_desc' => $meta_desc));


if(!isset($store_details)) {
$store_details = json_decode(cachedData('StoreHome', []));
}

$store_filters = getStoreFilters();
?>

<div  class="container sresult">
  <div  class="row">
    <div  class="Search_div col-md-12 col-sm-12 col-lg-12 col-xs-12">
      <h4>Search Results</h4>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
	<a href="<?php echo $siteUrl; ?>">Home</a>
        </li>
        <li  class="breadcrumb-item">
          Search Categories
        </li>
      </ol>
    </div>
  </div>
</div>

<?php
$all_categories = $all_sizes = $all_countries = $all_regions = [];
foreach($store_filters->StoreFilters as $item){

  foreach($item->ListSize as $search_size){
    $all_sizes[$search_size->SizeId] = $search_size->UnitSize;
  }
  if($_currentRoute == 'search' || strpos($_currentRoute, 'buy-wine') !== false){
      $query_countries = explode(',',$_GET['country_id']);
      $query_regions = explode(',',$_GET['region_id']);
      $query_sizes = explode(',',$_GET['sizeId']);
      
      foreach($item->ListCountries as $countries){
        if(in_array($countries->CountryId, $query_countries)){
          $selected_countries[$countries->CountryId] = $countries->CountryName;
        }
        $all_countries[$countries->CountryId] = $countries->CountryName;
        foreach($countries->ListRegions as $regions){
          if(in_array($regions->RegionId, $query_regions)){
          $selected_regions[$regions->RegionId] = $regions->RegionName;
          }
          $all_regions[$regions->RegionId] = $regions->RegionName;
        }
      }   

     foreach($all_sizes as $sizeId => $sizeName){
        //print_r($sizeIds);
        if(in_array($sizeId, $query_sizes)){
          $selected_sizes[$sizeId] = $sizeName;
        }
        
      } 

  }
  
  //print_r($item);
  foreach($item->ListSize as $search_size){
    $all_sizes[$search_size->SizeId] = $search_size->UnitSize;
  }
  $all_categories[$item->CategoryId] = $item->CategoryName;
  if($item->CategoryId == $category) {
    $subs = $var_subs = $selected_types = $selected_varietals = $selected_cats =  array();
    $query_types = explode(',',$_GET['typeId']);
    $query_varietals = explode(',',$_GET['varietalId']);
    $query_sizes = explode(',',$_GET['sizeId']);
    $query_cats = explode(',',$_GET['catId']);
    
    if(isset($_GET['catId']) && $_GET['catId'] != ''){
        
        if(in_array($item->CategoryId, $query_cats)){
          $selected_cats[$item->CategoryId] = $item->CategoryName;
        }
      }
    
    foreach($item->ListType as $cats) {

      if(isset($_GET['typeId']) && $_GET['typeId']!=''){
          $type_ids = $_GET['typeId'].','.$cats->TypeId;
      }
      else
      $type_ids = $cats->TypeId;

      if(isset($_GET['typeId']) && $_GET['typeId'] != ''){
        
        if(in_array($cats->TypeId, $query_types)){
          $selected_types[$cats->TypeId] = $cats->TypeName;
        }
      }

      /*if(in_array($cats->TypeId, explode(',', $_GET['typeId'])))
      continue;

      //echo $type_ids;
      $newurl = modify_url(array('typeId'=>$type_ids));
      $submenu_path = '<a href="'.$newurl.'" type_id="'.$cats->TypeId.'">'.$cats->TypeName.'</a>';*/

      if(in_array($cats->TypeId, explode(',', $_GET['typeId']))){

        $type_ids_new = implode(',',array_unique(explode(',',$type_ids)));

        $newurl = modify_url(array('typeId'=>$type_ids_new));
        $newurl = http_strip_query_param($newurl, 'typeId', $cats->TypeId);
        $submenu_path = '<a class="active" href="'.$newurl.'" type_id="'.$cats->TypeId.'">'.$cats->TypeName.'</a>';
      }else{
        $type_ids_new = implode(',',array_unique(explode(',',$type_ids)));
        $newurl = modify_url(array('typeId'=>$type_ids_new));
        $submenu_path = '<a href="'.$newurl.'" type_id="'.$cats->TypeId.'">'.$cats->TypeName.'</a>';
      }

    
      if(array_key_exists($cats->SortNumber, $subs))
      $subs[] = $submenu_path;
      else
      $subs[$cats->SortNumber] = $submenu_path;

      if(count($cats->ListVarietal)){

      foreach($cats->ListVarietal as $varity){

       if(isset($_GET['varietalId']) && $_GET['varietalId']!=''){
          $varital_ids = $_GET['varietalId'].','.$varity->VarietalId;
        }
        else
        $varital_ids = $varity->VarietalId;

        if(isset($_GET['varietalId']) && $_GET['varietalId'] != ''){
        
          if(in_array($varity->VarietalId, $query_varietals)){
            $selected_varietals[$varity->VarietalId] = $varity->VarietalName;
          }
        }

        /*if(in_array($varity->VarietalId, explode(',', $_GET['varietalId'])))
        continue;

        //echo $type_ids;
        $newurl = modify_url(array('varietalId'=>$varital_ids));
        $submenu_path = '<a href="'.$newurl.'" varietal_id="'.$varity->VarietalId.'">'.$varity->VarietalName.'</a>';*/

        if(in_array($varity->VarietalId, explode(',', $_GET['varietalId']))){

        $varietal_ids_new = implode(',',array_unique(explode(',',$varital_ids)));

        $newurl = modify_url(array('varietalId'=>$varietal_ids_new));
        $newurl = http_strip_query_param($newurl, 'varietalId', $varity->VarietalId);
        $submenu_path = '<a class="active" href="'.$newurl.'" varietal_id="'.$varity->VarietalId.'">'.$varity->VarietalName.'</a>';
      }else{
        $varietal_ids_new = implode(',',array_unique(explode(',',$varital_ids)));
        $newurl = modify_url(array('varietalId'=>$varietal_ids_new));
        $submenu_path = '<a href="'.$newurl.'" varietal_id="'.$varity->VarietalId.'">'.$varity->VarietalName.'</a>';
      }

        

          if(array_key_exists($varity->SortNumber, $var_subs))
          $var_subs[] = $submenu_path;
          else
          $var_subs[$varity->SortNumber] = $submenu_path;
      }
    }

    }
    ksort($subs);
    ksort($var_subs);

    $sizes = $selected_sizes = array();
    foreach($item->ListSize as $size){
      //print_r($size);

      if(isset($_GET['sizeId']) && $_GET['sizeId']!=''){
        $size_ids = $_GET['sizeId'].','.$size->SizeId;
      }
      else
      $size_ids = $size->SizeId;

      if(isset($_GET['sizeId']) && $_GET['sizeId'] != ''){
        
        if(in_array($size->SizeId, $query_sizes)){
          $selected_sizes[$size->SizeId] = $size->UnitSize;
        }
      }

      /*if(in_array($size->SizeId, explode(',', $_GET['sizeId'])))
      continue;
      
      //echo $type_ids;
      $newurl = modify_url(array('sizeId'=>$size_ids));
      $submenu_path = '<a href="'.$newurl.'" size_id="'.$size->SizeId.'">'.$size->UnitSize.'</a>';*/

      if(in_array($size->SizeId, explode(',', $_GET['sizeId']))){

        $size_ids_new = implode(',',array_unique(explode(',',$size_ids)));

        $newurl = modify_url(array('sizeId'=>$size_ids_new));
        $newurl = http_strip_query_param($newurl, 'sizeId', $size->SizeId);
        $submenu_path = '<a class="active" href="'.$newurl.'" size_id="'.$size->SizeId.'">'.$size->UnitSize.'</a>';
      }else{
        $size_ids_new = implode(',',array_unique(explode(',',$size_ids)));
        $newurl = modify_url(array('sizeId'=>$size_ids_new));
        $submenu_path = '<a href="'.$newurl.'" size_id="'.$size->SizeId.'">'.$size->UnitSize.'</a>';
      }

      if(array_key_exists($size->SortNumber, $sizes))
      $sizes[] = $submenu_path;
      else
      $sizes[$size->SortNumber] = $submenu_path;
    }
    ksort($sizes);
  }
}
  ?>

<div  class="col-md-3 col-sm-3 col-lg-3 col-xs-12">
<div class="product-accordion">
<div class="panel-group" id="accordion">
  <?php
  $flag = 0;
  $f_class = 'collapse';
  if(count($selected_types) > 0 || count($selected_varietals) > 0 || count($selected_sizes) > 0 ||  $_GET['price_id']!='' ||  $_GET['country_id']!='' ||  $_GET['region_id']!='' || (isset($_GET['keyword']) && $_GET['keyword']!=''))
  {
    $flag = 1;
    $f_class = 'expand';
  }
  ?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h4 data-toggle="collapse" data-parent="#accordion" href="#collapse1" class="panel-title expand">
      <div class="right-arrow pull-right"></div>
      <a href="#">Filter</a>
    </h4>
  </div>
  <div id="collapse1" class="panel-collapse  <?php echo $f_class; ?>">
    <div class="panel-body"> 
      <ul class="left-panel-body search-history <?php echo $f_class; ?> in">
        
        <li class="filters_selected">
          
          <input type="hidden" name="typeId" id="typeId" value="<?php echo $_GET['typeId']; ?>">
          <?php
          $selected_categories = explode(',',$_GET['catId']);
          //print_r($all_categories);
          /*print_r($selected_types);
          print_r($selected_varietals);
          */
          //print_r($selected_sizes);
        $current_url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
  	    $current_url = modify_url($current_url);
  	    if($_currentRoute == 'search'){
            foreach($selected_categories as $skey => $stype){
                if($stype>0){
                $newurl = http_strip_query_param($current_url, 'catId', $stype);
                echo '<a href="'.$newurl.'">'.$all_categories[$stype].' <i class="fa fa-close"></i></a>';
                }
              }
            }else{
              foreach($selected_cats as $skey => $stype){
                $newurl = http_strip_query_param($current_url, 'catId', $skey);
                echo '<a href="'.$newurl.'">'.$stype.' <i class="fa fa-close"></i></a>';
              }
            }

			//print_r($selected_types);
			foreach($selected_types as $skey => $stype){
			
				//if(count($selected_types) <= 1 && (strtolower($routeParams['category']) == strtolower($stype))){
					//$current_url =
					$cat_str = slugify(strtolower($stype)).'/';
					$t_current_url = str_replace($cat_str, '', $current_url);					
				//}
				
				$newurl = http_strip_query_param($t_current_url, 'typeId', $skey);
				echo '<a href="'.$newurl.'">'.$stype.' <i class="fa fa-close"></i></a>';
			}
			foreach($selected_varietals as $skey => $stype){
				$cat_str = slugify(strtolower($stype)).'/';
				$v_current_url = str_replace($cat_str, '', $current_url);
					
				$newurl = http_strip_query_param($v_current_url, 'varietalId', $skey);
				echo '<a href="'.$newurl.'">'.$stype.' <i class="fa fa-close"></i></a>';
			}

          foreach($selected_sizes as $skey => $stype){
            $newurl = http_strip_query_param($current_url, 'sizeId', $skey);
            echo '<a href="'.$newurl.'">'.$stype.' <i class="fa fa-close"></i></a>';
          }
          
          if(isset($_GET['price_id']) && $_GET['price_id']!='') {
            $selected_prices = explode(',',$_GET['price_id']);
            foreach($selected_prices as $sel_price){
              $newurl = http_strip_query_param($current_url, 'price_id', $sel_price);
              echo '<a href="'.$newurl.'">$'.$prices[$sel_price]['min'].' - $'.$prices[$sel_price]['max'].' <i class="fa fa-close"></i></a>';
            }
          }

          if(isset($_GET['keyword']) && $_GET['keyword'] != '') {
            $newurl = http_strip_query_param($current_url, 'keyword', $_GET['keyword']);
            echo '<a href="'.$newurl.'">'.$_GET['keyword'].' <i class="fa fa-close"></i></a>';
          }

          foreach($selected_countries as $skey => $stype){
            $newurl = http_strip_query_param($current_url, 'country_id', $skey);
            echo '<a href="'.$newurl.'">'.$stype.' <i class="fa fa-close"></i></a>';
          }

          foreach($selected_regions as $skey => $stype){
            $newurl = http_strip_query_param($current_url, 'region_id', $skey);
            echo '<a href="'.$newurl.'">'.$stype.' <i class="fa fa-close"></i></a>';
          }
          ?>
        </li>
      </ul>
    </div>
  </div>
</div>
<?php if($_currentRoute == 'search'){ ?>
<div class="panel panel-default">
<div class="panel-heading">
<h4 data-toggle="collapse" data-parent="#accordion" href="#collapse21" class="panel-title">
<div class="right-arrow pull-right"></div>
<a href="#">Categories</a>
</h4>
</div>
<div id="collapse21" class="panel-collapse collapse">
<div class="panel-body">
<ul class="left-panel-body">
<li>
<?php 
if($_currentRoute == 'search'){
  //print_r($all_categories);
  foreach($all_categories as $cat_id => $cu_cat){
     if(isset($_GET['catId']) && $_GET['catId']!=''){
        $cat_ids = $_GET['catId'].','.$cat_id;
      }
      else{
        $cat_ids = $cat_id;
      }
    $newurl = modify_url(array('catId'=>$cat_ids));
    echo '<a href="'.$newurl.'" catId="'.$cat_id.'">'.ucfirst(unslugify($cu_cat)).'</a>';
  }
}
?>
</li>
</ul>
</div>
</div>
</div>
<?php } ?>
<div class="panel panel-default">
<div class="panel-heading">
<h4 data-toggle="collapse" data-parent="#accordion" href="#collapse2" class="panel-title">
<div class="right-arrow pull-right"></div>
<a href="#">Type</a>
</h4>
</div>
<div id="collapse2" class="panel-collapse collapse">
<div class="panel-body">
<ul class="left-panel-body">
<li>
<?php 
if($_currentRoute == 'search' && $_GET['catId']<=0){
  //print_r($subs);
  foreach($all_categories as $cu_cat){
    //print_r(slugify($cu_cat));
   // print_r($subs[slugify($cu_cat)]);
  foreach($subs[slugify($cu_cat)] as $key => $sub){
    $newurl = modify_url(array('typeId'=>$sub));
    echo '<a href="'.$newurl.'" type_id="'.$sub.'">'.ucfirst(unslugify($key)).'</a>';
  }
  }

}else{
  foreach($subs as $sub){
  echo $sub;
  }
} ?>
</li>
</ul>
</div>
</div>
</div>
<?php
/*if(in_array($category, array(1, 3)) || in_array($_GET['catId'], array(1, 3)) || $_currentRoute == 'search') {*/
if(in_array($category, array(1, 3)) || in_array($_GET['catId'], array(1, 3)) || strpos($_GET['catId'], '1')  || strpos($_GET['catId'], '3') || ($_currentRoute == 'search' && $_GET['catId'] == '')) {?>
<div class="panel panel-default">
<div class="panel-heading">
<h4 data-toggle="collapse" data-parent="#accordion" href="#collapse3" class="panel-title">
<div class="right-arrow pull-right"></div>
<a href="#">VARIETAL</a>
</h4>
</div>
<div id="collapse3" class="panel-collapse collapse">
<div class="panel-body">
<ul class="left-panel-body">
<li>
<?php 
if($_currentRoute == 'search' && $_GET['catId']<=0){
  //print_r($subs);
  foreach($all_categories as $cu_cat){
    //print_r(slugify($cu_cat));
   // print_r($subs[slugify($cu_cat)]);
  foreach($subs[slugify($cu_cat)] as $key => $sub){
    $newurl = modify_url(array('varietalId'=>$sub));
    echo '<a href="'.$newurl.'" varietalId="'.$sub.'">'.ucfirst(unslugify($key)).'</a>';
  }
  }

}else{
foreach($var_subs as $sub){
echo $sub;
}} ?>
</li>
</ul>
</div>
</div>
</div>
<?php } ?>
<div class="panel panel-default">
<div class="panel-heading">
<h4 data-toggle="collapse" data-parent="#accordion" href="#collapse4" class="panel-title">
<div class="right-arrow pull-right"></div>
<a href="#">Size</a>
</h4>
</div>
<div id="collapse4" class="panel-collapse collapse">
<div class="panel-body">
<ul class="left-panel-body">
<li>
<?php
//print_r($all_sizes);
if($_currentRoute == 'search' && $_GET['catId']<=0){
  foreach($all_sizes as $size_key => $size){
    $newurl = modify_url(array('sizeId'=>$size_key));
    echo '<a href="'.$newurl.'" sizeId="'.$size_key.'">'.ucfirst(unslugify($size)).'</a>';
  }

}else{
foreach($sizes as $sub){
echo $sub;
}
} ?>
</li>
</ul> 
</div>
</div>
</div>

<?php if($_currentRoute == 'search' || strpos($_currentRoute, 'buy-wine') !== false){ ?>
<?php if($_GET['catId'] == '' || strpos($_GET['catId'], '3') !== false){ ?>
<div class="panel panel-default">
<div class="panel-heading">
<h4 data-toggle="collapse" data-parent="#accordion" href="#collapse6" class="panel-title">
<div class="right-arrow pull-right"></div>
<a href="#">Country</a>
</h4>
</div>
<div id="collapse6" class="panel-collapse collapse">
<div class="panel-body">
<ul class="left-panel-body">
<li>
  <?php foreach($all_countries as $country_id => $country){
      if(isset($_GET['country_id']) && $_GET['country_id']!=''){
        $country_ids = $_GET['country_id'].','.$country_id;
      }
      else
      $country_ids = $country_id;

      $country_ids = implode(',', array_unique(explode(',',$country_ids)));

      if(in_array($country_id,explode(',', $_GET['country_id']))){
        $newurl = modify_url(array('country_id'=>$country_ids));
        $newurl = http_strip_query_param($newurl, 'country_id', $country_id);
        
    ?>
    <a class="active" href="<?php echo $newurl;?>"><?php echo $country;?></a>
    <?php } else{ ?>
    <a href="<?php echo $newurl = modify_url(array('country_id'=>$country_ids));?>"><?php echo $country;?></a>
    <?php }} ?>
</li>
</ul> 
</div>
</div>
</div>

<div class="panel panel-default">
<div class="panel-heading">
<h4 data-toggle="collapse" data-parent="#accordion" href="#collapse7" class="panel-title">
<div class="right-arrow pull-right"></div>
<a href="#">Region</a>
</h4>
</div>
<div id="collapse7" class="panel-collapse collapse">
<div class="panel-body">
<ul class="left-panel-body">
<li>
  <?php foreach($all_regions as $region_id => $region){
      if(isset($_GET['region_id']) && $_GET['region_id']!=''){
        $region_ids = $_GET['region_id'].','.$region_id;
      }
      else
      $region_ids = $region_id;

      $region_ids = implode(',', array_unique(explode(',',$region_ids)));

      if(in_array($region_id,explode(',', $_GET['region_id']))){
        $newurl = modify_url(array('region_id'=>$region_ids));
        $newurl = http_strip_query_param($newurl, 'region_id', $region_id);
        
    ?>
    <a class="active" href="<?php echo $newurl;?>"><?php echo $region;?></a>
    <?php } else{ ?>
    <a href="<?php echo $newurl = modify_url(array('region_id'=>$region_ids));?>"><?php echo $region;?></a>
    <?php }} ?>
</li>
</ul> 
</div>
</div>
</div>
<?php } ?>
<?php } ?>

<div class="panel panel-default">
<div class="panel-heading">
<h4 data-toggle="collapse" data-parent="#accordion" href="#collapse5" class="panel-title ">
<div class="right-arrow pull-right"></div>
<a href="#">Price</a>
</h4>
</div>
<div id="collapse5" class="panel-collapse collapse">
<div class="panel-body">
<ul class="left-panel-body">
<li>
  <?php
  $prices = array('1'=>array('min'=>0, 'max'=>10), '2'=>array('min'=>10, 'max'=>25), '3'=>array('min'=>25, 'max'=>50), '4'=>array('min'=>50, 'max'=>100), '5'=>array('min'=>100, 'max'=>'Above'));
  
  foreach($prices as $price_key => $price){
    if(isset($_GET['price_id']) && $_GET['price_id']!=''){
        $price_ids = $_GET['price_id'].','.$price_key;
      }
      else
      $price_ids = $price_key;

      $price_ids = implode(',', array_unique(explode(',',$price_ids)));

      if(in_array($price_key,explode(',', $_GET['price_id']))){
        $newurl = modify_url(array('price_id'=>$price_ids));
        $newurl = http_strip_query_param($newurl, 'price_id', $price_key);
        ?>
        <a class="active" href="<?php echo $newurl;?>" price_id="<?php echo $price_key;?>" min="0" max="10">$<?php echo $price['min'];?> - $<?php echo $price['max']; ?></a>
        <?php 
      } else{
  ?>
  <a href="<?php echo $newurl = modify_url(array('price_id'=>$price_key));?>" price_id="<?php echo $price_key;?>" min="0" max="10">$<?php echo $price['min'];?> - $<?php echo $price['max']; ?></a>
  <?php } 
      }
  ?>
  </li>
</ul> 
</div>
</div>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    <h4 class="panel-title expand">
      <div class="right-arrow pull-right"></div>
      <?php if($_currentRoute == 'search'){ ?>
        <a href="<?php echo $siteUrl."/search";?>" class="bottles-brand">Clear Search</a>
      <?php } else{ ?>
      <a href="<?php echo $siteUrl."/".$routeParams['product-type'];?>"  class="bottles-brand">Clear Search</a>
      <?php } ?>
    </h4>
  </div>
  
</div>

</div>  
</div>
</div>

<!--right section start-->
<?php
$total_products = $json_res->TotalCount;
//echo 'Total-----'.$total_products;
$no_of_pages = ceil($total_products/$pageSize);
$end = $pageNumber*$pageSize;
$start = $end-$pageSize+1;

if($total_products < $end){
  $end = $total_products;
}

$product_page_url = $siteUrl."/".$product_type."/".$category;
?>
<div  class="col-md-9 col-sm-9 col-lg-9 col-xs-12">
<?php if($total_products>0){?>
<div  class="continer-right">
<div  class="row margin_bottom_35">
  <div  class="col-md-4 col-sm-12">
    <p  class="text_transform"> Showing <?php echo $start;?>-<?php echo $end;?> of <?php echo $total_products;?> Products </p>
  </div>
  <div  class="col-md-6 col-sm-8">
  <div  class="page-navigation">
    <?php if($no_of_pages>1){?>
    <ul class="pagination">
      <li class="page-item <?php if($pageNumber <= 1){?>disabled<?php } ?>">
        <a aria-label="First" class="page-link prev_next" href="<?php echo modify_url(array('pageNumber'=>1));?>" tabindex="-1" page="1">
          <span aria-hidden="true">««</span>
        </a>
      </li>
      <li class="page-item <?php if($pageNumber <= 1){?>disabled<?php } ?>">
        <a aria-label="Previous" class="page-link prev_next" href="<?php echo modify_url(array('pageNumber'=>$pageNumber-1));?>" tabindex="-1" page="<?php echo $pageNumber-1; ?>">
          <span aria-hidden="true">«</span>
        </a>
      </li>
      <?php ?>
      <li class="page-item <?php if($pageNumber == 1){echo 'active';}?>">
        <a class="page-link" href="<?php echo modify_url(array('pageNumber'=>1));?>"> 1 
          <span class="sr-only">(current)</span>
        </a>
      </li>
      <?php if($pageNumber>=5){ ?>
      <li class="page-item disabled">
        <a class="page-link">...</a>
      </li>
      <?php } ?>

      <?php for($i=$pageNumber-2; $i<=$pageNumber-1;$i++){ if($i>1){?>
        <li class="page-item <?php if($pageNumber == $i){echo 'active';}?>">
        <a class="page-link <?php echo $i;?>" href="<?php echo modify_url(array('pageNumber'=>$i));?>" > <?php echo $i;?> </a>
      </li>
      <?php }} ?>
      <?php for($i=$pageNumber; $i<=$pageNumber+2 && $i<$no_of_pages;$i++){ if($i>1){?>
        <li class="page-item <?php if($pageNumber == $i){echo 'active';}?>">
        <a class="page-link" href="<?php echo modify_url(array('pageNumber'=>$i));?>"> <?php echo $i;?> </a>
      </li>
      <?php }} ?>

      <?php if($pageNumber<$no_of_pages-3){ ?>
      <li class="page-item disabled">
        <a class="page-link">...</a>
      </li>
      <?php } ?>
      <li class="page-item <?php if($pageNumber == $no_of_pages){echo 'active';}?>">
        <a class="page-link" href="<?php echo modify_url(array('pageNumber'=>$no_of_pages));?>"> <?php echo $no_of_pages;?> </a>
      </li>
      <li class="page-item  <?php if($pageNumber >= $no_of_pages){?>disabled<?php } ?>">
        <a aria-label="Next" class="page-link prev_next" href="<?php echo modify_url(array('pageNumber'=>$pageNumber+1));?>" page="<?php echo $pageNumber+1; ?>">
          <span aria-hidden="true">»</span>
        </a>
      </li>
      <li class="page-item <?php if($pageNumber >= $no_of_pages){?>disabled<?php } ?>">
        <a aria-label="Last" class="page-link prev_next" href="<?php echo modify_url(array('pageNumber'=>$no_of_pages));?>"  page="<?php echo $no_of_pages; ?>">
          <span aria-hidden="true">»»</span>
        </a>
      </li>
    </ul>
    <?php } ?>
  </div>
  </div>

  <div  class="col-md-2 col-sm-4">
  <div  class="select_box">
    <select id="products_per_page"  class="selectBox ng-untouched ng-pristine ng-valid">
      <optgroup  label="Page Size">
        <?php for($j=15; $j<100; $j=$j+15){?>
        <option <?php if($j==$_GET['pageSize']){ echo 'selected';}?>> <?php echo $j;?> </option>
        <?php } ?>
      </optgroup>
    </select>
  </div>
  </div>
</div>

<div class="row">
<div class="col-md--12">
<?php
$products=$json_res->ListProduct;
foreach($products as $product){ ?>
<div class="col-lg-4 col-md-3 col-sm-6 col-xs-6 margin-bottom-20">
<div class="Main_bottlesection">
<div class="item_img circle">
<div class="img_div">
<div class="margin_bottom">
  <div class="sale-tag">
    <?php if($product->OfferIcon){ ?>
    <img class="img-responsive" src="<?php echo $product->OfferIcon;?>">
    <?php } ?>
  </div>
<div class="col-md-12">
<div class="row">
  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
    <div class="row">
      <p class="rating_star">
        <span class="star-rating" <?php if($product->Rating<=0){?>style="visibility: hidden; "<?php } ?>>
        <i  id="<?php echo $product->PID;?>" class="fa fa-star "> </i>
        <span> <?php echo $product->Rating; ?></span></span>
      </p>
    </div>
  <div  class="row">
  <i  id="<?php echo $product->PID;?>" class="icon icon-favorites  <?php if($product->IsFavorite){ echo 'active';}?>" aria-hidden="true"></i>
  </div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
    <div class="row">
      <a class="pimg" href="<?php echo $siteUrl;?>/online/buy-<?php echo slugify($product->ProductName)."-".$product->PID."-".$_SESSION['STORE_ID'];?>">
        <img alt="<?php echo ucwords(strtolower($product->ProductName));?>" class="second_img" src="<?php echo $product->ProductImg;?>">
      </a>
    </div>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
    <div class="row">
      <?php if($product->Inventory <= 0){?>
        <i disabled="disabled" class="icon icon-remove-from-my-cart active" aria-hidden="true" ></i>
      <?php }else{ ?>
      <i id="<?php echo $product->PID;?>" class="icon <?php if($product->InCart){ echo 'icon-remove-cart active';}else{ echo 'icon-add-to-my-cart';}?>" aria-hidden="true"></i>
      <?php } ?>
    </div>
  </div>

</div>
</div>
</div>

<div  class="second_content" tabindex="0">
<div  class="row">
  <?php if($product->OfferType == 'SALE'){ ?>
  <div  class="col-md-6 strike_text">
    <div  class=""><?php echo $product->PriceDisplay;?></div>
  </div>
  <?php  } ?>
  <div  class="col-md-6 price">
  <p  class=""><?php echo $product->OfferPriceDisplay;?></p>
  </div>
  <div class="clearfix"></div>
  <div class="col-md-12 producttitle">
    <h5 class="productname">
	<a class="pimg" href="<?php echo $siteUrl;?>/online/buy-<?php echo slugify($product->ProductName)."-".$product->PID."-".$_SESSION['STORE_ID'];?>">
	<?php echo $product->ProductName;?></h5>
	</a>
  </div>
  <div  class="col-md-12">
    <p  class="product_size">
    <span ><?php echo $product->Size;?></span>
    </p>
  </div>
  <div  class="ptop15">
    <div  class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
      <p  class="review">
      <a  fragment="reviews" href="<?php echo $siteUrl;?>/online/buy-<?php echo slugify($product->ProductName)."-".$product->PID."-".$_SESSION['STORE_ID'];?>#reviews">
      <span  class="first"><?php echo $product->ReviewCount; ?></span>
      <span  class="reviews"> reviews</span></a>
      </p>
    </div>
  </div>
</div>
</div>

</div>
</div>
</div>
</div>

<?php } ?>
</div>
</div>
</div>

<div class="row">
<div  class="col-md-9 col-sm-9 col-lg-9 col-xs-12">
<?php if($total_products>0){?>
<div  class="continer-right">
<div  class="row margin_bottom_35">
  <div  class="col-md-4 col-sm-12">
    <p  class="text_transform"> </p>
  </div>
  <div  class="col-md-6 col-sm-8">
  <div  class="page-navigation">
    <?php if($no_of_pages>1){?>
    <ul class="pagination">
      <li class="page-item <?php if($pageNumber <= 1){?>disabled<?php } ?>">
        <a aria-label="First" class="page-link prev_next" href="<?php echo modify_url(array('pageNumber'=>1));?>" tabindex="-1" page="1">
          <span aria-hidden="true">««</span>
        </a>
      </li>
      <li class="page-item <?php if($pageNumber <= 1){?>disabled<?php } ?>">
        <a aria-label="Previous" class="page-link prev_next" href="<?php echo modify_url(array('pageNumber'=>$pageNumber-1));?>" tabindex="-1" page="<?php echo $pageNumber-1; ?>">
          <span aria-hidden="true">«</span>
        </a>
      </li>
      <?php ?>
      <li class="page-item <?php if($pageNumber == 1){echo 'active';}?>">
        <a class="page-link" href="<?php echo modify_url(array('pageNumber'=>1));?>"> 1
          <span class="sr-only">(current)</span>
        </a>
      </li>
      <?php if($pageNumber>=5){ ?>
      <li class="page-item disabled">
        <a class="page-link">...</a>
      </li>
      <?php } ?>

      <?php for($i=$pageNumber-2; $i<=$pageNumber-1;$i++){ if($i>1){?>
        <li class="page-item <?php if($pageNumber == $i){echo 'active';}?>">
        <a class="page-link <?php echo $i;?>" href="<?php echo modify_url(array('pageNumber'=>$i));?>" > <?php echo $i;?> </a>
      </li>
      <?php }} ?>
      <?php for($i=$pageNumber; $i<=$pageNumber+2 && $i<$no_of_pages;$i++){ if($i>1){?>
        <li class="page-item <?php if($pageNumber == $i){echo 'active';}?>">
        <a class="page-link" href="<?php echo modify_url(array('pageNumber'=>$i));?>"> <?php echo $i;?> </a>
      </li>
      <?php }} ?>

      <?php if($pageNumber<$no_of_pages-3){ ?>
      <li class="page-item disabled">
        <a class="page-link">...</a>
      </li>
      <?php } ?>
      <li class="page-item <?php if($pageNumber == $no_of_pages){echo 'active';}?>">
        <a class="page-link" href="<?php echo modify_url(array('pageNumber'=>$no_of_pages));?>"> <?php echo $no_of_pages;?> </a>
      </li>
      <li class="page-item  <?php if($pageNumber >= $no_of_pages){?>disabled<?php } ?>">
        <a aria-label="Next" class="page-link prev_next" href="<?php echo modify_url(array('pageNumber'=>$pageNumber+1));?>" page="<?php echo $pageNumber+1; ?>">
          <span aria-hidden="true">»</span>
        </a>
      </li>
      <li class="page-item <?php if($pageNumber >= $no_of_pages){?>disabled<?php } ?>">
        <a aria-label="Last" class="page-link prev_next" href="<?php echo modify_url(array('pageNumber'=>$no_of_pages));?>"  page="<?php echo $no_of_pages; ?>">
          <span aria-hidden="true">»»</span>
        </a>
      </li>
    </ul>
    <?php }} ?>
  </div>
  </div>
  </div>
</div>
</div>
</div>
  
<?php }else{ ?><div class="no-results">No Results Found</div><?php } ?>



</div>
</div>



</div>        
</div>



<?php loadView('footer', array('store_details' => $store_details, 'store_home_details'=>$store_home_details));?>
