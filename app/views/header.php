<?php
$siteUrl =  $_SESSION['siteUrl'];
//$store_details = getCurrentStoreDetails();
$store_filters = getStoreFilters();
?>
<!doctype html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title><?php echo $title; ?></title>
  <?php if($_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/checkout/delivery' || $_SERVER['REQUEST_URI'] == '/checkout/pickup'  || $_SERVER['REQUEST_URI'] == '/feature-products'  || $_SERVER['REQUEST_URI'] == '/events'){ ?>
  <meta http-equiv="cache-control" content="max-age=0" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="cache-control" content="no-cache" />
  <meta http-equiv="expires" content="0" />
  <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
  <meta http-equiv="pragma" content="no-cache" />
<?php } ?>
  <?php if($meta_desc!=''){ ?>
  <meta name="description" content="<?php echo $meta_desc;?>">
  <?php } ?>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="icon" type="image/x-icon" href="/favicon.ico">
  <link rel="android-touch-icon" href="/android-icon.png" />
  <link href="<?php echo $siteUrl;?>/css/main.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.css" defer >
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" defer >
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" defer >
</head>

<body>
  <?php //print_r(($store_details));?>
  <div class="hidden-xs hidden-sm visible-lg visible-md desktop-menu">
  <nav class="navbar navbar-default navbar-fixed-top">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <div class="logo"><a href="<?php echo $siteUrl;?>"><img src="<?php echo $_SESSION['siteUrl'];?>/assets/images/logo.png"></a></div>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav-list nav navbar-nav">
          <li><a href="<?php echo $_SESSION['siteUrl'];?>">Home</a></li>
          <li><a <?php if($_currentRoute == 'feature-products'){ echo 'class="active"';}?> href="<?php echo $_SESSION['siteUrl'];?>/feature-products">Featured Products</a></li>
          <?php
          $cnt = 1;
          foreach($store_filters->StoreFilters as $item){
            //print_r($item);
            if($item->CategoryName == 'Beer' || $item->CategoryName == 'Liquor' || $item->CategoryName == 'Wine' || $item->CategoryName == 'Mixers & More') {
            
            ?>
            <li class="dropdown" <?php if($item->Disable == '1'){ echo "style='display:none;'";}?>>
            

            <a <?php if(strpos($_currentRoute, slugify($item->CategoryName))  && $_currentRoute !='about-beer' && $_currentRoute !='about-wine' ){ echo 'class="active"';}?> href="<?php echo $_SESSION['siteUrl'];?>/buy-<?php echo slugify($item->CategoryName);?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $item->CategoryName;?> </a>

            <?php

            if(count($item->ListType)){ 
              if($item->CategoryName == 'Beer' || $item->CategoryName == 'Wine') {
                
                    $subs = $var_subs = $subs_keys  = $var_subs_keys = array();
                    foreach($item->ListType as $cats) {
                    
                        //$submenu_path = '<a href="https://www.bottlerover.com/buy-'.slugify($item->CategoryName).'/'.slugify($cats->TypeName).'">'.$cats->TypeName.'</a>';
                        $submenu_path = $cats->TypeName;
                        $submenu_path_ids = $cats->TypeId;

                        //$subs[$cats->SortNumber] = $submenu_path;
                        //$subs_keys[$cats->SortNumber] = $submenu_path_ids;

                        array_push($subs, $submenu_path);
                        array_push($subs_keys, $submenu_path_ids);
                        

                        if(count($cats->ListVarietal)){
                            
                            foreach($cats->ListVarietal as $varity){
                                //$submenu_path = '<a href="https://www.bottlerover.com/buy-'.slugify($item->CategoryName).'/'.slugify($varity->VarietalName).'">'.$varity->VarietalName.'</a>';
                                $submenu_path = $varity->VarietalName;
                                $submenu_path_ids = $varity->VarietalId;
                                //$var_subs[$varity->SortNumber] = $submenu_path;
                                //$var_subs_keys[$varity->SortNumber] = $submenu_path_ids;
                                array_push($var_subs, $submenu_path);
                                array_push($var_subs_keys, $submenu_path_ids);
                            }
                        }

                    }
                    ksort($subs);
                    ksort($var_subs);

                    if($cnt == 1 || $cnt == 3)
                    {
                      $class = "fade active in";
                    }
                    else{
                      $class = "fade";
                    }

                    echo '<ul class="dropdown-menu"><span class="arrowup"></span>';
                    echo '<div  class="col-md-3 col-xs-3 menu_sec_div">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link '.$class.'" id="v-pills-home'.$cnt.'-tab" data-toggle="pill" href="#v-pills-home'.$cnt.'" role="tab" aria-controls="v-pills-home'.$cnt.'" aria-selected="true">Type</a>
                    <a class="nav-link" id="v-pills-profile'.$cnt.'-tab" data-toggle="pill" href="#v-pills-profile'.$cnt.'" role="tab" aria-controls="v-pills-profile'.$cnt.'" aria-selected="false">Varietal</a>
                    ';
                    
                    echo '</div>';
                    echo '</div>';
                    
                    echo '<div class="col-md-9 col-xs-9">';
                    echo '<div class="tab-content" id="v-pills-tabContent">';
                    echo '<div class="tab-pane '.$class. ' '. $cnt.'" id="v-pills-home'.$cnt.'" role="tabpanel" aria-labelledby="v-pills-home'.$cnt.'-tab"> ';
                    echo '<ul  class="nav flex-column menu_sec type_sec'.$cnt.'">';
                    
                    foreach($subs as $key => $sub){
                      $checked = $cls = "";
                      if(in_array($subs_keys[$key], explode(',', $_GET['typeId']))){
                        $checked = "checked";
                        $cls = 'active';
                      }
                      // echo '<li class="nav-item '.$cls.'"><a href="'.$siteUrl.'/buy-'.slugify($item->CategoryName).'/'.slugify($sub).'">'.$sub.'</a></li>'; //Commented to fix pagination by ManiKanta on 01-02-2022
					  echo '<li class="nav-item '.$cls.'"><a href="'.$siteUrl.'/buy-'.slugify($item->CategoryName).'/?typeId='.$subs_keys[$key].'">'.$sub.'</a></li>'; //Added to fix pagination by ManiKanta on 01-02-2022
                    }
                    echo '</ul>';
                    echo '</div>';

                    echo '<div class="tab-pane fade" id="v-pills-profile'.$cnt.'" role="tabpanel" aria-labelledby="v-pills-profile'.$cnt.'-tab">';
                    echo '<ul class="nav flex-column menu_sec varietal_sec'.$cnt.'">';
                    
                    foreach($var_subs as $key => $sub){
                      $checked = $cls = "";
                      if(in_array($var_subs_keys[$key], explode(',', $_GET['varietalId']))){
                        $checked = "checked";
                        $cls = 'active';
                      }
                      // echo '<li class="nav-item '.$cls.'"><a href="'.$siteUrl.'/buy-'.slugify($item->CategoryName).'/'.slugify($sub).'">'.$sub.'</a></li>'; //Commented to fix pagination by ManiKanta on 01-02-2022
					  echo '<li class="nav-item '.$cls.'"><a href="'.$siteUrl.'/buy-'.slugify($item->CategoryName).'/?varietalId='.$var_subs_keys[$key].'">'.$sub.'</a></li>'; //Added to fix pagination by ManiKanta on 01-02-2022
                    }
                    echo '</ul>';
                    echo '</div>';
                    echo '</div>';
                   
                    echo '</ul>';
                    
              } //if beer/wine
              else {
                $subs = $var_subs = $subs_keys = array();
                foreach($item->ListType as $cats) {
                    $submenu_path = ''.$cats->TypeName.'';
                    $submenu_path_ids = ''.$cats->TypeId.'';
                    if(array_key_exists($cats->SortNumber, $subs)) {
                    $subs[] = $submenu_path;
                    $subs_keys[] = $submenu_path_ids;
                    }
                    else {
                    $subs[$cats->SortNumber] = $submenu_path;
                    $subs_keys[$cats->SortNumber] = $submenu_path_ids;
                    }
                }
                ksort($subs);
                //print_r($subs);
                echo '<ul class="dropdown-menu"><span class="arrowup"></span>';
               // echo '<form name="menu" method="GET">';
		echo '<div  class="col-md-12 col-xs-12">';
		//echo '<span  class="text-uppercase text-white d-block">TYPE</span>';
               
                    echo '<ul  class="nav flex-column '.slugify($item->CategoryName).' allTypes-'.slugify($item->CategoryName).'">';
                    
                    foreach($subs as $key => $sub){
                      $checked = $cls = "";
                      if(in_array($subs_keys[$key], explode(',', $_GET['typeId']))){
                        $checked = "checked";
                        $cls = 'active';
                      }
                      // echo '<li class="nav-item '.$cls.'"><a href="'.$siteUrl.'/buy-'.slugify($item->CategoryName).'/'.slugify($sub).'">'.$sub.'</a> //Commented to fix pagination by ManiKanta on 01-02-2022
					  echo '<li class="nav-item '.$cls.'"><a href="'.$siteUrl.'/buy-'.slugify($item->CategoryName).'/?typeId='.$subs_keys[$key].'">'.$sub.'</a></li>';  //Added to fix pagination by ManiKanta on 01-02-2022
                    }
                    echo '</ul>';
                echo '</div>';
                
                echo '</ul>';
              } // else
            } //if listtype
            ?>
            </li>
          
          <?php }  ?>
          <?php $cnt++;} ?>
          
          <li><a <?php if($_currentRoute == 'recipes'){ echo 'class="active"';}?> href="<?php echo $siteUrl;?>/recipes"> Recipes</a></li>
          <li><a <?php if($_currentRoute == 'events'){ echo 'class="active"';}?> href="<?php echo $siteUrl;?>/events"> Events</a></li>
          <!-- <li><a <?php if($_currentRoute == 'promo'){ echo 'class="active"';}?> href="<?php echo $siteUrl;?>/promo"> Promo</a></li> -->
        </ul>
        <div class="nav navbar-nav nav-right">
          <div class="icons-right">
            <div class="icons-right-sub">
                 <div class="search-bar ">
                     <form class="form-search" action="<?php echo $siteUrl.'/search'?>" >
                         <input type="text" placeholder="Find Your Drink..." name="keyword">
                         <button type="submit"><i class="fa fa-search"></i></button>
                       </form>
                       <div id="results" class="result-sec" style="display:none !important;"></div>
                 </div>
                 <div class="header-icons-div">
                 <div  class="username" tabindex="0">
                   <?php 
                      //print_r($_SESSION);
                      if(!isset($_SESSION['USER_ID']) || $_SESSION['USER_ID'] == '' || $_SESSION['USER_ID'] == '0'){ ?>
                    <div class="header_icon">
                    <a href="<?php echo $siteUrl;?>/login"><i class="icon icon-profile usericondp" aria-hidden="true"></i></a>
                    <?php } 
                    else { ?>
                    <div class="header_icon dropdown-toggle active" data-toggle="dropdown">
                    <a href="<?php echo $siteUrl;?>/myaccount">
                      <?php
                      if($_SESSION['ProfileImage'] != ''){
                        ?>
                        <img class="head-shot" src="<?php echo $_SESSION['ProfileImage'];?>">
                      <?php } else {
                      if($_SESSION['FirstName'] != ''){ $name = $_SESSION['FirstName'];}else{$name = $_SESSION['USER_EMAIL'];}?>
                      <?php if($name != ''){?>
                      <span class="text-dp"><?php echo $name[0];?></span>
                      <?php }else{ ?>
                        <i class="icon icon-profile usericondp" aria-hidden="true"></i>
                      <?php }} ?>
                    </a>
                    <?php } ?>
                    </div>
                    <?php if($_SESSION['USER_ID'] != '' && $_SESSION['USER_ID'] != 0){?>
                    <ul  class="dropdown-menu user-menu">
                    <li  tabindex="0"><a href="<?php echo $siteUrl;?>/myaccount/myorders"><i  class="beer icon icon-recipt-date"></i> My Orders </a></li>
                    <li  tabindex="0"><a href="<?php echo $siteUrl;?>/myaccount"><i  class="beer icon icon-account"></i> My Account </a></li>
                    <li  class="star_color" tabindex="0"><a href="<?php echo $siteUrl;?>/myaccount/favorites"><i  class="beer icon icon-active-rating"></i> Favorites </a></li>
                    <li  class=""><a href="<?php echo $siteUrl;?>/myaccount/logout"><i  class="beer icon icon-logout"></i> Log Out </a></li>
                  </ul>
                  <?php } ?>
                  </div>
             <div  class="cart-block">
                 <div  class="header_icon">
                     <a href="<?php echo $siteUrl;?>/cart">
                     <i class="icon icon-no-items" aria-hidden="true"></i>
                     <span  class="round-circle">0</span>
                     </a>
             </div>
             </div>
         </div>
          </div>
         </div>
        </div>
      </div><!--/.nav-collapse -->
      <div>
        <div class="progress">
          <span class="progress-bar" style="width: 100%"></span>
        </div>
        <div class="load-bar"></div>
      </div>
      
<!--
      <div class="location"><i aria-hidden="true" class="fa fa-map-marker"></i><span class='storename'><?php echo $store_details->StoreName.' - '.$store_details->State;?></span>&nbsp;<a href="#" data-toggle="modal" data-target="#exampleModal">change store</a></div>
      
-->
  </nav>
  </div>
  
  <!-- Mobile header -->

<header class="hidden-md hidden-lg visible-xs visible-sm m-header" id="menu">
  <nav>
    <div class="navbar-header">
      <button class="pull-left m-menu" id="nav-icon4" type="button">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <a href="<?php echo $siteUrl;?>" class="navbar-brand lukas-logo">
        <img alt="" class="img-responsive" src="<?php echo $_SESSION['siteUrl'];?>/assets/images/logo.png" tabindex="0">
      </a>
    </div>
    
    <div class="pull-right">
      <div class="pull-left tab-search-bar hidden-xs hidden-lg">
        
          <ul class="nav navbar-nav mobile_none search-block">
            <li>
              <div class="input-group searchby">
                <form novalidate="" class="ng-untouched ng-pristine ng-valid">
                  <input aria-label="Search" class="search-drink ng-untouched ng-pristine ng-valid" id="searchBar" name="search" placeholder="Find Your Drinks..." type="text" autocomplete="off" role="combobox" aria-autocomplete="list" aria-expanded="false">
                  <input class="hidden-input" style="visibility:hidden; display: none;" type="submit" value="Go">
                </form>
                <div class="search-btn">
                  <button class="btn btn-primaray" type="button">
                    <i class="icon icon-search"></i>
                  </button>
                </div>
              </div>
             
            </li>
          </ul>
        </div>
        <ul class="navbar nav navbar-nav float_right user-profile-block"><!---->
          <li>
	   

       <?php 
          //print_r($_SESSION);
          if(!isset($_SESSION['USER_ID']) || $_SESSION['USER_ID'] == '' || $_SESSION['USER_ID'] == '0'){ ?>
        <div class="header_icon username"  tabindex="0">
        <a href="<?php echo $siteUrl;?>/login"><i class="icon icon-profile usericondp" aria-hidden="true"></i></a>
        <?php } 
        else { ?>
        <div class="header_icon username dropdown-toggle active" data-toggle="dropdown"  tabindex="0">
        <a href="<?php echo $siteUrl;?>/myaccount">
          <?php
          if($_SESSION['ProfileImage'] != ''){
            ?>
            <img class="head-shot" src="<?php echo $_SESSION['ProfileImage'];?>">
          <?php } else {
          if($_SESSION['FirstName'] != ''){ $name = $_SESSION['FirstName'];}else{$name = $_SESSION['USER_EMAIL'];}?>
          <?php if($name != ''){?>
          <span class="text-dp"><?php echo $name[0];?></span>
          <?php }else{ ?>
            <i class="icon icon-profile usericondp" aria-hidden="true"></i>
          <?php }} ?>
        </a>
        <?php } ?>
          </div>
          <?php if($_SESSION['USER_ID'] != '' && $_SESSION['USER_ID'] != 0){?>
            <ul  class="dropdown-menu user-menu">
            <li  tabindex="0"><a href="<?php echo $siteUrl;?>/myaccount/myorders"><i  class="beer icon icon-recipt-date"></i> My Orders </a></li>
            <li  tabindex="0"><a href="<?php echo $siteUrl;?>/myaccount"><i  class="beer icon icon-account"></i> My Account </a></li>
            <li  class="star_color" tabindex="0"><a href="<?php echo $siteUrl;?>/myaccount/favorites"><i  class="beer icon icon-active-rating"></i> Favorites </a></li>
            <li  class=""><a href="<?php echo $siteUrl;?>/myaccount/logout"><i  class="beer icon icon-logout"></i> Log Out </a></li>
          </ul>
          <?php } ?>
 	    
        </li><!---->
        <li tabindex="0">
          <div class="cart-block">
	    <div class="header_icon">
		<a href="<?php echo $siteUrl;?>/cart">
              <i class="icon icon-no-items"></i>
              <span class="round-circle">0</span></a>
            </div>
            <div class="cart-captions"></div>
          </div>
        </li>
      </ul>
    </div>
    <div class="col-xs-12 visible-xs hidden-sm hidden-md hidden-lg searchbar-mobile-all">
        <ul class="nav navbar-nav mobile_none search-block">
          <li><div class="input-group searchby">
            <form novalidate="" class="mform-search ng-untouched ng-pristine ng-valid" action="<?php echo $siteUrl.'/search'?>">
              <input aria-label="Search" class="search-drink ng-untouched ng-pristine ng-valid" id="searchBar" name="keyword" placeholder="Find Your Drinks..." type="text" autocomplete="off" role="combobox" aria-autocomplete="list" aria-expanded="false">
              <input class="hidden-input" style="visibility:hidden; display: none;" type="submit" value="Go">
            </form>
            <div class="search-btn">
              <button class="btn btn-primaray" type="button">
                <i class="icon icon-search"></i>
              </button>
            </div>
          </div>
        </li>
        <div id="results" class="mresult-sec" style="display: none !important;"></div>
      </ul>
  </div>
  
  <div class="col-xs-12">
    <div class="hide-menu" id="hide-menu">
      <ul class="msidenav">
        <li><a href="<?php echo $siteUrl;?>">Home </a></li>
        <li><a href="<?php echo $siteUrl;?>/feature-products">Featured Products </a></li>
        <li><a href="<?php echo $siteUrl;?>/buy-beer">BEER </a></li>
        <li><a href="<?php echo $siteUrl;?>/buy-liquor">LIQUOR </a></li>
        <li><a href="<?php echo $siteUrl;?>/buy-wine">WINE </a></li>
        <li><a href="<?php echo $siteUrl;?>/buy-mixers-more">MIXERS &amp; MORE </a></li>
        <li><a href="<?php echo $siteUrl;?>/recipes">Recipes </a></li>
        <li><a href="<?php echo $siteUrl;?>/events">Events </a></li>
      </ul>
    </div>
  </div>
</nav>
</header>

<?php if($_SERVER['REQUEST_URI'] == '/'){ ?>
<!-- Mobile Catefory -->
<div class="visible-xs hidden-sm hidden-md hidden-lg ">
<div class="container mtop float-left">
<div class="row">
<div class="input-group searchby hidden-xs hidden-sm hidden-md hidden-lg"></div>
<div class="m-menu-tabs">
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation">
    <a aria-controls="beer" href="<?php echo $siteUrl;?>/buy-beer">
    <i class="icon icon-beer">
    </i>
    </a>
    </li>
    <li role="presentation">
    <a aria-controls="liquor" href="<?php echo $siteUrl;?>/buy-liquor">
    <i class="icon icon-liquor">
    </i>
    </a>
    </li>
    <li role="presentation"><a aria-controls="wine" href="<?php echo $siteUrl;?>/buy-wine">
    <i class="icon icon-wine"></i></a></li>
    <li role="presentation"><a aria-controls="mixers" href="<?php echo $siteUrl;?>/buy-mixers-more">
    <i class="icon icon-mixer"></i></a></li>
  </ul><!---->
</div>
</div>
</div>
</div>
  
<?php } ?>

  
<?php
$stores = getStoresList();
//echo "store--";print_r($stores);
$stores_list = $stores->ListStore;
?>
<!-- Modal -->
<div class="modal fade modelchainstore animated fadeInRightBig" data-backdrop="static" data-keyboard="false" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div  class="modal-dialog">
     <div  class="modal-content">
       <div  class="modal-header">
        <button  class="close" data-dismiss="modal" type="button">×</button>
        <h4  class="modal-title text-center">
          <img  src="<?php echo $siteUrl?>/assets/images/logo-popup.png"></h4>
       </div>
     <div  class="modal-body text-center">
     <div>
      <form  class="mbottom15 ng-untouched ng-pristine ng-valid" novalidate="">
        <input type="hidden" name="setStore" value="setStore">
        <div  class="form-inline-lg">
          <div  class="input-group">
            <div  class="input-group-addon input-group-addon-custom">
              <i  class="fa fa-search"></i>
            </div>
            <input  class="form-control ng-untouched ng-pristine ng-valid" name="search" placeholder="Search by City, Zip Code or Name" type="text">
            <div  class="input-group-addon">
              <i  class="fa fa-map-marker"></i>
            </div>
          </div>
        </div>
      </form>
      <?php 
      $stores1 = $stores2 = '';
      foreach($stores_list as $store){
        if($_SESSION['STORE_ID']== $store->StoreId){ 
          $stores1 .= '
          <div  class="row">
          <div  class="col-md-12 store-block">
          <div  class="col-md-3 img-store success text-center">
          <i  aria-hidden="true" class="fa fa-check-circle"></i>
          <img  src="'.$store->StoreImage.'">
          </div>
          <div  class="col-md-6">
          <h3>'.$store->StoreName.'</h3>
          <small  class="text-muted">'.$store->Address1.' '.$store->Address2.'<span> '.$store->City.',</span>
          <span>'.$store->State.'</span>
          <span>'.$store->Zip.'</span>
          </small><br>
          <small  class="text-muted">
          <i  class="icon icon-footer-contact"></i>
          <span ><a  href="tel:'.$store->Phone.'">Call: '.$store->Phone.'</a></span>
          </small>
          </div>
          <div  class="col-md-3 text-center">
          <table  width="100%">
          <tbody>
          <tr>
          <td  class="text-center">
          <div >

          <button store_id="'.$store->StoreId.'"  class="btn btn-default filer_go  success animated fadeInRightBig  activate" type="button"> Selected Store </button>
          </div>
          </td>
          </tr>
          </tbody>
          </table>
          </div>
          </div>
          </div>';
 }else{
    $stores2 .= '
          <div  class="row">
          <div  class="col-md-12 store-block">
          <div  class="col-md-3 img-store success text-center">
          
          <img  src="'.$store->StoreImage.'">
          </div>
          <div  class="col-md-6">
          <h3>'.$store->StoreName.'</h3>
          <small  class="text-muted">'.$store->Address1.' '.$store->Address2.'<span> '.$store->City.',</span>
          <span>'.$store->State.'</span>
          <span>'.$store->Zip.'</span>
          </small><br>
          <small  class="text-muted">
          <i  class="icon icon-footer-contact"></i>
          <span ><a  href="tel:'.$store->Phone.'">Call: '.$store->Phone.'</a></span>
          </small>
          </div>
          <div  class="col-md-3 text-center">
          <table  width="100%">
          <tbody>
          <tr>
          <td  class="text-center">
          <div >

          <button store_id="'.$store->StoreId.'"  class="btn btn-default filer_go " type="button"> Select Store </button>
          </div>
          </td>
          </tr>
          </tbody>
          </table>
          </div>
          </div>
          </div>';
 } 
}
echo $stores1;
echo $stores2;
?>

</div>

   </div>
   <div  class="modal-footer buttons-container">
   <p >To learn more about responsible consumption, please visit <a  href="https://www.drinksmart.com" target="_blank">www.drinksmart.com</a>
   </p>
 </div>
 </div>
 </div>
 </div>
 </div>



<div  class="modelageverification modal fade animated fadeInRightBig" data-backdrop="static" data-keyboard="false" id="myModal" role="dialog">
    <div  class="modal-dialog">
      <div  class="modal-content">
        <div  class="modal-header">
         <!--<button  class="close" data-dismiss="modal" type="button">×</button>-->
         <h4  class="modal-title text-center">
         <a href="<?php echo $siteUrl;?>"><img  src="<?php echo $siteUrl;?>/assets/images/logo-popup.png"></a></h4>
        </div>

  <div class="modal-body text-center">
    <div id="age_verf_sec">
      <p class="font">We sell alcohol-based products on this website, but we can’t advertise or sell to minors.</p>
      <h2 class="popins_bold">Are you at least 21 Years old?</h2>
      <div class="text-center">
          <button id='age_no' type="button" class="btn btn-default close modal-age no" style="float: none;">No</button>
        <button id='age_yes' type="button" class="btn btn-default close modal-age" style="float: none;" data-dismiss="modal"
          >Yes</button>
      </div>
    </div>
    <div id="sorryDialogBody" style="display:none;">
      <span class="fa fa-ban popicon-block"></span>
      <h2 class="popins_bold-2">Sorry!</h2>
      <div id="sorryDialogFooter" >
          <p>You must be 21 years of age or older to view this site. </p>
          <div class="btncenter-block">
            <button type="button" class="btn btn-default close">Leave Site!</button>
          </div>
        </div>
    </div>
    <div class="modal-footer buttons-container">
       <p>To learn more about responsible consumption, please visit <a
            href="https://www.drinksmart.com" target="_blank">www.drinksmart.com</a></p>
       
      </div>
  </div>
</div>
</div>
</div>

<style>
.progress {
  width: 100%;
  height: 6px;
  background: #e1e4e8;
  border-radius: 3px;
  overflow: hidden;
  display: none;
}
.progress .progress-bar {
  display: block;
  height: 100%;
  background: linear-gradient(90deg, #ffd33d, #ea4aaa 17%, #b34bff 34%, #01feff 51%, #ffd33d 68%, #ea4aaa 85%, #b34bff);
  background-size: 300% 100%;
  -webkit-animation: progress-animation 2s linear infinite;
          animation: progress-animation 2s linear infinite;
}

@-webkit-keyframes progress-animation {
  0% {
    background-position: 100%;
  }
  100% {
    background-position: 0;
  }
}

@keyframes progress-animation {
  0% {
    background-position: 100%;
  }
  100% {
    background-position: 0;
  }
}
</style>
