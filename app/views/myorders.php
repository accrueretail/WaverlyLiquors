<div class="">
  <div class="col-md-12">
    <div class="row">
    <div class=" border-line col-md-12 col-sm-12 col-lg-12 col-xs-12">
        <h4>My Orders</h4>
    </div>
    </div>
  </div>
<section>
  <?php
  //print_r($result);
  $total_orders = (int)$result['OrderCount'];
  $PageNumber = $pageNumber = (int)$result['PageNumber'];
  $PageSize = 10;
  $no_of_pages = ceil($total_orders/$PageSize);
 
  ?>
    <div class="col-md-12">
      <div class="col-xs-12">
        <div class="row">
          <?php
          if($no_of_pages > 1){ 
            ?>
            <div class="page-navigation" style="display: block;">
            <div class="f-page-navigation">
              <div role="navigation" >
              <ul class="pagination">

        <li class="page-item <?php if($pageNumber <= 1){?>disabled<?php } ?>">
        <a aria-label="First" class="page-link prev_next" href="<?php echo $siteUrl;?>/myaccount/myorders/1" tabindex="-1">
          <span aria-hidden="true">««</span>
        </a>
      </li>
      <li class="page-item <?php if($pageNumber <= 1){?>disabled<?php } ?>">
        <a aria-label="Previous" class="page-link prev_next" href="<?php echo $siteUrl;?>/myaccount/myorders/<?php echo $pageNumber-1;?>" tabindex="-1" >
          <span aria-hidden="true">«</span>
        </a>
      </li>
      <?php ?>
      <li class="page-item <?php if($pageNumber == '1'){echo 'active';}?>">
        <a class="page-link" href="<?php echo $siteUrl;?>/myaccount/myorders/1"> 1 
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
        <a class="page-link <?php echo $i;?>" href="<?php echo $siteUrl;?>/myaccount/myorders/<?php echo $i;?>" > <?php echo $i;?> </a>
      </li>
      <?php }} ?>
      <?php for($i=$pageNumber; $i<=$pageNumber+2 && $i<$no_of_pages;$i++){ if($i>1){?>
        <li class="page-item <?php if($pageNumber == $i){echo 'active';}?>">
        <a class="page-link" href="<?php echo $siteUrl;?>/myaccount/myorders/<?php echo $i;?>"> <?php echo $i;?> </a>
      </li>
      <?php }} ?>

      <?php if($pageNumber<$no_of_pages-3){ ?>
      <li class="page-item disabled">
        <a class="page-link">...</a>
      </li>
      <?php } ?>
      <li class="page-item <?php if($pageNumber == $no_of_pages){echo 'active';}?>">
        <a class="page-link" href="<?php echo $siteUrl;?>/myaccount/myorders/<?php echo $no_of_pages;?>"> <?php echo $no_of_pages;?> </a>
      </li>
      <li class="page-item  <?php if($pageNumber >= $no_of_pages){?>disabled<?php } ?>">
        <a aria-label="Next" class="page-link prev_next" href="<?php echo $siteUrl;?>/myaccount/myorders/<?php echo $pageNumber+1;?>" >
          <span aria-hidden="true">»</span>
        </a>
      </li>
      <li class="page-item <?php if($pageNumber >= $no_of_pages){?>disabled<?php } ?>">
        <a aria-label="Last" class="page-link prev_next" href="<?php echo $siteUrl;?>/myaccount/myorders/<?php echo $no_of_pages;?>" >
          <span aria-hidden="true">»»</span>
        </a>
      </li>
      
              </ul>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
      
      <?php foreach($orders as $order){ //print_r($order)?>
      <div class="row">
        <div class=" border_bottom">
          <div class="delivery-head-section order_<?php echo $order['OrderId'];?>">
            <div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 first_sec">
              <h5>
                <span><img class="status" src="<?php echo $order['OrderStatusImage'];?>"></span>
                <span class="delevary_color" style="color:#f11b2e;"><?php echo $order['OrderStatus'];?></span>
              </h5>
            </div>
            <div class="float_right col-md-6 col-sm-6 col-lg-6 col-xs-12 hidden-xs hidden-sm visible-md visible-lg second_sec">
              <ol class="breadcrumb myorder-details no-border pull-right">
                <li class="breadcrumb-item code myorder-status" style="width: 105px !important;">
                <a order_id="<?php echo $order['OrderId'];?>" href="#" class="order_reorder"><strong><img alt="Reorder" class="status-img" src="<?php echo $_SESSION['siteUrl'];?>/assets/images/Reorder.png"> Reorder</strong></a>
                </li>
                <?php if($order['IsCancellable'] == '1'){?>
                <li class="breadcrumb-item code myorder-status" style="margin-right: 5px;width: 105px; text-align: right;">
                <a href="#" order_id="<?php echo $order['OrderId'];?>" class="order_cancel" id="order_<?php echo $order['OrderId'];?>"><strong><i class="icon icon-cancel"></i> Cancel</strong></a>
                </li>
                <?php } ?>
                <li class="breadcrumb-item code myorder-status">
                  <a>#<?php echo $order['OrderNo'];?></a>
                </li>
              </ol>
            </div>
            <div class="float_right hidden-lg hidden-md visible-xs visible-sm">
              <ol class="breadcrumb myorder-details no-border">
                <li class="breadcrumb-item code myorder-status" style="width: 85px !important;">
                <a order_id="<?php echo $order['OrderId'];?>" href="#" class="order_reorder"><strong><img alt="Reorder" class="status-img" src="<?php echo $_SESSION['siteUrl'];?>/assets/images/Reorder.png"> Reorder</strong></a>
                </li>
                <?php if($order['IsCancellable'] == '1'){?>
                <li class="breadcrumb-item code myorder-status" style="margin-right: 5px;width: 105px; text-align: right;">
                <a href="#"  order_id="<?php echo $order['OrderId'];?>" class="order_cancel" id="order_<?php echo $order['OrderId'];?>"><strong><i class="icon icon-cancel"></i> Cancel</strong></a>
                </li>
                <?php } ?>
                <li class="breadcrumb-item code myorder-status"><a>#<?php echo $order['OrderNo'];?></a></li>
              </ol>
            </div>
          </div>
          <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 myorder-details">
            <table class="table table-condensed myorder-table hidden-xs hidden-sm visible-md visible-lg">
              <tbody>
                <?php foreach($order['ListOrderItem'] as $suborder){?>
                <tr>
                  <td width="5%">
                    <div class="product-image">
		      <img alt="<?php echo ucwords(strtolower($suborder['ProductName']));?>" class="second_img img-responsive" src="<?php echo $suborder['ProductImage'];?>">
                    </div>
                  </td>
                  <td width="40%">
                    <div class="Product_name">
                      <h5> <?php echo $suborder['ProductName'];?></h5>
                      <br><span class="font_size"><?php echo $suborder['UnitSize'];?></span>
                    </div>
                  </td>
                  <td width="15%">
                    <div>
                      <h5 class="Product_price"><?php echo $suborder['FinalPriceDisplay'];?></h5>
                    </div>
                  </td>
                  <td width="20%">
                    <div>
                      <h5 class="Product_price"> <?php echo $suborder['Quantity'];?></h5>
                      <h6 class="you_save">Quantity </h6>
                    </div>
                  </td>
                  <td width="20%">
                    <div>
                    <br><span class="total_price"> <?php echo $suborder['FinalItemTotalDisplay'];?> </span>
                    </div>
                  </td>
                </tr>
                <?php } ?>
                
              </tbody>
            </table>
            
            <div class="table table-condensed myorder-table hidden-lg hidden-md visible-xs visible-sm">
              <?php foreach($order['ListOrderItem'] as $suborder){?>
              <div class="row">
                <div class="col-xs-12 col-sm-2">
                  <div class="product-image">
                    <img class="second_img img-responsive row" src="<?php echo $suborder['ProductImage'];?>">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-10">
                  <div class="Product_name">
                    <h5> <?php echo $suborder['ProductName'];?> </h5>
                    <br><span class="font_size"><?php echo $suborder['UnitSize'];?></span>
                  </div>
                </div>
              </div>
              
              <div class="row">
                <div class="col-xs-4 col-sm-4">
                  <div>
                    <h5 class="Product_price"><?php echo $suborder['FinalPriceDisplay'];?></h5>
                  </div>
                </div>
                <div class="col-xs-4 col-sm-4">
                  <div>
                    <h5 class="Product_price qty-xs"> <?php echo $suborder['Quantity'];?></h5>
                    <h6 class="you_save ">Quantity </h6>
                  </div>
                </div>
                <div class="col-xs-4 col-sm-4">
                  <table>
                    <tbody>
                      <tr>
                        <td></td>
                      </tr>
                      <table>
                        <tbody>
                          <tr>
                            <td><span class="total_price"> <?php echo $suborder['FinalItemTotalDisplay'];?> </span></td>
                          </tr>
                        </tbody>
                      </table>
                    </tbody>
                  </table>
                </div>
              </div>
            
            <?php } ?>
            </div>
          </div>
          
          <div class="tfoot-order-summary hidden-xs hidden-sm visible-lg visible-md">
            <table>
              <tbody>
                <tr>
                  <td class="width_30">
                    <div class="margin_top_25 text-left">
                      <h5>
                        <span><i class="icon icon-recipt-date"></i></span>
                        <span class="date_time"><?php echo $order['TemplateOrderDate'];?></span>
                      </h5>
                    </div>
                  </td>
                  <td>
                    <table class="text_left">
                      <tbody>
                        <tr>
                          <td colspan="2">
                            <div class="order_total" id="order_total">
                              <h4> Order Total <span class="font_color"><?php echo $order['TotalValueDisplay'];?></span>
                              <button class="dec_circle toggle" id="sec_<?php echo $order['OrderId'];?>"><span class="fa fa-plus-circle"></span></button>
                              </h4>
                            </div>
                          </td>
                        </tr>
                        
                      </tbody>
                    </table>
                  </td>
                </tr>
                <tr class="order_addl_info sec_<?php echo $order['OrderId'];?>" style="display:none;">
                          <td class="text-left width50">
                            <div class="bottom-border">
                              <h5 class="summary">Special Instructions</h5>
                              <p><?php echo $order['UserNote'];?></p>
                            </div>
                            <div class="bottom-border">
                              <h5 class="summary">Store Notes</h5>
                              <p><?php echo $order['StoreNote'];?></p>
                            </div>
                          </td>
                          <td class="width50" valign="top">
                            <div class="bill_summary inner">
                              <table class="text_left">
                                <tbody>
                                  <tr>
                                    <td valign="top"><h5 class="summary text-right">Summary</h5></td>
                                    <td style="padding-right: 35px;">
                                    <table class="order-summary-expand pull-right">
                                      <tbody>
                                        <tr>
                                          <td class="text-left">Sub Total</td>
                                          <td class="text-right"><?php echo $order['SubTotalAfterDiscountDisplay'];?></td>
                                        </tr>
                                        <tr>
                                          <td class="text-left">Tax</td>
                                          <td class="text-right"> <?php echo $order['TotalChargesDisplay'];?> </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </td>
                        </tr>
              </tbody>
            </table>
          </div>
          <div class="tfoot-order-summary hidden-lg hidden-md visible-xs visible-sm pull-left">
            <div class="row">
              <div class="text-left col-md-6 col-sm-6">
                <h5>
                  <span><i class="icon icon-recipt-date"></i></span>
                  <span class="date_time"><?php echo $order['TemplateOrderDate'];?></span>
                </h5>
              </div>
              
              <div class="order_total pull-right col-md-6 col-sm-6" id="order_total">
                <h4> Order Total <span class="font_color"><?php echo $order['TotalValueDisplay'];?></span>
                <button class="dec_circle toggle"><span class="fa fa-minus-circle"></span></button>
                </h4>
              </div>
            </div>
          </div>
        </div>

    </div>
<?php } ?>


<div class="col-xs-12">
        <div class="row">
          <?php
          if($no_of_pages > 1){ 
            ?>
            <div class="page-navigation" style="display: block;">
            <div class="f-page-navigation">
              <div role="navigation" >
              <ul class="pagination">

        <li class="page-item <?php if($pageNumber <= 1){?>disabled<?php } ?>">
        <a aria-label="First" class="page-link prev_next" href="<?php echo $siteUrl;?>/myaccount/myorders/1" tabindex="-1">
          <span aria-hidden="true">««</span>
        </a>
      </li>
      <li class="page-item <?php if($pageNumber <= 1){?>disabled<?php } ?>">
        <a aria-label="Previous" class="page-link prev_next" href="<?php echo $siteUrl;?>/myaccount/myorders/<?php echo $pageNumber-1;?>" tabindex="-1" >
          <span aria-hidden="true">«</span>
        </a>
      </li>
      <?php ?>
      <li class="page-item <?php if($pageNumber == '1'){echo 'active';}?>">
        <a class="page-link" href="<?php echo $siteUrl;?>/myaccount/myorders/1"> 1 
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
        <a class="page-link <?php echo $i;?>" href="<?php echo $siteUrl;?>/myaccount/myorders/<?php echo $i;?>" > <?php echo $i;?> </a>
      </li>
      <?php }} ?>
      <?php for($i=$pageNumber; $i<=$pageNumber+2 && $i<$no_of_pages;$i++){ if($i>1){?>
        <li class="page-item <?php if($pageNumber == $i){echo 'active';}?>">
        <a class="page-link" href="<?php echo $siteUrl;?>/myaccount/myorders/<?php echo $i;?>"> <?php echo $i;?> </a>
      </li>
      <?php }} ?>

      <?php if($pageNumber<$no_of_pages-3){ ?>
      <li class="page-item disabled">
        <a class="page-link">...</a>
      </li>
      <?php } ?>
      <li class="page-item <?php if($pageNumber == $no_of_pages){echo 'active';}?>">
        <a class="page-link" href="<?php echo $siteUrl;?>/myaccount/myorders/<?php echo $no_of_pages;?>"> <?php echo $no_of_pages;?> </a>
      </li>
      <li class="page-item  <?php if($pageNumber >= $no_of_pages){?>disabled<?php } ?>">
        <a aria-label="Next" class="page-link prev_next" href="<?php echo $siteUrl;?>/myaccount/myorders/<?php echo $pageNumber+1;?>" >
          <span aria-hidden="true">»</span>
        </a>
      </li>
      <li class="page-item <?php if($pageNumber >= $no_of_pages){?>disabled<?php } ?>">
        <a aria-label="Last" class="page-link prev_next" href="<?php echo $siteUrl;?>/myaccount/myorders/<?php echo $no_of_pages;?>" >
          <span aria-hidden="true">»»</span>
        </a>
      </li>
      
              </ul>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>

</section>
</div>
