<?php 
$title = $siteName;
loadView('header', array('title' => $title, 'store_details' => $store_details));
?>
 
 <div  class="container sresult">
        <div  class="row">
        <div  class="Search_div col-md-12 col-sm-12 col-lg-12 col-xs-12">
        <h4>Cart</h4>
        <ol class="breadcrumb">
        <li class="breadcrumb-item">
        <a href="/">Home</a>
       </li>
       <li  class="breadcrumb-item">
        <a>Cart</a>
    </li>
</ol>
</div>
</div>
</div>
    
<div class="cart-main">
<section>
<div  class="container">
<div  class="row ng-star-inserted">
<div  class="col-md-12 col-sm-12 col-lg-12 col-xs-12 slideInUP wow delay-05s  animated" id="no-more-tables">
<?php if(count($products->ListCartItem) > 0){ ?>
<table  class="table table-bordered res_table hidden-xs hidden-sm visible-lg visible-md">
<thead>
<tr>
<th  width="53%">Product Details</th>
<th  width="15%">Product Price</th>
<th  width="12%">Quantity</th>
<th  width="20%">Total Price</th>
</tr>
</thead>
</table>

<?php 
//print_r($products->ListCartItem);
$pcnt = 0; //Added By Sagar
foreach($products->ListCartItem as $cart_item){ 
if($cart_item->Quantity<=0){ continue;} ?>
<table  class="box-tile hidden-xs hidden-sm visible-lg visible-md ng-star-inserted">
<tbody  class="bg-transparent">
<tr class="cart-item-row cart-item-row-<?php echo $cart_item->CartItemId;?>">
<td  class="cart-item" width="53%">
<div  class="img_div" tabindex="0">
<a href="<?php echo $siteUrl;?>/online/buy-<?php echo slugify($cart_item->ProductName)."-".$cart_item->PID."-".$_SESSION['STORE_ID'];?>">
  <img  alt="<?php echo ucwords(strtolower($cart_item->ProductName));?>" class="second_img" src="<?php echo $cart_item->ProductImage;?>">
</a>
</div>
<div  class="Product_name text-left">
<h5  class="text-left"><?php echo $cart_item->ProductName;?></h5>
<span  class="font_size"><?php echo $cart_item->UnitSize;?> | SKU: <?php echo $cart_item->SKU;?> </span>
</div>
</td>
<td  class="cart-item" width="15%">
<div>
<h5  class="Product_price text-left"><?php echo $cart_item->OfferPriceDisplay;?></h5>
<?php if($cart_item->OfferType == 'SALE' || $cart_item->OfferType == 'S'){ ?>
<h6 class="price-strike-through text-left"><?php echo $cart_item->PriceDisplay;?></h6>
<?php } ?>
</div>
</td>
<td  class="cart-item" width="12%">
<div  class="select-bg web">
<input scrn="web" maxlength="6"  id="qnty_input" prev_val="<?php echo $cart_item->Quantity;?>" value="<?php echo $cart_item->Quantity;?>" class="qnty_input form-control inputqty" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"  cart_item="<?php echo $cart_item->CartItemId;?>" >
<select scrn="web" class="select-quant classic form-control" quan="<?php echo $cart_item->Quantity; ?>" cart_item="<?php echo $cart_item->CartItemId;?>">
<?php for($i=1;$i<=100;$i++){ ?>
<option <?php if($cart_item->Quantity == $i){ echo 'selected';}?>><?php echo $i;?></option>
<?php } ?>
</select>
</div>
</td>
<td  class="cart-item" width="20%">
<div  class="text-left totalprice">
<span  class="total_price"><?php echo $cart_item->FinalItemTotalDisplay;?> </span>
<button  class="bg_black cancel_product" quan="<?php echo $cart_item->Quantity; ?>" pid="<?php echo $cart_item->PID;?>" cart_item="<?php echo $cart_item->CartItemId;?>">
<img  src="<?php echo $siteUrl;?>/assets/images/cancel.png">
</button>
</div>
</td>
</tr>
</tbody>
</table>
<?php $pcnt++;} ?> <!--Added By Sagar-->

<!-- Mobile cart Start-->
<?php
foreach($products->ListCartItem as $cart_item){ 
if($cart_item->Quantity<=0){ continue;} ?>
<div class="box-tile hidden-md hidden-lg visible-xs visible-sm ng-star-inserted">
  <div class="col-xs-12 cart-item-row cart-item-row-<?php echo $cart_item->CartItemId;?>">
  <div class="cart-item ">
    <div class="img_div" tabindex="0">
      <img class="second_img img-responsive" alt="<?php echo ucwords(strtolower($cart_item->ProductName));?>" src="<?php echo $cart_item->ProductImage;?>">
    </div>
    <div class="Product_name text-left">
      <h5 class="text-left"><?php echo $cart_item->ProductName;?></h5>
      <span class="font_size"><?php echo $cart_item->UnitSize;?> | SKU: <?php echo $cart_item->SKU;?> </span>
    </div>
    <div>

      <h5 class="Product_price text-left"><?php echo $cart_item->OfferPriceDisplay;?></h5>
      <!---->
      <div>
<?php if($cart_item->OfferType == 'SALE'){ ?>
        <h6 class="price-strike-through text-left"><?php echo $cart_item->PriceDisplay;?></h6>
<?php } ?>
      </div>
    </div>
    <div class="margin_top mobi">
      <input scrn="mobi" maxlength="6"  id="qnty_input" prev_val="<?php echo $cart_item->Quantity;?>" value="<?php echo $cart_item->Quantity;?>" class="qnty_input form-control inputqty" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"  cart_item="<?php echo $cart_item->CartItemId;?>" >
      <select scrn="mobi" class="select-quant classic form-control" quan="<?php echo $cart_item->Quantity; ?>" cart_item="<?php echo $cart_item->CartItemId;?>">
      <?php for($i=1;$i<=100;$i++){ ?>
      <option <?php if($cart_item->Quantity == $i){ echo 'selected';}?>><?php echo $i;?></option>
      <?php } ?>
      </select>
    </div>
    <div class="text-left totalprice">
      <span class="total_price"><?php echo $cart_item->FinalItemTotalDisplay;?> </span>
      <button  class="bg_black cancel_product" quan="<?php echo $cart_item->Quantity; ?>" pid="<?php echo $cart_item->PID;?>" cart_item="<?php echo $cart_item->CartItemId;?>">
      <img  src="<?php echo $siteUrl;?>/assets/images/cancel.png">
      </button>
    </div>
  </div>
</div>
</div>
<?php } ?>
<!-- Mobile cart end-->

<?php $store_details = getCurrentStoreDetails(); ?>
<?php if($pcnt>0){ ?> <!-- Added By Sagar-->
<div  class="btn_right buttons-container">
  <a href="<?php echo $siteUrl;?>"><button class="btn btn-default btn-botcaps" tabindex="0">Continue Shopping</button></a>
  <?php if($store_details->IsPickUp == 1){ ?>
    <a href="<?php echo $siteUrl;?>/checkout/pickup"><button class="btn btn-default ng-star-inserted">Pickup</button></a>
  <?php } ?>
  <?php if($store_details->IsDelivery == 1){ ?>
    <a href="<?php echo $siteUrl;?>/checkout/delivery"><button class="btn btn-default ng-star-inserted">Delivery</button></a>
<?php } ?>
  <?php if($store_details->IsShipping == 1){ ?>
    <a href="<?php echo $siteUrl;?>/checkout/shipping"><button class="btn btn-default ng-star-inserted">Shipping</button></a>
<?php } ?>
</div>
<?php } ?><!-- Added By Sagar-->

<?php } ?>
<div class="empty-cart" <?php if(count($products->ListCartItem) > 0){echo "style='display:none !important;'";}?>>
    <div class="col-md-5 col-xs-12">
      <div  class="cart-m row">
        <div class="icon-float">
          <span class="notification-circle">0</span>
          <span class="fa fa-shopping-cart cart-view-icon"></span>
        </div>
      </div>
    </div>
    
    <div class="col-md-6 col-md-offset-1 col-xs-12">
      <div class="cart-m-details row">
        <h3>No Items !</h3>
        <div class="row">
          <div class="col-md-6">
            <p>You have not added any items. Add an item to place order.</p>
          </div>
        </div>
        <div class="col-md-12 text-left">
          <a href="<?php echo $siteUrl;?>"><button class="btn btn-default btn-botcaps" tabindex="0">Continue Shopping</button></a>
        </div>
      </div>
    </div>
  </div>

</div>
</div>
</div>
</section>

</div>

<!-- Added By Sagar-->
<?php
if($pcnt<=0){
	if(count($products->ListCartItem)>0){ ?>
	<div  class="model_reorder_check modal" data-backdrop="static" data-keyboard="false" id="reorder_ver_modal" role="dialog">
    <div  class="modal-dialog">
      <div  class="modal-content">
        <div  class="modal-header">
         <button  class="close" data-dismiss="modal" type="button">??</button>
         <h4  class="modal-title text-center">Review Cart</h4>
        </div>

      <div class="modal-body text-center">
        <div class="row">
          <div class="col-md-12 col-xs-9">
            <div class="modal-captions">
              <p>The requested products are not available now.</p>
            </div>
          </div><hr>
        </div>  
      </div>
      <div class="modal-footer text-center buttons-container">
        <button class="btn btn-primary reorder_chk_ok" data-dismiss="modal" type="button">OK</button>  
      </div>
  </div>
</div>
</div>
<?php } } ?>
<!-- Added By Sagar-->

<!--modal start-->
<div  class="model_quanity_check modal fade animated fadeInRightBig" data-backdrop="static" data-keyboard="false" id="quantity_ver_modal" role="dialog">
    <div  class="modal-dialog">
      <div  class="modal-content">
        <div  class="modal-header">
         <button  class="close" data-dismiss="modal" type="button">??</button>
         <h4  class="modal-title text-center">Review Cart</h4>
        </div>

      <div class="modal-body text-center">
        <div class="row">
          <div class="col-md-3 col-xs-3">
            <div class="product-image">
              <img class="img-responsive" id="quan_img" src="">
            </div>
          </div>
          <div class="col-md-5 col-xs-9"><br>
            <div class="modal-captions"><h5 id="quan_title"></h5></div>
          </div>
          <div class="col-md-4 col-xs-9">
            <div class="modal-captions">
              <p>Quantity Requested: <span id="quan_req"></span></p>
              <p>Quantity Available: <span id="quan_available"></span></p>
            </div>
          </div><hr>
        </div>  
      </div>
      <div class="modal-footer text-center buttons-container">
        <button class="btn btn-primary quantity_chk_ok" data-dismiss="modal" type="button">OK</button>  
      </div>
  </div>
</div>
</div>
</div>
<!-- modal end -->

<?php loadView('footer', array('store_details' => $store_details, 'store_home_details'=>$store_home_details));?>
