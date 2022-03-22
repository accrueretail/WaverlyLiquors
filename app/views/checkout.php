<?php 
$title = $siteName;
loadView('header', array('title' => $title, 'store_details' => $store_details));
session_start();
?>

<div  class="container sresult">
        <div  class="row">
        <div  class="Search_div col-md-12 col-sm-12 col-lg-12 col-xs-12">
        <h4>Checkout</h4>
        <ol class="breadcrumb">
        <li class="breadcrumb-item">
        <a href="<?php echo $siteUrl;?>">Home</a>
       </li>
       <li class="breadcrumb-item">
        <a href="<?php echo $siteUrl;?>/cart">Cart</a>
       </li>
       <li  class="breadcrumb-item">
        Checkout
    </li>
</ol>
</div>
</div>
</div>

<form id="checkout" name="checkout" action="<?php echo $siteUrl;?>/payment" method="POST">
<input type="hidden" name="cartinfo" id="cartinfo" value=''>
<div class="checkout-main">
<div class="container pbottom30">
<div class="row">
<?php if($routeParams['type'] == 'pickup'){ ?>
<div  class="col-lg-7 col-md-7 col-sm-7 col-xs-12 ">
<div  class="checkout-section">
<div  class="row">
<div  class="pickup-tile">
    <div  class="col-md-12">
    <h4>Pick-Up Address</h4>
    </div>
    <div class="col-md-12">
    <div class="row">
        <div class="pickup-section">
            <div  class="col-md-6">
                <h5  class="text-uppercase"><?php echo $store_details->StoreName;?></h5>
                <p><?php echo $store_details->Address1;?> <?php echo $store_details->Address2;?></p>
                <p><?php echo $store_details->City;?>, <?php echo $store_details->State;?> <?php echo $store_details->Zip;?></p>
            </div>
            <div  class="col-md-6">
                <h5  class="text-uppercase">Call <a  href="tel:<?php echo $store_details->ContactNo;?>"><?php echo $store_details->ContactNo;?></a></h5>
                <h5  class="text-uppercase">Email <a  href="mailto:<?php echo $store_details->StoreEmail;?>"><?php echo $store_details->StoreEmail;?></a></h5>
            </div>
        </div>
    </div>
    </div>
</div>
</div>
</div>
<div  class="col-md-12">
    <div  class="row">
    <h4 >Payment Method</h4>
    </div>
    </div>
    <div  class="col-md-12">
    <div  class="payment-method">
    <div  class="row ">
     <div  class="payment-option-select">
    <?php $cn=1;
     foreach($payment_methods_response->ListPaymentItem as $pay_method){ ?>
    <div  class="col-md-12 col-xs-12">
        <a  class="payatstorenew  <?php if($pay_method->IsDefault){ echo "active";}?>">
            <div  class="text-left">
                <!--<span  class="fa fa-circle-o "></span>
                <input class="radio-custom" id="radio" type="radio" name="" value="" >
                          <label class="radio-custom-label">
                                <span  class="payonline"> Pay By Phone </span>
                          </label>-->

               
                <input class="radio-custom" id="radio-<?php echo $cn;?>" type="radio" name="PaymentTypeId" value="<?php echo $pay_method->PaymentTypeId; ?>" 
                    <?php if($pay_method->IsDefault){echo "checked='checked'";}?> style="display:inline;">
                <label for="radio-<?php echo $cn;?>" class="radio-custom-label">
                    <?php if($pay_method->PaymentType == 'WP Hosted Checkout'){ ?>
                    <span  class="payonline"> Pay Online </span>
                    <?php } else { ?>
                    <span  class="payonline"> <?php echo $pay_method->PaymentType; ?> </span>
                    <?php } ?>
                </label>
            </div>
        </a>
    </div>
    <?php $cn++;} ?>
    
    </div>
    </div>
    </div>
</div>

<div  class="checkout-section">
<div  class="row">
<div  class="col-md-12">
<h5 >Special Instructions</h5>
<textarea  class="form-control textarea" rows="3" name="remarks" id="remarks"></textarea>
</div>
</div>
</div>

<span  class="puordelivery notification">Please wait for email notification that your order is ready for pickup.</span>
<span  class="puordelivery">Your ID and signature is required at the time of Pickup/Delivery</span>
</div>
<?php } else { ?>
<div  class="col-lg-7 col-md-7 col-sm-7 col-xs-12 ">
<div  class="checkout-section">
<?php 
//if(!$cart_update_response->CartDeliverySolution->FedexDeliveryCart->IsDefaultdeliveryCharge && !$cart_update_response->IsShipping){
if(strtolower($routeParams['type']) != 'shipping'){
if($store_details->IsScheduleDelivery){ ?>
<div class="delivery-options">
<div class="col-md-6">
<div class="row">    
<div class="">
<h5 class="text-muted">Schedule Delivery</h5>
</div>
<?php
$slot_dates = $slot_times = array();
//print_r($cart_update_response);
//DoPTimeSlot
foreach($cart_update_response->ListDoPTimeSlot as $time_slots){
    array_push($slot_dates, $time_slots->DoPDate);
    $slot_times[$time_slots->DoPDate][] = $time_slots->DoPSlot;
}
$slot_dates = array_unique($slot_dates);
//print_r($slot_dates);
//print_r($slot_times);
?>
<div class="col-md-6">
    <div class="row">
    <div class="input-container">
        <select class="form-control dateinput" id="dateList" name="dateList">
        <option value="" disabled="disabled">Select Date</option>
        <?php foreach($slot_dates as $slot_date){?>
        <option value="<?php echo $slot_date;?>" class="" <?php if($slot_date == $cart_update_response->DoPDate){ echo "selected='selected'";}?> > <?php echo $slot_date;?> </option>
        <?php } ?>
        </select>
        <i class="fa fa-calendar input-icon"></i>
    </div>
        </div>
</div>
<div class="col-md-6">
    <div class="input-container">
        <select class="form-control dateinput" id="timeList" name="timeList">
        <option  value=""  disabled="disabled">Select time</option>
	<?php 
        /*if($cart_update_response->DoPDate <= date("d-m-yy")){
        foreach($slot_times[$slot_dates[0]] as $slot_time){?>
        <option value="<?php echo $slot_time;?>" class="" <?php if($slot_time == $cart_update_response->DoPTimeSlot){ echo "selected='selected'";}?> > <?php echo $slot_time;?> </option>
        <?php }
}else{*/
        foreach($slot_times[$cart_update_response->DoPDate] as $slot_time){?>
        <option value="<?php echo $slot_time;?>" class="" <?php if($slot_time == $cart_update_response->DoPTimeSlot){ echo "selected='selected'";}?> > <?php echo $slot_time;?> </option>
	<?php } ?>
	<?php //} ?>
	</select>
        <i class="fa fa-clock-o input-icon"></i>
    </div>
</div>
        </div>

<div class="col-md-12"><br></div>
</div>
</div>
<?php }} ?>
<div  class="row">
<div  class="pickup-tile">
    <div  class="col-md-12">
    <h4>Address</h4>
	<input type="hidden" value="<?php echo $routeParams['type'];?>" id="ctype" name="ctype">
<div class="add-address-new"><a class="btn" href="<?php echo $siteUrl;?>/myaccount/manage-addresses?f=1&redirectURL=checkout/<?php echo $routeParams['type'];?>">Add New Address</a></div>
    </div>
    <div class="col-md-12">
    <input type="hidden" name="PaymentTypeId" value="8">
    <?php
    foreach($addresses['ListAddress'] as $address){
        $my_address = [];
        array_push($my_address, $address['Address1']);
        array_push($my_address, $address['Address2']);
        array_push($my_address, $address['City']);
        array_push($my_address, $address['State']);
        array_push($my_address, $address['Zip']);    
?>
    <div class="">
        <div class="checkout-tile checkout-addr-tile" CAddrId="<?php echo $address['AddressId'];?>" >
            <div class="dropdown dropdown-favorite">
                <a aria-expanded="false" aria-haspopup="true" class="text-muted" data-toggle="dropdown" id="dLabel" type="button"><span class="fa fa-ellipsis-v more-icon"></span></a>
                <ul aria-labelledby="dLabel" class="dropdown-menu dropdown-favorite-open">
                    <li><a href="<?php echo $siteUrl;?>/myaccount/edit-address/<?php echo $address['AddressId'];?>/?redirectURL=checkout/<?php echo $routeParams['type'];?>">Edit</a></li>
                </ul>
            </div>
            <div class="checkout-icon-style radiobox m-radio">
                <small class="text-muted">
		<input class="check_address" type="radio" name="address" value="<?php echo $address['AddressId'];?>" <?php if($cart_update_response->DeliveryAddress->AddressId == $address['AddressId']){ echo "checked='checked'";}?>>
		<span <?php if($cart_update_response->DeliveryAddress->AddressId == $address['AddressId']){ ?>class="fa fa-check-circle"<?php } ?>></span>
		</small>
            </div>
            <div class="checkout-content">
                <?php if($address['isDefault']){ ?>
                <small class="text-uppercase">Favorite</small>
                <?php } ?>
                <h4></h4>
                <p class="text-muted"><?php echo implode(', ',array_filter($my_address));?></p>
                <p class="bottles-brand addr_status">
                <?php
                if($cart_update_response->DeliveryAddress->AddressId == $address['AddressId']){ 
                    if(strpos(strtolower($cart_update_response->DeliveryAddress->Remark), 'address')){
                        echo $cart_update_response->DeliveryAddress->Remark;
                    }
                }
                ?>
                </p>
            </div>
        </div>
    </div>
    <?php } ?>
    </div>
</div>
</div>
</div>

<div  class="checkout-section">
<div  class="row">
<div  class="col-md-12">
<h5 >Special Instructions</h5>
<textarea  class="form-control textarea" rows="3" name="remarks" id="remarks"></textarea>
</div>
</div>
</div>
<?php if($routeParams['type'] != 'shipping'){ ?>
<span  class="puordelivery">Your ID and signature is required at the time of Pickup/Delivery</span>
<?php } ?>
</div>
<?php } ?>
<div  class=" col-lg-5 col-md-5 col-sm-5 col-xs-12">
<div  class="row">
<div  class="order-details-panel">
<table  class="first-table ">
<tbody >
<?php foreach($cart_update_response->ListCartItem as $cart_item){ ?>
<tr >
    <td  class="img-block" width="16%">
        <div  class="checkout-product-details">
        <a href="<?php echo $siteUrl;?>/online/buy-<?php echo slugify($cart_item->ProductName)."-".$cart_item->PID."-".$_SESSION['STORE_ID'];?>">
        <img alt="<?php echo ucwords(strtolower($cart_item->ProductName));?>" class="prod-img img-responsive" src="<?php echo $cart_item->ProductImage;?>">
        </a>
        </div>
    </td>
    <td  width="70%">
        <div  class="checkout-product-details checkout-info">
            <h4 ><?php echo $cart_item->ProductName;?></h4>
            <h6 ><?php echo $cart_item->PriceDisplay;?></h6>
            <p >Quantity: <?php echo $cart_item->QuantityOrdered;?> | <?php echo $cart_item->UnitSize;?></p>
            <p >SKU: <?php echo $cart_item->SKU;?> | UPC: <?php echo $cart_item->UPC;?></p>
        </div>
    </td>
    <td  class="text-right totalprice-right" width="16%">
    <div  class="checkout-product-details">
    <h5 ><?php echo $cart_item->ItemTotalDisplay;?></h5>
    </div>
    </td>
</tr>
<?php } ?>
</tbody>
</table>
<table  class="summary-container"  id="summary">
<tbody >
<tr >
<td  class="summary-block">
<h5 >Summary</h5>
</td>
<td >
<table >
<tbody >
<tr >
<td ></td>
<td >
<h5 >Sub Total</h5>
</td>
<td  class="text-right">
<h4 ><?php echo $cart_update_response->SubTotalDisplay;?></h4>
</td>
</tr>
<tr  class="tip-tr">
<td  width="25px">
</td>
<td >
<h5 class="savings_label"><?php if($cart_update_response->TotalSavings>0){?><i class="savings_icon fa fa-plus-circle"></i> <?php } ?>Savings</h5>
</td>
<td  class="text-right">
  <h4 class="tot_savings"><?php echo $cart_update_response->TotalSavingsDisplay;?></h4>
</td>
</tr>

<tr class="saving_display_sec" style="display:none;">
<td colspan="3">
<table>
<?php foreach($cart_update_response->ListDiscount as $discount){?>
<tr>
<td  width="25px">
</td>
<td >
<h5 ><?php echo $discount->DiscountTitle;?></h5>
</td>
<td  class="text-right">
  <h4><?php echo $discount->DiscountAmountDisplay;?></h4>
</td>
</tr>
<?php } ?>
</td>
</table>
</tr>

<?php foreach($cart_update_response->ListCharge as $charge){?>
<tr  class="">
<td  width="25px">
<?php if($charge->ChargeTitle == 'Tip'){?>
<a class="tip-icon exapand-icon ng-star-inserted"><span class="fa fa-minus-circle"></span></a>
<?php $selected_tip = $charge->ChargeAmountDisplay;} ?>
</td>
<td >
<h5 ><?php echo $charge->ChargeTitle;?></h5>
</td>
<td  class="text-right">
  <h4 class="<?php echo str_replace(' ','_',$charge->ChargeTitle);?>_sec" ><?php echo $charge->ChargeAmountDisplay;?></h4>
</td>
</tr>
<?php } ?>



<tr  class="" <?php if(count($cart_update_response->ListTipForDriver)<=0){ echo "style='display:none;'"; }?>>
<td  class="tipdown " colspan="3">
<table  class="exapnded-table">
<tbody >
<?php 
$tip_cnt = 0;
$check_flag = $ot_flag = 0;
//print_r($cart_update_response->ListTipForDriver);
foreach($cart_update_response->ListTipForDriver as $tip){

	if($cart_update_response->TipForDriver == $tip->TipAmount || $selected_tip == $tip->TipAmountDisplay){ echo "<input type='hidden' id='default_tip_id' value='".$tip_cnt."' >"; } 

if($tip->Percentage != 0){?>
<tr class="ng-star-inserted" percentage="<?php echo $tip->Percentage;?>">
    <td>
    <div class="radiobox m-radio">
    <small class="text-muted">
    <input id="<?php echo $tip_cnt; ?>" class="tip" name="tip" type="radio" s="<?php echo $selected_tip;?>" t="<?php echo $tip->TipAmount;?>"  <?php if($cart_update_response->TipForDriver == $tip->TipAmount || $selected_tip == $tip->TipAmountDisplay){ $check_flag=1; echo "checked='checked' default='true'"; } ?>> <?php echo $tip->TipAmountDisplay;?>(<?php echo $tip->Percentage;?>)% 
    <span class="checkmark"></span>
    </small>
    </div>
    </td>
    <td class="text-right"><small class="text-muted"></small></td>
</tr>
<?php  } else { $ot_flag = 1;?>
<?php if(count($cart_update_response->ListTipForDriver)>0){ ?>
<tr class="ng-star-inserted other">
    <td>
    <div class="radiobox m-radio">
    <small class="text-muted">
    <input id="<?php echo $tip_cnt; ?>" class="tip" name="tip" type="radio" <?php if($cart_update_response->TipForDriver == $tip->TipAmount && $check_flag!='1'){ echo "checked='checked'"; } ?>> Other($) 
    <span class="checkmark"></span>
    </small>
    </div>
    
    <div class="tip-container ng-star-inserted" <?php if($check_flag!='1'){ ?>style="display:block;"<?php }else{?>style="display:none;"<?php } ?>><input myautofocus="" placeholder="00.00" type="text" class="tip-amount ng-pristine ng-valid ng-touched" value="<?php if($check_flag!='1'){echo number_format($tip->TipAmount,2);}?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"></div>
    
    </td>
    <td class="text-right"><small class="text-muted"></small></td>
</tr>
<?php } }
$tip_cnt++;
} ?>

<?php
if($ot_flag == 0 && $routeParams['type'] == 'delivery'){?>
<?php  if(count($cart_update_response->ListTipForDriver)>0){ ?>
<tr class="ng-star-inserted other">
    <td>
    <div class="radiobox m-radio">
    <small class="text-muted">
    <input id="3" class="tip" name="tip" type="radio" <?php if($cart_update_response->TipForDriver == $tip->TipAmount && $check_flag!='1'){ echo "checked='checked'"; } ?> oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"> Other($) 
    <span class="checkmark"></span>
    </small>
    </div>
    
    <div class="tip-container ng-star-inserted" <?php if($check_flag!='1'){ ?>style="display:block;"<?php }else{?>style="display:none;"<?php } ?>><input myautofocus="" placeholder="00.00" type="text" class="tip-amount ng-pristine ng-valid ng-touched" value="<?php if($check_flag!='1'){echo number_format($tip->TipAmount,2);}?>"></div>
    
    </td>
    <td class="text-right"><small class="text-muted"></small></td>
</tr>
<?php } } ?>

</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table class="promo">
    <tbody>
        <tr>
            <td>
               <div class="col-md-12">
                   <div class="row">
                     <div class="form-group mtop15 promo-sec">
                         <?php if($cart_update_response->CouponCode != ''){
                            echo "<span class='promo-msg'><img src='../../assets/images/icon-couponapplied.png' class='coupon-applied'>Applied Promo ".$cart_update_response->CouponCode."<i class='fa fa-times coupon-close'></i></span>";
                            
                         } else { ?>
                        <input class="form-control input-promo coupon_code" placeholder="Apply promo code">
                        <button class="btn submit coupon">Apply</button>
                        <?php } ?>
                     </div>
                    </div>
               </div>
            </td>
        </tr>
    </tbody>
</table>
<table  class="total-container">
  <tbody ><tr  class="total-main">
<td  class="total total-left">Total</td>
<td  class="text-right total total-right"><?php echo $cart_update_response->TotalValueDisplay;?></td>
</tr>
</tbody>
</table>

</td>
</tr>

</tbody>
</table>


</div>
<?php if($routeParams['type'] == 'pickup' && $store_details->IsAcknowledgement && $cart_update_response->TotalValue >= $store_details->AcknowledgementLimit){ ?>
<div class="col-md-12">
    <div class="agree-pickup" limit="<?php echo $store_details->AcknowledgementLimit;?>" >
        <!--<div class="col-md-12">
          <input type="checkbox" name="ack" id="ack">
          <span class="ccd">For orders $<span class="ack-limit"><?php echo $store_details->AcknowledgementLimit;?></span> or more, I agree to present my ID and Credit Card used for the order at time of pickup.</span>
          <span class="checkmark"></span>
        </div>-->
     </div>
</div>
<?php } ?>
<div  class="btn_right buttons-container ">
  <a href="<?php echo $siteUrl;?>/cart"  class="btn btn-default back">Back</a>
<?php if($routeParams['type'] == 'pickup' && ($_SESSION['FirstName'] == '' || $_SESSION['LastName'] == '' || $profile['DOBDt'] == '')) { ?><!-- written by manikanta -->
    <a id="checkout_submit" class="btn btn-default novalue btn-checkout"  href="<?php echo $siteUrl;?>/checkout/pickup?m=pi"  class="btn btn-default back">Checkout</a><!-- written by manikanta -->
  <?php } else{ ?>  
    <?php if($routeParams['type'] == 'delivery' && ($cart_update_response->DeliveryAddress->AddressId == '0' || $cart_update_response->DeliveryAddress->AddressId == '' || $cart_update_response->DeliveryAddress->Remark != '')){ echo "<input type='hidden' id='fstate' value='1' >"; } else { echo "<input type='hidden' id='fstate' value='0' >";  } ?>
<input id="checkout_submit" type="submit" class="btn btn-default novalue btn-checkout <?php if($orderTypeId == 1){ echo 'pickup-time-check'; } ?> " value="Checkout" <?php if($routeParams['type'] == 'delivery' && ($cart_update_response->DeliveryAddress->AddressId == '0' || $cart_update_response->DeliveryAddress->AddressId == '' || $cart_update_response->DeliveryAddress->Remark != '' || $profile['DOBDt'] == '')){ echo "disabled='disabled'"; }elseif($routeParams['type'] == 'shipping' && ($cart_update_response->DeliveryAddress->AddressId == '0' || $cart_update_response->DeliveryAddress->AddressId == '' || $cart_update_response->DeliveryAddress->Remark != '' || $profile['DOBDt'] == '')){ echo "disabled='disabled'"; }?>>
<?php } ?>
<?php if($routeParams['type'] == 'delivery' && ($cart_update_response->DeliveryAddress->AddressId == '0' || $cart_update_response->DeliveryAddress->AddressId == '')){ ?>
  <br><span class="address-alert"> Address is required for delivery</span>
<?php } ?>

<?php if($routeParams['type'] == 'shipping' && ($cart_update_response->DeliveryAddress->AddressId == '0' || $cart_update_response->DeliveryAddress->AddressId == '')){ ?>
  <br><span class="address-alert"> Address is required for shipping</span>
<?php } ?>
<!-- written by manikanta start -->
<!-- <?php //if($routeParams['type'] == 'delivery' && ($profile['DOBDt'] == '' || $cart_update_response->Profile->ContactNo == '' || $cart_update_response->Profile->FirstName == '' || $cart_update_response->Profile->LastName == '' || $cart_update_response->Profile->UserEmailId == '')){ ?>
   <br><span class="address-alert">In order to place this order, please complete your profile</span>
 <?php //} ?>
<?php //if($routeParams['type'] == 'shipping' && ($profile['DOBDt'] == '' || $cart_update_response->Profile->ContactNo == '' || $cart_update_response->Profile->FirstName == '' || $cart_update_response->Profile->LastName == '' || $cart_update_response->Profile->UserEmailId == '')){ ?>
   <br><span class="address-alert">In order to place this order, please complete your profile</span>
 <?php //} ?> -->
 <!-- written by manikanta starting end-->
<?php 
if(($routeParams['type'] == 'delivery' || 'shipping') && (!strpos($cart_update_response->DeliveryAddress->Remark,'address')) && ($cart_update_response->DeliveryAddress->Remark != "Invalid address") && ($cart_update_response->DeliveryAddress->Remark != "We do not deliver to this address")){	
    echo '<br><span class="address-alert">'.$cart_update_response->DeliveryAddress->Remark.'</span>';        
}
// if($routeParams['type'] == 'delivery' || 'shipping' && !strpos($cart_update_response->DeliveryAddress->Remark,'address')){
//  echo '<br><span class="address-alert">'.$cart_update_response->DeliveryAddress->Remark.'</span>';
// } 
?>
</div>
</div>
<button  data-target="#gridSystemModal" data-toggle="modal" id="openCartReviewModal" hidden="">Review Cart</button>

<div  aria-labelledby="gridModalLabel" class="modal fade cart-review" data-backdrop="static" data-keyboard="false" id="gridSystemModal" role="dialog" tabindex="-1">
<div  class="modal-dialog" role="document">
<div  class="modal-content">
<div  class="modal-header">
<button  aria-label="Close" class="close" data-dismiss="modal" type="button">
<span  aria-hidden="true">×</span>
</button>
<h4  class="modal-title" id="gridModalLabel">Review Cart</h4>
</div>
<div  class="modal-body">
</div>
<div  class="modal-footer buttons-container">
<button  aria-label="Close" class="btn btn-primary" data-dismiss="modal" type="button">OK</button>
</div>
</div>
</div>
</div>

<button  data-target="#gridSystempriceModal" data-toggle="modal" id="openPriceModal" hidden="">Change in price</button>
<div  aria-labelledby="gridModalLabel" class="modal fade cart-review" data-backdrop="static" data-keyboard="false" id="gridSystempriceModal" role="dialog" tabindex="-1">
<div  class="modal-dialog" role="document">
<div  class="modal-content">
<div  class="modal-header">
<button  aria-label="Close" class="close" data-dismiss="modal" type="button">
<span  aria-hidden="true">×</span>
</button>
<h4  class="modal-title" id="gridModalLabel">Review Price</h4>
</div>
<div  class="modal-body">
<div  class="row">
<div  class="col-md-12 col-xs-3">
<h5 ></h5> 
</div>
</div>
</div> 
<div  class="modal-footer buttons-container">
<button  aria-label="Close" class="btn btn-primary" data-dismiss="modal" type="button">OK</button>
</div>
</div>
</div>
</div>
</form>

</div>
</div>
</div>
</div>

<?php loadView('footer', array('store_details' => $store_details, 'store_home_details'=>$store_home_details));?>
<style>
    .add-address-new {
    display: inline-block;
    float: right;
    margin-bottom: 15px;
}
    </style>
