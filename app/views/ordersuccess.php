<?php 
$title = $siteName;
loadView('header', array('title' => $title, 'store_details' => $store_details));
?>

<?php
/*print_r($_SESSION);
echo "<hr><br>";
print_r($payment_verification_response);
echo "<hr><br>";
print_r(json_encode($data));
echo "<hr><br>";
print_r($payment_response);*/
?>
<?php if($payment_response->SuccessMessage != ''){ ?>
<div class="success-failed-order-section">
    <div class="success-order-section ng-star-inserted">
    
        <h2>Congratulations!</h2>
        <h4>Order successfully placed</h4>
    </div>
    
    <div class="order-details-section ng-star-inserted">
        <h4>Your Order ID</h4>
        <h2><?php echo $payment_response->OrderNo;?></h2>
    </div>
    <?php $pay_note = json_decode($payment_response->CardResCode);?>
    <div class="ng-star-inserted">
        <h4>Auth Amount : <?php echo $pay_note->AuthAmount;?></h4>
        <h4>Auth Code: <?php echo $pay_note->AuthCode;?></h4>
        <h4>Card Type: <?php echo $pay_note->CardType;?></h4>
        <h4>Cardholder Name: <?php echo $pay_note->CardholderName;?></h4>
        <h4>DisplayMessage: <?php echo $pay_note->DisplayMessage;?></h4>
        <h4>Status: <?php echo $pay_note->Status;?></h4>
        <h4>Trans Post Time: <?php echo $pay_note->TransPostTime;?></h4>
        <h4>AcqRef Data: <?php echo $pay_note->AcqRefData;?></h4>
    </div>

    <a href="<?php echo $siteUrl;?>"><button class="btn continue-shop">Continue Shopping</button></a>
</div>
<?php }else{ ?>
<div class="success-failed-order-section">
<div class="success-order-section"><h4><?php echo $payment_response->ErrorMessage;?></h4></div>
</div>
<?php } ?>
<?php loadView('footer', array('store_details' => $store_details, 'store_home_details'=>$store_home_details));?>
