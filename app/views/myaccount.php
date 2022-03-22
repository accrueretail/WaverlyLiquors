<?php
loadView('header', array('title' => $title, 'store_details' => $store_details));
?>

<div  class="container common-margin-top">
    <div  class="Searchrelated_div col-md-12 col-sm-12 col-lg-12 col-xs-12">
      <h4>My Account</h4>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo $siteUrl;?>/home">Home</a>
        </li>
        <li  class="breadcrumb-item">
          Account
        </li>
      </ol>
    </div>
</div>
<div class="container">
<div  class="col-md-12 col-sm-12 col-lg-3 col-xs-12">
<div class="visible-md visible-lg hidden-xs hidden-sm"><ul aria-multiselectable="true" class="panel-group myac-panel" id="accordion" role="tablist"><li class="panel bottle-panel-container"><div class="left-panel-section"><h4 class="left-panel-title"><a href="<?php echo $siteUrl;?>/myaccount/myorders"><span class="bottles-brand myac-icon icon icon-recipt-date"></span> My Orders <span class="fa fa-chevron-right pull-right hidden-xs hidden-sm visible-lg hidden-md"></span></a></h4></div></li><li class="panel bottle-panel-container"><div class="left-panel-section" id="myAccountHeading" role="tab"><h4 class="panel-title left-panel-title"><a aria-controls="myAccount" aria-expanded="false" class="collapsed" data-parent="#accordion" data-toggle="collapse" href="#myAccount" role="button"><span class="icon icon-account bottles-brand myac-icon"></span> My Account <span class="fa fa-chevron-down pull-right hidden-xs hidden-sm visible-lg visible-md"></span></a></h4></div><ul aria-labelledby="myAccountHeading" class="panel-collapse collapse left-panel-body" id="myAccount" role="tabpanel"><li><a href="<?php echo $siteUrl;?>/myaccount">Profile Information</a></li><li><a routerlink="./manage-addresses" href="<?php echo $siteUrl;?>/myaccount/manage-addresses">Manage Addresses</a></li></ul></li><li class="panel bottle-panel-container"><div class="left-panel-section"><h4 class="left-panel-title"><a href="<?php echo $siteUrl;?>/myaccount/favorites"><span class="icon icon-active-rating bottles-brand myac-icon"></span> Favorites <span class="fa fa-chevron-right pull-right hidden-xs hidden-sm visible-lg hidden-md"></span></a></h4></div></li><li class="bottle-panel-container"><div class="left-panel-section"><h4 class="left-panel-title"><a id="logout" class="" href="<?php echo $siteUrl;?>/myaccount/logout"><span class="icon icon-logout myac-icon bottles-brand"></span> Logout</a></h4></div></li></ul></div>
</div>

<!--right section start-->
<div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 m-height">
<?php
if($type == ''){ ?>
<div class="float_right hidden-xs hidden-sm visible-md visible-lg"><a href="<?php echo $siteUrl;?>/myaccount/profile-edit"><button class="btn btn-profile" tabindex="0"><span class="icon-radius"><i class="icon icon-ediit"></i></span><span class="visible-lg hidden-xs hidden-md hidden-sm editbtn">Edit Profile</span></button></a></div>

<div class="myaccount-border_bottom hidden-xs hidden-sm visible-lg visible-md">
  <div class="profile">
    <div class="col-xs-12 col-md-2 col-sm-2 col-lg-2">
      <span class="img_class"><span class="text-dp">
      <?php
      if($profile['ProfileImage'] != ''){ ?>
      <img id="profile_imge_output" src="<?php echo $profile['ProfileImage']; ?>" style="<?php if($profile['ProfileImage'] != ''){ echo "display:block;"; }else{ echo "display:none;";} ?>">
      <?php } else{  echo $profile['FirstName'][0]; }?></span></span>
    </div>
    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
      <h4 class="margin_top"><?php echo $profile['FirstName'];?> <?php echo $profile['LastName'];?></h4>
      <h5 class="email"><?php echo $profile['EmailId'];?></h5>
    </div>
  </div>
</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div class="profileset-container">
    <h4 class="mobile_number">Mobile Number</h4>
    <h5 class="contact"><?php echo $profile['ContactNo'];?></h5>
  </div>
  <div class="profileset-container">
  <h5 class="mobile_number">Gender</h5>
    
    <?php if($profile['Gender'] == 'M'){ ?>
    <h5 class="contact">Male</h5>
    <?php }
    if($profile['Gender'] == 'F'){ ?>
      <h5 class="contact">Female</h5>
      <?php }
    ?> </div>
  <div class="profileset-container">
    <h5 class="mobile_number">Date Of Birth</h5>
    <h5 class="contact"><?php if($profile[DOBDt] != ''){echo date('m/d/Y', strtotime($profile['DOBDt']));}?></h5>
  </div>
</div>

<?php } ?>
<?php
if($type == 'profile-edit'){ ?>
<div class="col-md-12">
  <h4>Edit Profile</h4>
<div class="row">
  <div class="col-md-12 profile-edit-section">
    <form method="POST"  enctype="multipart/form-data" class="ng-untouched ng-pristine ng-invalid">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <span class="img_class">
                <span class="text-dp">
                <img id="profile_imge_output" src="<?php echo $profile['ProfileImage']; ?>" style="<?php if($profile['ProfileImage'] != ''){ echo "display:block;"; }else{ echo "display:none;";} ?>">
              </span>
            </span>
            
            <div class="inputWrapper profileupload">
              <input accept="image/*" capture="camera" class="fileInput" id="pImage" name="pImage" type="file" ><span class="fa fa-camera"></span>
              <input type="hidden" id="profile_pic" name="profile_pic" value="<?php echo $profile['ProfileImage']; ?>" >
            </div>
            
          </div>
        </div>
      </div>
      <div class="row"><br>
      
      <div class="col-md-6">
        
        <div class="form-group">
          <label class="text-uppercase">First Name <span>*</span>
            <input class="form-control"  name="pFirstName" oninput="this.value = this.value.replace(/[^\w\s]/gi, '');" placeholder="First Name" type="text" value="<?php echo $profile['FirstName'];?>">
          </label>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label class="text-uppercase">Last Name <span>*</span>
            <input class="form-control"  name="pLastName" oninput="this.value = this.value.replace(/[^\w\s]/gi, '');" placeholder="Last Name" type="text" value="<?php echo $profile['LastName'];?>">
          </label>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label class="text-uppercase">Phone Number <span>*</span>
            <input  class="form-control" name="pContactNo" id="phone-number" maxlength="14" placeholder="Phone Number" type="text" value="<?php echo $profile['ContactNo'];?>">
          </label>
        </div>
      </div>
      <div class="col-md-6"><div class="form-group"><label class="text-uppercase">E-Mail <span>*</span><input class="form-control ng-untouched ng-pristine ng-valid" name="pEmail" placeholder="Email" readonly="" type="email" value="<?php echo $profile['EmailId'];?>"><!----></label></div></div></div>
      <div class="row"><div class="col-md-6 date-picker"><div class="form-group"><label class="text-uppercase">Date of Birth <span>*</span></label>
      <div class="input-group calendar-group"><input id="dob"  class="form-control date-input datepicker" name="pDOB" maxlength="10" name="dp" ngbdatepicker="" oninput="this.value=this.value.replace(/^(\d\d)(\d)$/g,'$1/$2').replace(/^(\d\d\/\d\d)(\d+)$/g,'$1/$2').replace(/[^\d\/]/g,'')" placeholder="mm/dd/yyyy" size="10" value="<?php if($profile['DOBDt'] != ''){echo date('m/d/Y', strtotime($profile['DOBDt']));}?>">  
      <div class="alert alert-danger dt-err" style="display:none;"><div id="dob_label"></div></div>    
      <!----><div class="date-msg-alert"><!----><!----><!----></div></div></div></div><div class="col-md-6"><div class="form-group"><label class="text-uppercase">Gender </label><div class="col-md-12"><div class="col-md-6 col-xs-6"><div class="radiobox m-radio"><input name="pGender" name="pGender" type="radio" value="M" <?php if($profile['Gender'] == 'M'){ echo "checked='checked'";} ?> class="ng-untouched ng-pristine ng-valid"><span class="checkmark"></span></div> Male </div><div class="col-md-6 col-xs-6"><div class="radiobox m-radio"><input name="pGender" name="pGender" <?php if($profile['Gender'] == 'F'){ echo "checked='checked'";} ?>  type="radio" value="F" class="ng-untouched ng-pristine ng-valid"><span class="checkmark"></span></div> Female </div></div></div></div></div>
      <div class="row"><div class="col-md-12"><div class="form-group">
      <div class="btn_right">
      <a href="<?php echo $siteUrl;?>/myaccount" class="btn btn-default novalue">Cancel</a>
      <button class="btn btn-default close profile_save" type="submit">Save</button></div></div></div></div></form></div></div></div>
<?php } ?>
<?php
if($type == 'favorites'){
	$total_products = $products['TotalCount'];
	$per_page = 12;
$no_of_pages = ceil($total_products/$per_page);
$current_page = $pageNumber;
?>
<div class="ng-star-inserted"><div class="col-md-12"><div class="row">
    <div class=" border-line col-md-12 col-sm-12 col-lg-12 col-xs-12">
	<h4>Favorites</h4>
    </div>
</div>
</div>

<div class="row margin-bottom-20">
          <div class="btn-container">
            <div class="col-md-6">
            <?php if($pageNumber>1){?>
            <a href="<?php echo $siteUrl."/myaccount/favorites/".($current_page-1);?>">
            <button class="btn btn-default ng-star-inserted">
            Previous Page
            </button>
            </a>
            <?php } ?>
            </div>
            <div class="col-md-6">
            <?php if($pageNumber<$no_of_pages){?>
            <a href="<?php echo $siteUrl."/myaccount/favorites/".($current_page+1);?>">
            <button class="btn btn-default pull-right ng-star-inserted">Next Page</button>
            </a>
            <?php } ?>
            </div>
          </div>
	</div>

<div  class="col-md-12 col-sm-9 col-lg-12 col-xs-12">
<input type="hidden" value="<?php echo $total_products;?>" id="procunt">
<?php if($total_products>0){?>
<div  class="continer-right">

<div class="row">
<div class="col-md--12">
<?php
$products=$products['ListProduct'];
foreach($products as $product){ ?>
<div class="fav-prod col-lg-4 col-md-4 col-sm-6 col-xs-6 margin-bottom-20">
<div class="Main_bottlesection">
<div class="item_img circle">
<div class="img_div">
<div class="margin_bottom">
  <div class="sale-tag">
    <?php if($product['OfferIcon']){ ?>
    <img class="img-responsive" src="<?php echo $product['OfferIcon'];?>">
    <?php } ?>
  </div>
<div class="col-md-12">
<div class="row">
  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
    <div class="row">
      <p class="rating_star">
        <span class="star-rating" style="visibility: hidden; ">
        <i  id="<?php echo $product['PID'];?>" class="fa fa-star "> </i>
        <span> 0</span></span>
      </p>
    </div>
  <div  class="row">
  <i  id="<?php echo $product['PID'];?>" class="fav-sec icon icon-favorites  <?php if($product['IsFavorite']){ echo 'active';}?>" aria-hidden="true"></i>
  </div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
    <div class="row">
      <a class="pimg" href="<?php echo $siteUrl;?>/online/buy-<?php echo slugify($product['ProductName'])."-".$product['PID']."-".$_SESSION['STORE_ID'];?>">
        <img class="second_img" src="<?php echo $product['ProductImg'];?>" alt="<?php echo ucwords(strtolower($product['ProductName']));?>">
      </a>
    </div>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
    <div class="row">
      <i id="<?php echo $product['PID'];?>" class="icon <?php if($product['InCart']){ echo 'icon-remove-cart active';}else{ echo 'icon-add-to-my-cart';}?>" aria-hidden="true"></i>
    </div>
  </div>

</div>
</div>
</div>

<div  class="second_content" tabindex="0">
<div  class="row">
  <!-- added by manikanta -->
<?php if($product->OfferType == 'SALE'){ ?>
  <div  class="col-md-6 strike_text">
    <div  class=""><?php echo $product['PriceDisplay'];?></div>
  </div>
  <?php } ?>
  <div  class="col-md-6 price">
  <p  class=""><?php echo $product['OfferPriceDisplay'];?></p>
  </div>
  <div class="clearfix"></div>
  <div class="col-md-12 producttitle">
    <h5 class="productname"><a class="pimg" href="<?php echo $siteUrl;?>/online/buy-<?php echo slugify($product['ProductName'])."-".$product['PID']."-".$_SESSION['STORE_ID'];?>"><?php echo $product['ProductName'];?></a></h5>
  </div>
  <div  class="col-md-12">
    <p  class="product_size">
    <span ><?php echo $product['Size'];?></span>
    </p>
  </div>
  <div  class="ptop15">
    <div  class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
      <p  class="review">
      <a  fragment="reviews" href="<?php echo $siteUrl;?>/online/buy-<?php echo slugify($product['ProductName'])."-".$product['PID']."-".$_SESSION['STORE_ID'];?>#reviews">
      <span  class="first">0</span>
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
<div class="row margin-bottom-20">
          <div class="btn-container">
            <div class="col-md-6">
            <?php if($pageNumber>1){?>
            <a href="<?php echo $siteUrl."/myaccount/favorites/".($current_page-1);?>">
            <button class="btn btn-default ng-star-inserted">
            Previous Page
            </button>
            </a>
            <?php } ?>
            </div>
            <div class="col-md-6">
            <?php if($pageNumber<$no_of_pages){?>
            <a href="<?php echo $siteUrl."/myaccount/favorites/".($current_page+1);?>">
            <button class="btn btn-default pull-right ng-star-inserted">Next Page</button>
            </a>
            <?php } ?>
            </div>
          </div>
        </div>
<?php }else{ echo ' <b id="noproducts" style="display:none;">No Products Found</b>';} ?>


</div>
</div>
</div>



</div>        
</div>

<?php } ?>

<?php if($type == 'myorders'){ ?>
<?php
loadView('myorders', array('orders' => $orders['ListOrder'], 'result' => $orders, 'siteUrl'=>$siteUrl));
?>
<?php } ?>

<?php if($type == 'manage-addresses' || $type == 'edit-address'){ 
  loadView('manage-address', array('siteUrl'=>$siteUrl, 'store_details'=>$store_details, 'addresses'=>$addresses, 'type'=>$type, 'addressId'=>$addressId));
} ?>

</div>
</div>
<?php loadView('footer', array('store_details' => $store_details, 'store_home_details'=>$store_home_details));?>
<style>
  .Searchrelated_div h4 {
    padding-left: 12px;
    border: none;
    float: left;
    border-left: 5px solid #a82c2e;
    font-family: poppinsbold;
    font-size: 1.15em !important;
    font-stretch: normal;
    /* line-height: 1.7; */
    letter-spacing: normal;
    text-align: left;
    color: #191919;
}
  </style>
