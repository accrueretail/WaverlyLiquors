<?php 
$title = $siteName;

$pro_title = "Featured Alcohol Products | Buy Alcohol from ".$store_details->StoreName.", ".$store_details->City.", ".$store_details->State;
$meta_desc = "Order or buy Alcohol online from ".$store_details->StoreName." in ".$store_details->City.", ".$store_details->State.". ".$store_details->StoreName." is one of the leading online liquor store in ".$store_details->City.", ".$store_details->State.". Check out some of your featured products on this page.";

loadView('header', array('title' => $pro_title, 'store_details' => $store_details, 'meta_desc' => $meta_desc));
?>
 
<input type="hidden" name="session_id" id="session_id" value="<?php echo $_SESSION['SESSION_ID'];?>">

<div class="feature-product-main">
<div  class="Searchrelated_div common-margin feature-products">
  <div class="Searchrelated_div-sub"> 
    <div class="row">
		<div  class="bottom">
			<div  class=" col-lg-5 col-md-5 col-sm-5 col-xs-12 Searchrelated_noborder slideInUP wow delay-05s  animated">
				<h4 >Featured Products</h4>
			</div>
			<div  class="button_feature col-lg-7 col-md-7 col-sm-7 hidden-xs visible-sm visible-md visible-lg">
				<button  class="btn btn-default active featured-btn" category="0">All</button>
				<button  class="btn btn-default featured-btn" category="1">Beer</button>
				<button  class="btn btn-default featured-btn" category="2">Liquor</button>
				<button  class="btn btn-default featured-btn" category="3">Wine</button>
				<button  class="btn btn-default featured-btn" category="4">Mixers & More</button>
			</div>
		</div>

<div  class="row">
  <div class="col-md-12 featured-products-container">
<?php
if(count($products)>0){
  foreach($products as $product){?>
    <div  class="col-lg-3 col-md-3 col-sm-12 col-xs-12 margin-bottom-20">
        <div  class="Main_bottlesection">
          <div  class="item_img circle">
            <div  class="img_div">
              <div  class="margin_bottom">
                <div  class="sale-tag">
                  <img  class="img-responsive" src="<?php echo $product->OfferIcon;?>">
                </div>
                <div  class="col-md-12">
                  <div  class="row">
                    <div  class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                      <div  class="row">
                        <p  class="rating_star">
                            <span  class="star-rating" <?php if($product->Rating<=0){?>style="visibility: hidden; "<?php } ?>>
                              <i  class="fa fa-star"> </i>
                              <span > <?php echo $product->Rating; ?></span></span>
                            </p></div><div  class="row">
                              <i id="<?php echo $product->PID;?>" class="icon icon-favorites  <?php if($product->IsFavorite){ echo 'active';}?>" aria-hidden="true"></i>
                            </div></div>
                            <div  class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                              <div  class="row">
                                <a  class="pimg" href="<?php echo $siteUrl;?>/online/buy-<?php echo slugify($product->ProductName)."-".$product->PID;?>">
                                <img  alt="<?php echo ucwords(strtolower($product->ProductName));?>" class="second_img" src="<?php echo $product->ProductImg;?>"></a>
                              </div>
                            </div>
                            <div  class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                              <div  class="row">
                                <i id="<?php echo $product->PID;?>" class="icon <?php if($product->InCart){ echo 'icon-remove-cart active';}else{ echo 'icon-add-to-my-cart';}?>" aria-hidden="true"></i>
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
			  <?php } ?>
                          <div  class="col-md-6 price">
                            <p  class=""><?php echo $product->OfferPriceDisplay;?></p>
                          </div>
                          <div  class="clearfix">

                          </div><div  class="col-md-12 producttitle">
			    <h5  class="productname">
				<a class="pimg" href="<?php echo $siteUrl;?>/online/buy-<?php echo slugify($product->ProductName)."-".$product->PID;?>">
				<?php echo $product->ProductName;?>
				</a>
			   </h5>
                          </div>
                          <div  class="col-md-12">
                            <p  class="product_size">
                              <span ><?php echo $product->Size;?></span>
                            </p>
                          </div>
                          <div  class="ptop15">
                            <div  class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                              <p  class="review">
                                <a  fragment="reviews" href="<?php echo $siteUrl;?>/online/buy-<?php echo slugify($product->ProductName)."-".$product->PID;?>#reviews">
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
  <?php } }else{ echo '<div class="coming-soon">Featured Products Coming Soon..</div>'; } ?>
 </div>
 </div>  
 
</div>
</div>
</div>
</div>




<?php loadView('footer', array('store_details' => $store_details, 'store_home_details'=>$store_home_details));?>
