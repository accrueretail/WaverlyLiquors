<?php 
$title = $siteName;

$pro_title = "Order Alcohol Online | Alcohol Delivered from ".$store_details->StoreName.", ".$store_details->City.", ".$store_details->State;
$meta_desc = "Order or buy Alcohol online and get alcohol ( beer, liquor, wine ) delivered to your doorstep or for a curbside pick up. ".$store_details->StoreName." is one of the leading online liquor store in ".$store_details->City.", ".$store_details->State.".";


loadView('header', array('title' => $pro_title, 'store_details' => $store_details, 'meta_desc' => $meta_desc));
?>
    
<div class="slide ">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <?php
          $banner_cnt = 0;
          foreach($banners as $banner) {
          ?>
            <div class="item <?php if($banner_cnt == 0){ echo 'active';} ?>" >
            <img src="<?php echo $banner->BannerURL; ?>"  class="carousel-img" alt="<?php echo $banner->BannerTitle; ?>">
            </div>
          <?php $banner_cnt++; } ?>
        </div>
      </div>
</div>
<input type="hidden" name="session_id" id="session_id" value="<?php echo $_SESSION['SESSION_ID'];?>">


<div  class="Searchrelated_div common-margin">
  <div class="Searchrelated_div-sub"> 
    <div class="row">
<div  class="bottom">
    <div  class=" col-lg-5 col-md-5 col-sm-5 col-xs-12 Searchrelated_noborder slideInUP wow delay-05s  animated">
    <h4 >Featured Products</h4>
</div>
<div  class="button_feature col-lg-7 col-md-7 col-sm-7 hidden-xs visible-sm visible-md visible-lg">
    <button  class="btn btn-default active featured-btn first-featured-btn" category="0">All</button>
<!--     <button  class="btn btn-default featured-btn" category="1">Beer</button> -->
    <button  class="btn btn-default featured-btn" category="2">Liquor</button>
    <button  class="btn btn-default featured-btn" category="3">Wine</button>
    <button  class="btn btn-default featured-btn" category="4">Mixers & More</button>
</div>
</div>
<div  class="row">
  <div class="col-md-12 featured-products-container">
  <?php
  $total_products = $products_json->TotalCount;
  $pageSize = 12;
  $no_of_pages = ceil($total_products/$pageSize);
  
  ?>
  <div id="featured_vals" fcategory="" fmaxpages="<?php echo $no_of_pages?>" fpage="1">
  <?php
  if(count($products)>0){
  foreach($products as $product){ ?>
    <div  class="col-lg-3 col-md-3 col-sm-12 col-xs-12 margin-bottom-20">
        <div  class="Main_bottlesection">
          <div  class="item_img circle">
            <div  class="img_div">
              <div  class="margin_bottom">
                <div  class="sale-tag">
                  <?php if($product->OfferIcon!='') { ?>
                  <img  class="img-responsive" src="<?php echo $product->OfferIcon;?>">
                  <?php } ?>
                </div>
                <div  class="col-md-12">
                  <div  class="row">
                    <div  class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                      <div  class="row">
                        <p  class="rating_star">
                            <span  class="star-rating" <?php if($product->Rating<=0){?>style="visibility: hidden; "<?php } ?>>
                              <i  class="fa fa-star"> </i>
                              <span ><?php echo $product->Rating; ?></span></span>
                            </p></div><div  class="row">
                              <i id="<?php echo $product->PID;?>" class="icon icon-favorites <?php if($product->IsFavorite){ echo 'active';}?>" aria-hidden="true"></i>
                            </div></div>
                            <div  class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                              <div  class="row">
                                <a  class="pimg" href="<?php echo $siteUrl;?>/online/buy-<?php echo slugify($product->ProductName)."-".$product->PID."-".$_SESSION['STORE_ID'];?>">
                                <img alt="<?php echo ucwords(strtolower($product->ProductName));?>"  class="second_img" src="<?php echo $product->ProductImg;?>"></a>
                              </div>
                            </div>
                            <div  class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                              <div  class="row">
                              <?php if($product->Inventory <= 0){?>
                                <i disabled="disabled" class="icon icon-remove-from-my-cart active" aria-hidden="true" ></i>
                                <?php }else{ ?>
                                <i id="<?php echo $product->PID;?>" class="icon  <?php if($product->InCart){ echo 'icon-remove-cart active';}else{ echo 'icon-add-to-my-cart';}?>" aria-hidden="true"></i>
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
			  <?php } ?>
                          <div  class="col-md-6 price">
                            <p  class=""><?php echo $product->OfferPriceDisplay;?></p>
                          </div>
                          <div  class="clearfix">

                          </div><div  class="col-md-12 producttitle">
			    <h5 class="productname">
				<a class="pimg" href="<?php echo $siteUrl;?>/online/buy-<?php echo slugify($product->ProductName)."-".$product->PID."-".$_SESSION['STORE_ID'];?>">
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
  <?php }}else{ echo '<div class="coming-soon">Featured Products Coming Soon..</div>';} ?>
  </div> 
</div>
 </div> 
 
 
 <?php if($no_of_pages>1){?>
      <?php //if($pageNumber <= 1){
        ?><?php
        // } 
        ?>
      <a aria-label="Previous"   tabindex="-1" page="<?php echo $pageNumber-1; ?>">
      <?php
      // if(($pageNumber-1) > 0){
        ?>
  <button _ngcontent-c14="" class="btn btn-default pull-left"  id="prev" onclick="productsPagination('Previous')" pageId="">Previous Page</button>
    <?php // }
      // else{
      // }
      ?>
      </a>
       <?php //if($pageNumber >= $no_of_pages){
         ?><?php
         // } 
         ?>
       <a aria-label="Next"   page="<?php echo $pageNumber+1; ?>">
       <?php //if(($pageNumber+1) <= $no_of_pages){
        ?>
   <button _ngcontent-c14="" class="btn btn-default pull-right" id="next" onclick="productsPagination('Next')" no_of_pages="<?php echo $no_of_pages;?>" pageId="">Next Page</button>
    <?php  
    // }
    //   else{
    //   }
      ?>
      
         </a>
      
    <?php } ?>
 
</div>
</div>
</div>
<section  class="bgr_img">
  <div  class="container">
    <div  class="display_center font_family_Montserrat_Bold slideInUP wow delay-05s  animated">
      <div  class="col-md-8 col-sm-8 col-xs-12">
        <div  class="row">
          <h2  class="download_app">CALENDAR OF EVENTS</h2>
          <h4 >Interested in tastings, educational seminars, special events? At Waverly Liquors. we always have something fun happening. Whether it’s our International Grand Tasting held twice a year, our many in-store weekly tastings or our popular Seminars that take place in our Education and Tasting center this is the place to be to check out what’s going on.</h4>
          <div  class="app-links-container">
            <div  class="">
              <a  class="btn-events" href="<?php echo $siteUrl;?>/events"> Current Event </a>
  </div>
</div> 
</div>
</div>
</div>
</div>
</section>


<!-- <div  class="col-md-12 col-xs-12 catdetails">
                        <div class="container">
                                  <div  class="row">
                                            <div  class="box-cat">
                                            <div  class="wine">
                                            <a  href="<?php echo $siteUrl;?>/about-wine"></a>
                                            </div></div>
<!--                                             <div  class="box-cat">
                                            <div  class="beer">
                                            <a href="<?php //echo $siteUrl;?>/about-beer"></a>
                                            </div>
                                            </div> -->
                                            <div  class="box-cat">
                                            <div  class="spirits">
                                            <a href="<?php echo $siteUrl;?>/spirits"></a>
                                            </div></div>
                                            <div  class="box-cat">
                                            <div  class="services">
                                            <a href="<?php echo $siteUrl;?>/services"></a>
                                            </div></div>
                                            <div  class="box-cat">
                                            <div  class="tasting">
                                            <a href="<?php echo $siteUrl;?>/tasting"></a>
                                            </div></div>
                                            <div  class="box-cat">
                                            <div  class="education">
                                            <a href="<?php echo $siteUrl;?>/education"></a>
                                            </div></div>
                                            <div  class="box-cat">
                                            <div  class="guide">
                                            <a  href="<?php echo $siteUrl;?>/guide"></a>
                                            </div>
                                </div>
        </div>
</div>
</div>

<?php loadView('footer', array('store_details' => $store_details, 'store_home_details'=>$store_home_details));?>
