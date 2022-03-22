<?php 
$title = ucwords(strtolower($product['Product']['ProductName']));

$pro_title = "Order ".$title." Online | ".$product['Category']." Delivered from ".$store_details->StoreName.", ".$store_details->City.", ".$store_details->State;
$meta_desc = "Order or buy ".$title." online from ".$store_details->StoreName." in ".$store_details->City.", ".$store_details->State.". Get ".$product['Category']." delivered to your doorstep or for a curbside pick up from the leading ".$product['Category']." store - ".$store_details->StoreName.", ".$store_details->City.", ".$store_details->State;

loadView('header', array('title' => $pro_title, 'store_details' => $store_details, 'meta_desc' => $meta_desc));
?>
<div  class="container sresult">
        <div  class="row">
        <div  class="Search_div col-md-12 col-sm-12 col-lg-12 col-xs-12">
        <h4>Product</h4>
        <ol class="breadcrumb">
        <li class="breadcrumb-item">
        <a href="<?php echo $siteUrl; ?>">Home</a>
       </li>
       <li  class="breadcrumb-item">
        Product Details
    </li>
    <li><?php echo $product['Product']['ProductName'];?></li>
</ol>
</div>
</div>
</div>

   
<div class="product-detail-main">

<section  class="content">
<div  class="container">
<div  class="row">
  <div  class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
    <div  class="product_img">
      <div  class="favorite-container">
        <div  class="favorite-selection">
<i  class="icon icon-favorites pro-detail <?php if($product['Product']['IsFavorite']){ echo 'active';}?> " id="<?php echo $product['Product']['PID']; ?>"></i>
</div>
</div>
<img  class="second_img img-responsive" src="<?php echo $product['Product']['ProductImg'];?>" alt="<?php echo ucwords(strtolower($product['Product']['ProductName']));?>" >
</div>
</div>

<div  class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
  <div  class="product_content">
    <h1><?php echo $product['Product']['ProductName'];?></h1>
    <div >
    <ul>
  <li>
  <a id="product_category" category="<?php echo $product['CategoryId'];?>" type="<?php echo $product['TypeId'];?>" href="<?php echo $siteUrl.'/buy-'.slugify($product['Category']);?>"> <?php echo $product['Category'];?> </a>
</li>
<?php if($product['Type']){ ?>
<li>
<a href="<?php echo $siteUrl.'/buy-'.slugify($product['Category']).'/'.slugify($product['Type']);?>"><i  aria-hidden="true" class="fa fa-angle-right"></i> <?php echo $product['Type'];?> </a>
</li>
<?php } ?>

<?php if($product['Varietal']){ ?>
<li>
<a href="<?php echo $siteUrl.'/buy-'.slugify($product['Category']).'/'.slugify($product['Varietal']);?>"><i  aria-hidden="true" class="fa fa-angle-right"></i> <?php echo $product['Varietal'];?> </a>
</li>
<?php } ?>

<?php if($product['Region']){ ?>
<li>
<a href="javascript:void(0);"><i  aria-hidden="true" class="fa fa-angle-right"></i> <?php echo $product['Region'];?> </a>
</li>
<?php } ?>


<?php if($product['Country']){ ?>
<li>
<a href="javascript:void(0);"><i  aria-hidden="true" class="fa fa-angle-right"></i> <?php echo $product['Country'];?> </a>
</li>
<?php } ?>


</ul>
</div>
<div  class="customers_review">
  <div class="pull-left">
<?php if($product['Product']['OfferType'] == 'SALE'){ ?>
<p  class="strike_text"><?php echo $product['Product']['PriceDisplay'];?></p>
<?php } ?>
<span ><?php echo $product['Product']['OfferPriceDisplay'];?></span>
</div>
<div class="pull-right">
<ul  class="review-right">
  <li>
  <span  class="star-rating" <?php if($product['RatingAverage']<=0){?>style="visibility: hidden; "<?php }?>>
  <i  class="fa fa-star"></i><span > <?php echo $product['RatingAverage'];?></span></span>
  <small  class="review-caption"><a href="#reviews">(<?php echo $product['ReviewTotalCount'];?> Customer reviews)</a></small></li>
</ul>
</div>
</div>
<div  class="padding_bottom">
  <span  class="size_bottle"><?php echo $product['Product']['Size'];?></span>
  <span  class="float_right">SKU: <?php echo $product['Product']['SKU'];?> </span>
</div>
<p  class="font_size"> <?php echo $product['Product']['ProductName'];?> </p>
</div>
<div  class="row">
<div  class="size">
<div  class="margin_top col-md-12 col-sm-12 col-lg-8 col-xs-12">
  <div  class="row">
  <div  class="col-md-12 col-xs-12">
    <label  class="sizelabel">Qty</label>
  </div>
  <div  class="col-md-4 col-xs-5">
    <div  class="select-bg">
    <input maxlength="6" id="qnty_text" value="<?php if($product['Product']['InCart'] <=0){echo '1';}else{echo $product['Product']['InCart'];}?>" class="inputqty form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" <?php if($product['Product']['InCart'] > 0 || $product['Product']['Inventory'] <= 0){ echo "disabled='disabled'";} ?>>	
    <select  class="selectsize form-control classic" <?php if($product['Product']['InCart'] > 0 || $product['Product']['Inventory'] <= 0){ echo "disabled='disabled'";} ?>>
      <?php for($i=1; $i<=100; $i++){?>
        <option <?php if($product['Product']['InCart'] == $i){ echo "selected";} ?>><?php echo $i;?></option>
      <?php } ?>
      </select>
    </div>
  </div>
  <div  class="col-md-5 col-xs-7">
    <?php if($product['Product']['Inventory'] <= 0){ ?>
      <button  class="btn btn-default addtocart" disabled="disabled">Out of Stock</button>
    <?php }else{?>
    <button  class="btn btn-default addtocart <?php if($product['Product']['InCart'] > 0){ echo "remove_from_cart";} ?>" pid="<?php echo $product['Product']['PID'];?>">
    <?php if($product['Product']['InCart'] > 0){ ?>
      Remove from Cart
    <?php } else {?>
      Add to Cart
    <?php } ?>
    </button>
    <?php } ?>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</section>

<div  class="container sresult">
  <div  class="row">
  <div  class="Search_div col-md-12 col-sm-12 col-lg-12 col-xs-12">
  <h4>Related Products</h4>
  <ol class="breadcrumb">
  <li class="breadcrumb-item">
<a href="javascript:void(0);" class="view_more" page="2" type="<?php echo $product_type_id;?>">View More</a> 
</li>
</ol>
</div>
</div>
</div>

<div class="related-products">
<div class="container">
<div class="row related-products-container"> 
Loading...
</div> 
</div>
</div>

<section  id="reviews">
  <div  class="container" id="reviews">
  <div  class="total_border write-review">
    <h4  class="review_title">Reviews</h4>
       <?php
           if(count($reviews['ListReview']) > 0 || $reviews['UserReview']['ReviewId']>0){
            foreach($reviews['ListReview'] as $review){
        ?>
  <div class="reviews listr" id="exreview">
    <div class="col-md-12">
      <div class="row">
        <div class="user-review-dp">
          <img class="img-responsive" src="<?php echo $review['UserImage'];?>"  style="width:54px;height:54px;border-radius:50%;">
        </div>
        <div class="user-review-content">
          <div class="name_date">
            <span class="title"><?php echo $review['UserName'];?></span> - <small class="text-muted"> <?php echo $review['TimePeriod'];?></small>
          </div>
	  <?php if($review['UserId'] == $_SESSION['USER_ID']){ ?>
	  <div class="review-edit"><span class="fa fa-pencil edit-icon"></span></div>
	  <?php } ?>
          <div class="star_right rating-stars">
            <span class="star-rating"><i class="fa fa-star"></i><span> <?php echo $review['ReviewRating'];?></span></span>
          </div>
          <p class="caption"><?php echo $review['ReviewTitle'];?></p>
          <p class="word_break caption"> <?php echo $review['ReviewDescription'];?> </p>
        </div>
      </div>
    </div>
  </div>
  <?php }
  /*if($product['UserReview']['ReviewId']>0){
  ?>
  <div class="reviews" id="exreview">
    <div class="col-md-12">
      <div class="row">
        <div class="user-review-dp">
          <img class="img-responsive" src="<?php echo $product['UserReview']['UserImage'];?>"  style="width:54px;height:54px;border-radius:50%;">
        </div>
        <div class="user-review-content">
          <div class="name_date">
            <span class="title"><?php echo $product['UserReview']['UserName'];?></span> - <small class="text-muted"> <?php echo $product['UserReview']['TimePeriod'];?></small>
          </div>
          <div class="review-edit"><span class="fa fa-pencil edit-icon"></span></div>
          <div class="star_right rating-stars">
            <span class="star-rating"><i class="fa fa-star"></i><span> <?php echo $product['UserReview']['ReviewRating'];?></span></span>
          </div>
          <p class="caption review_title"><?php echo $product['UserReview']['ReviewTitle'];?></p>
          <p class="word_break caption review_desc"> <?php echo $product['UserReview']['ReviewDescription'];?> </p>
        </div>
      </div>
    </div>
  </div>
  <?php } */ ?>
  <?php }else{ ?>
    <p  class="no-reviews">There are no customer reviews yet.</p><div >
  <?php } ?>
  <div id="reviews_show">
  </div>
  <div  class="all-reviews-block">
     <div  class="collapse" id="demo">
      </div>
	<?php if($reviews['TotalCount']>3){?>
       <a class="more-reviews fa fa-angle-down arotate" data-toggle="collapse" href="#demo" id="rotate" page_num="2"></a>
	<?php } ?>
       </div>
     </div>
  <div>
  <?php //print_r($product);?>
  <div  class="add_review common_width" <?php if($product['UserReview']['ReviewId']>0){?> style="display:none;" <?php } ?>>
     <h4 >Add A Review</h4>
      <form  name="review" method="POST" class="reviewform">
     <p >Your email address will not be published. Required Field is marked <span  class="mandatory">*</span></p>
     <br ><div  class="col-lg-12 col-md-12 col-sm-12 col-sm-12 col-xs-12 star_right">
     <div  class="row">
      <div  class="form-group row">
         <div  class="your_rating col-lg-2 col-md-2 col-sm-2 col-xs-12">
           <label  class="col-form-label" for="inputPassword">Ratings <span  class="mandatory">*</span>
           </label>
         </div>
 
           <div  class="star_right col-lg-10 col-md-10 col-sm-10 col-xs-12 rating-stars">
              <span  class="rating-icon">
               <?php if($product['UserReview']['ReviewRating'] > 0){ for($s=1;$s<=5;$s++){?>
               <a >
                    <i  class="fa <?php if($s<=$product['UserReview']['ReviewRating']){ echo "fa-star";}else{echo "fa-star-o";}?>"></i>
               </a>
                    <?php } }else{ ?>
               <a >
                <i  class="fa fa-star-o"></i>
               </a>
              <a >
                <i  class="fa fa-star-o"></i>
              </a>
               <a >
                <i  class="fa fa-star-o"></i>
               </a>  
              <a >
                <i  class="fa fa-star-o"></i>
               </a>
               <a >
                  <i  class="fa fa-star-o"></i>
               </a>
              <?php } ?>
             </span>
           </div>
      </div>
  <div  class="form-group row hidden">
    <label  class="col-sm-2 col-form-label" for="inputPassword">Title </label>
    <div  class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
      <input  class="form-control " value="<?php echo $product['UserReview']['ReviewTitle'];?>" name="rTitle" id="inputPassword" placeholder="Review Headline" type="text"></div>
    </div>
    <div  class="form-group row">
      <label  class="col-lg-2 col-md-2 col-sm-2 col-xs-12 col-form-label">Review </label>
      <div  class="col-lg-6 col-md-6 col-sm-10 col-xs-12">
      <textarea  class="form-control addreviewmsg " name="rDescription" rows="3"><?php echo $product['UserReview']['ReviewDescription'];?></textarea>
    </div>
  </div>
  <div  class="form-group row">
    <input type="hidden" id="rating_score" name="rating_score" value="<?php echo $product['UserReview']['ReviewRating'];?>">
    <input type="hidden" id="ReviewId" name="ReviewId" value="<?php echo $product['UserReview']['ReviewId'];?>">
    <label  class="col-sm-2 col-form-label" for="inputPassword"></label>
    <div  class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
      <button  class="btn reviewsubmit" type="submit">Submit</button>
    </div>
  </div>


  </div>
  </div>
  </form>
  </div>
 
  </div>
  </div>
  </div>
  </section>

</div>

<input type="hidden" id="q_available" value="<?php echo $product['Product']['Inventory'];?>">
<div  class="model_quanity_check modal fade animated fadeInRightBig" data-backdrop="static" data-keyboard="false" id="quanityModal" role="dialog">
    <div  class="modal-dialog">
      <div  class="modal-content">
        <div  class="modal-header">
         <button  class="close" data-dismiss="modal" type="button">×</button>
         <h4  class="modal-title text-center">Product Details</h4>
        </div>

      <div class="modal-body text-center">
        <div class="row">
          <div class="col-md-3 col-xs-3">
            <div class="product-image">
              <img class="img-responsive" src="<?php echo $product['Product']['ProductImg'];?>">
            </div>
          </div>
          <div class="col-md-5 col-xs-9"><br>
            <div class="modal-captions"><h5><?php echo $product['Product']['ProductName'];?></h5></div>
          </div>
          <div class="col-md-4 col-xs-9">
            <div class="modal-captions">
              <p>Quantity Requested: <span id="quan_req"></span></p>
              <p>Quantity Available: <span><?php echo $product['Product']['Inventory'];?></span></p>
            </div>
          </div><hr>
        </div>  
      </div>
      <div class="modal-footer text-center buttons-container">
        <button class="btn btn-primary quantity_ok" data-dismiss="modal" type="button">OK</button>  
      </div>
  </div>
</div>
</div>
</div>

<?php loadView('footer', array('store_details' => $store_details, 'store_home_details'=>$store_home_details));?>
