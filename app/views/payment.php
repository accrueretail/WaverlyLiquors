<?php 
$title = $siteName;
loadView('header', array('title' => $title, 'store_details' => $store_details));

//$cart_details = 
?>

<?php if($pay_type == 'Online'){?>

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
    
<div class="checkout-main">
<div class="container pbottom30">
<div class="row">
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
        <img  class="prod-img img-responsive" src="<?php echo $cart_item->ProductImage;?>">
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
<table  class="summary-container">
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
<tr  class="">
<td  width="25px">
</td>
<td >
<h5 ><?php if($cart_update_response->TotalSavings>0){?><i class="savings_icon fa fa-plus-circle"></i> <?php } ?>Savings</h5>
</td>
<td  class="text-right">
  <h4 ><?php echo $cart_update_response->TotalSavingsDisplay;?></h4>
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

<?php //if($routeParams['type'] != 'pickup'){ ?>
<?php foreach($cart_update_response->ListCharge as $charge){?>
<tr  class="">
<td  width="25px">
</td>
<td >
<h5 ><?php echo $charge->ChargeTitle;?></h5>
</td>
<td  class="text-right">
  <h4 ><?php echo $charge->ChargeAmountDisplay;?></h4>
</td>
</tr>
<?php } //} ?>
<tr  class="">
<td >
</td>
<!--<td >
<h5 >Deposit</h5>
</td>
<td  class="text-right">
<h4 ><?php //echo $cart_update_response->Deposit;?></h4>
</td>-->
</tr>
<!--<tr  class="">
<td  class="tipdown " colspan="3">
<table  class="exapnded-table">
<tbody >
</tbody>
</table>
</td>
</tr>-->
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
</div>
</div>

<div clas="col-lg-7 col-md-7 col-sm-7 col-xs-12">

<?php
    if($payment_initial_response->Data->IsHostedCheckoutIFrameLive){ 
        $pay_url = 'https://hc.mercurypay.com/';
     } else{
        $pay_url = 'https://hc.mercurycert.net/';
     }
     //$pay_url = 'https://hc.mercurypay.com/';
?>
<div class="frame_loader" style="display:none;"></div>
<iframe onload="frameLoad()" frameborder="0" height="100%" id="paymentiframe" width="100%" src="<?php echo $pay_url; ?>/CheckoutIFrame.aspx?ReturnMethod=post&amp;pid=<?php echo  $payment_initial_response->Data->PaymentId;?>"></iframe>
</div>
<style>
.frame_loader {
  border: 16px solid #f3f3f3; /* Light grey */
  border-top: 16px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 120px;
  height: 120px;
  animation: spin 2s linear infinite;
  display: inline-block;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
<script>
var check_re_flag = 0;
function frameLoad(){
    var data={
        "MerchantID": "",
        "Password": "",
        "StoreId":<?php echo $storeId;?>,
        "PaymentId": `<?php echo $payment_initial_response->Data->PaymentId;?>`
    }

    $.post("<?php echo API_URL;?>/api/WPHostedCheckout/VerifyPayment", data).done(function (response) {
        
        //console.log(response);
        if(response.Data.DisplayMessage=="We are unable to process your card at this time. Please contact our customer service."){
            $(".frame_loader").show();
           //toast_message(res.Data.DisplayMessage, "E");
           window.location.href = "<?php echo $siteUrl;?>/cart?ps=E";
         }else if(response.Data.DisplayMessage==="Your transaction has been approved."){
             $(".frame_loader").show();
           //this.commonService.hostedOrderData=res;
           // this.toastr.success(res.Data.DisplayMessage);
           //this.placeOrder();
           // this.router.navigate(['/ordersucess'])
	  if(check_re_flag == 0){window.location.href = "<?php echo $siteUrl;?>/ordersuccess/<?php echo $payment_initial_response->Data->PaymentId;?>/<?php echo $_SESSION['CartId'];?>";
check_re_flag = 1;	 }
         }else if(response.Data.DisplayMessage != null){
	    $(".frame_loader").show();
            //toast_message(res.Data.DisplayMessage, "E");
	    window.location.href = "<?php echo $siteUrl;?>/cart?ps=E";
	}
    });
   
}
</script>

</div>




</div>
</div>
</div>
</div>
<?php }elseif($pay_type == 'Offline'){ ?>
    <div class="success-failed-order-section">
        <div class="success-order-section ng-star-inserted">
        
            <h2>Congratulations!</h2>
            <h4>Order successfully placed</h4>
        </div>
        
        <div class="order-details-section ng-star-inserted">
            <h4>Your Order ID</h4>
            <h2><?php echo $payment_response->OrderNo;?></h2>
        </div>
        <a href="<?php echo $siteUrl;?>"><button class="btn continue-shop">Continue Shopping</button></a>
    </div>
<?php } ?>

<?php loadView('footer', array('store_details' => $store_details, 'store_home_details'=>$store_home_details));?>
