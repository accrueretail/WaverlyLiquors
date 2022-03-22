<?php
//echo $response;
$output = json_decode($response);
//print_r($output);
if($func  == 'search'){
  $cnt=1;
  foreach($search_results->hits as $result){
    //if($cnt > 5){continue;}
    $cats = [];
    if($result->_source->pcat)
    array_push($cats, $result->_source->pcat);

    if($result->_source->ptype)
    array_push($cats, $result->_source->ptype);

    if($result->_source->pvarietal)
    array_push($cats, $result->_source->pvarietal);
    
    echo '
    <div class="border-bottom">
    <a href="'.$siteUrl.'/online/buy-'.slugify($result->fields->sproduct[0]->spname).'-'.$result->fields->sproduct[0]->spid.'-'.$_SESSION['STORE_ID'].'">
    <table class="pdd" width="98%">
     <tbody>
       <tr>
        <td class="text-center td15">
        <img aria-hidden="" height="20" style="vertical-align:middle;" src="'.$result->_source->pimage.'">
        </td>
        <td class="td85">
          <span class="title">
          <small class="titlebrk" style="font-weight: bold;">'.$result->fields->sproduct[0]->spname.'</small>
          </span><br>
          <span class="sz">
          <small>'.$result->_source->psize.'</small>
          </span><br>
          <span>
          <small class="catg">'.implode('/', $cats).'</small>
          <small class="red text-right">
          <span>
          <strong>$'.$result->fields->sproduct[0]->spprice.'</strong>
          </span>
          </small>
          </span>
        </td>
        </tr>
      </tbody>
    </table>
    </a>
    </div>
  ';
  $cnt++;
  }
} else if($func  == 'getProductsByCategoryId'){
$products = $output->ListProduct;
$total_products = $output->TotalCount;
$pageSize = 12;
$no_of_pages = ceil($total_products/$pageSize);
//print_r(($products));
//usort($products, 'compareByName');
echo '<div id="featured_vals" fcategory="'.$category.'" fmaxpages="'.$no_of_pages.'" fpage="1">';
if(isset($products) && count($products) > 0){
  foreach($products as $product){?>
    <div  class="col-lg-3 col-md-3 col-sm-12 col-xs-12 margin-bottom-20">
        <div  class="Main_bottlesection">
          <div  class="item_img circle">
            <div  class="img_div">
              <div  class="margin_bottom">
                <div  class="sale-tag">
                   <?php if($product->OfferIcon != ''){ ?>
                  <img class="img-responsive" src="<?php echo $product->OfferIcon;?>">
                  <?php } ?>
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
                                <a  class="pimg" href="<?php echo $siteUrl;?>/online/buy-<?php echo slugify($product->ProductName)."-".$product->PID."-".$_SESSION['STORE_ID'];?>">
				<img alt="<?php echo ucwords(strtolower($product->ProductName));?>"  class="second_img" src="<?php echo $product->ProductImg;?>"></a>
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
                            <h5  class="productname"><a class="pimg" href="<?php echo $siteUrl;?>/online/buy-<?php echo slugify($product->ProductName)."-".$product->PID."-".$_SESSION['STORE_ID'];?>"><?php echo $product->ProductName;?></a></h5>
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
  <?php }}else { echo '<div class="coming-soon">Featured Products Coming Soon...</div>';}
  echo "</div>";
  } else if($func  == 'getPagination'){
    //start pagination
    $products = $output->ListProduct;
    $total_products = $output->TotalCount;
    $pageSize = 12;
    $no_of_pages = ceil($total_products/$pageSize);

    echo '<div id="featured_vals" fcategory="'.$cat_id.'" fmaxpages="'.$no_of_pages.'" fpage="1">';
    //usort($products, 'compareByName');
    if(isset($products) && count($products) > 0){
      foreach($products as $product){?>
        <div  class="col-lg-3 col-md-3 col-sm-12 col-xs-12 margin-bottom-20">
            <div  class="Main_bottlesection">
              <div  class="item_img circle">
                <div  class="img_div">
                  <div  class="margin_bottom">
                    <div  class="sale-tag">
                       <?php if($product->OfferIcon != ''){ ?>
                      <img class="img-responsive" src="<?php echo $product->OfferIcon;?>">
                      <?php } ?>
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
                                    <a  class="pimg" href="<?php echo $siteUrl;?>/online/buy-<?php echo slugify($product->ProductName)."-".$product->PID."-".$_SESSION['STORE_ID'];?>">
            <img alt="<?php echo ucwords(strtolower($product->ProductName));?>"  class="second_img" src="<?php echo $product->ProductImg;?>"></a>
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
                                <h5  class="productname"><a class="pimg" href="<?php echo $siteUrl;?>/online/buy-<?php echo slugify($product->ProductName)."-".$product->PID."-".$_SESSION['STORE_ID'];?>"><?php echo $product->ProductName;?></a></h5>
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
      <?php }
      }else { echo '<div class="coming-soon">Featured Products Coming Soon..</div>';}
      echo "</div>";
      //end pagination
      } else if($func  == 'getRelatedProductsByCategory'){
    $products = $output->ListProduct;
    //print_r(($products));
    
    if(isset($products) && count($products) > 0){
      foreach($products as $product){
          
       ?>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 margin-bottom-20">
        <div class="Main_bottlesection">
        <div class="item_img circle">
        <div class="img_div">
        <div class="margin_bottom">
            <?php if($product->OfferIcon){ ?>
        <div class="sale-tag">
        <img class="img-responsive" src="<?php echo $product->OfferIcon;?>">
        </div>
            <?php } ?>
        <div class="col-md-12">
        <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
            <div class="row">
                <p class="rating_star">
                    <span class="star-rating" <?php if($product->Rating<=0){?>style="visibility: hidden; "<?php } ?>>
                        <i class="fa fa-star"> </i>
                        <span> <?php echo $product->Rating; ?></span>
                    </span>
                </p>
            </div>
            <div class="row">
                <i id="<?php echo $product->PID;?>" class="icon icon-favorites  <?php if($product->IsFavorite){ echo 'active';}?>" aria-hidden="true"></i>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="row">
        <a class="pimg" href="<?php echo $siteUrl;?>/online/buy-<?php echo slugify($product->ProductName)."-".$product->PID."-".$_SESSION['STORE_ID'];?>">
        <img  alt="<?php echo ucwords(strtolower($product->ProductName));?>" class="second_img" src="<?php echo $product->ProductImg;?>"></a>
        </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
        <div class="row">
        <i id="<?php echo $product->PID;?>" class="icon icon-add-to-my-cart <?php if($product->InCart){ echo 'active';}?>" aria-hidden="true"></i>
        </div>
        </div>
        </div>
        </div>
        </div>
        <div class="second_content" tabindex="0">
	   <div class="row">
        <?php if($product->OfferType == 'SALE'){ ?>
        <div class="col-md-6 strike_text">
        <div class=""><?php echo $product->PriceDisplay;?></div>
	    </div>
        <?php } ?> 
        <div class="col-md-6 price">
        <p class=""><?php echo $product->OfferPriceDisplay;?></p>
        </div>
        <div class="clearfix">

        </div><div class="col-md-12 producttitle">
        <h5 class="productname"><a class="pimg" href="<?php echo $siteUrl;?>/online/buy-<?php echo slugify($product->ProductName)."-".$product->PID."-".$_SESSION['STORE_ID'];?>"><?php echo $product->ProductName;?></a></h5>
        </div>
        <div class="col-md-12">
        <p class="product_size">
        <span><?php echo $product->Size;?></span>
        </p>
        </div>
        <div class="ptop15">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <p class="review">
        <a fragment="reviews" href="<?php echo $siteUrl;?>/online/buy-<?php echo slugify($product->ProductName)."-".$product->PID."-".$_SESSION['STORE_ID'];?>#reviews">
        <span class="first"><?php echo $product->ReviewCount; ?></span>
        <span class="reviews"> reviews</span></a>
        </p>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
       <?php
      }
    }
  }else if($func == 'getStoreDetails'){
      //echo $json_res->CustomerInfo->CartItemCount;
      //print_r($json_res->CustomerInfo);
      $result['CartItemCount'] = $json_res->CustomerInfo->CartItemCount;
      $result['StoreName'] = $json_res->CustomerInfo->StoreName;
      $result['FirstName'] = $_SESSION['FirstName'] = $json_res->CustomerInfo->FirstName;
      $result['LastName'] = $_SESSION['LastName'] = $json_res->CustomerInfo->LastName;
      $result['EmailId'] = $_SESSION['EmailId'] = $json_res->CustomerInfo->EmailId;
      $result['ContactNo'] = $_SESSION['ContactNo'] = $json_res->CustomerInfo->ContactNo;
      $result['Gender'] = $_SESSION['Gender'] = $json_res->CustomerInfo->Gender;
      
      echo json_encode($result);
  }else if($func == 'login' || $func == 'signup'){
    if($json_res->SessionId != ''){
      echo '1';
    }
    else{
      echo $json_res->ErrorMessage;
    }
  }else if($func == 'logout'){
    echo '1';
  }else if($func  == 'relatedProducts'){

    $products = $json_res->ListProduct;
    //print_r(($products));
    
    if(isset($products) && count($products) > 0){
      foreach($products as $product){
          
       ?>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 margin-bottom-20">
        <div class="Main_bottlesection">
        <div class="item_img circle">
        <div class="img_div">
        <div class="margin_bottom">
            <?php if($product->OfferIcon){ ?>
        <div class="sale-tag">
        <img class="img-responsive" src="<?php echo $product->OfferIcon;?>">
        </div>
            <?php } ?>
        <div class="col-md-12">
        <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
            <div class="row">
                <p class="rating_star">
                    <span class="star-rating" <?php if($product->Rating<=0){?>style="visibility: hidden; "<?php } ?>>
                        <i class="fa fa-star"> </i>
                        <span> <?php echo $product->Rating; ?></span>
                    </span>
                </p>
            </div>
            <div class="row">
                <i id="<?php echo $product->PID;?>" class="icon icon-favorites  <?php if($product->IsFavorite){ echo 'active';}?>" aria-hidden="true"></i>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="row">
        <a class="pimg" href="<?php echo $siteUrl;?>/online/buy-<?php echo slugify($product->ProductName)."-".$product->PID."-".$_SESSION['STORE_ID'];?>">
        <img  alt="<?php echo ucwords(strtolower($product->ProductName));?>" class="second_img" src="<?php echo $product->ProductImg;?>"></a>
        </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
        <div class="row">
        <?php if($product->Inventory <= 0){?>
        <i disabled="disabled" class="icon icon-remove-from-my-cart active" aria-hidden="true" ></i>
        <?php }else{ ?>
        <i id="<?php echo $product->PID;?>" class="icon icon-add-to-my-cart <?php if($product->InCart){ echo 'active';}?>" aria-hidden="true"></i>
        <?php } ?>
        </div>
        </div>
        </div>
        </div>
        </div>
        <div class="second_content" tabindex="0">
        <div class="row">
	<?php if($product->OfferType == 'SALE'){ ?>  
        <div class="col-md-6 strike_text">
        <div class=""><?php echo $product->PriceDisplay;?></div>
        </div>
	<?php } ?>
        <div class="col-md-6 price">
        <p class=""><?php echo $product->OfferPriceDisplay;?></p>
        </div>
        <div class="clearfix">

        </div><div class="col-md-12 producttitle">
	<h5 class="productname">
	<a class="pimg" href="<?php echo $siteUrl;?>/online/buy-<?php echo slugify($product->ProductName)."-".$product->PID."-".$_SESSION['STORE_ID'];?>">
	<?php echo $product->ProductName;?>
	</a></h5>
        </div>
        <div class="col-md-12">
        <p class="product_size">
        <span><?php echo $product->Size;?></span>
        </p>
        </div>
        <div class="ptop15">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <p class="review">
        <a fragment="reviews" href="<?php echo $siteUrl;?>/online/buy-<?php echo slugify($product->ProductName)."-".$product->PID."-".$_SESSION['STORE_ID'];?>#reviews">
        <span class="first"><?php echo $product->ReviewCount; ?></span>
        <span class="reviews"> reviews</span></a>
        </p>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
       <?php
      }
    }

  }elseif($func == 'cartUpdate'){
    echo $cart_update_response->DeliveryAddress->Remark;
  }else{
    echo json_encode($json_res);
  }?>
