<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
<?php $siteUrl =  $_SESSION['siteUrl'];?>
<footer >
  <div  class="container">
  <div  class="footer-component-main-alt">
    <div  class="footer-component-main-location footer-component-sub item_img footer_image">
      <div  class="margin_left">
        <address  class="storelocation">
          <h4  class="f-h4"><?php echo $store_details->StoreName;?></h4>
          <div  class="col-xs-12">
            <div  class="row">
              <div  class="f-image">
                <i  class="fa fa-map-marker"></i>
              </div>
              <div  class="address-captions">
                <a  target="_blank" href="https://www.google.com/maps/place/<?php echo $store_details->Latitude;?>,<?php echo $store_details->Longitude;?>"> 
                  <?php echo $store_details->Address1;?> <?php echo $store_details->Address2;?>
                  <span > <?php echo $store_details->City;?>, <?php echo $store_details->State;?> <?php echo $store_details->Zip;?> </span>
                </a>
              </div>
            </div>
          </div>
          <div  class="col-xs-12">
            <div  class="row">
              <div  class="f-image">
                <i  class="fa fa-phone"></i>
              </div><div  class="address-captions">
                <span >
                  <a  href="tel:<?php echo $store_details->ContactNo;?>"><?php echo $store_details->ContactNo;?></a>
                </span>
              </div>
            </div>
          </div>
          <div  class="col-xs-12">
            <div  class="row">
              <div  class="f-image">
                <i class="fa fa-envelope" aria-hidden="true"></i>
              </div>
              <div  class="address-captions">
                <span >
                  <a  href="mailto:<?php echo $store_details->StoreEmail;?>"><?php echo $store_details->StoreEmail;?></a>
                </span>
              </div>
            </div>
          </div>

          <div  class="col-xs-12">
            <div class="row">
            <h4  class="font_size Subscribe">Payment options</h4>
                    <div  class="cards">
                      <ul  class="pull-left"><li >
                        <img  alt="Discover" border="0" src="<?php echo $siteUrl;?>/assets/images/payment-discover.png" title="Discover"></li>
                        <li >
                          <img  alt="Master" border="0" src="<?php echo $siteUrl;?>/assets/images/payment-mastercard.png" title="Master"></li>
                          <li >
                            <img  alt="Visa" border="0" src="<?php echo $siteUrl;?>/assets/images/payment-visa.png" title="Visa">
                          </li>
                            <li >
                              <img  alt="Amex" border="0" src="<?php echo $siteUrl;?>/assets/images/payment-americanExpress.png" title="Amex">
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>




        </address>
      </div>
    </div>
    <div  class="footer-component-main-about footer-component-sub item_img aboutus">
      <h4  class="font_size">About</h4>
      <ul  class="list-unstyled clear-margins">
        <li >
          <a  href="<?php echo $siteUrl;?>/about-us">About US</a>
        </li>
        <li >
          <a  href="<?php echo $siteUrl;?>/privacy-policy">Privacy Policy</a>
        </li>
        <li >
          <a  href="<?php echo $siteUrl;?>/terms-conditions">T&amp;C</a>
        </li>
        <!-- <li >
          <a  href="<?php echo $siteUrl;?>/shipping">Shipping</a>
        </li> -->
        <li >
          <a  href="<?php echo $siteUrl;?>/contact-us">Contact Us</a>
        </li>
      </ul>
    </div>

 <?php
    $store_info = json_decode($store_home_details);
?>
<div  class="footer-component-main-hours footer-component-sub item_img hours">
      <h4  class="font_size">Store Hours</h4>
      <ul  class="list-unstyled clear-margins">
      <?php foreach($store_info->GetStoredetails->ListStoreTime as $store_time){?>
      <li><span ><?php echo $store_time->DayID;?></span> <?php echo $store_time->StoreOpenTime;?> - <?php echo $store_time->StoreCloseTime;?> </li>
      <?php } ?>
      </ul>
      </div> 

<?php
      if($store_info->GetStoredetails->IsDelivery){ ?>
      <div  class="footer-component-main-hours footer-component-sub item_img hours">
      <h4  class="font_size">Delivery Hours</h4>
      <ul  class="list-unstyled clear-margins">
      <?php foreach($store_info->GetStoredetails->ListStoreTimeDelivery as $store_time){?>
      <li><span ><?php echo $store_time->DayID;?></span> <?php echo $store_time->StoreOpenTime;?> - <?php echo $store_time->StoreCloseTime;?> </li>
      <?php } ?>
      </ul>
      </div>
      <?php } ?>
      
<?php
      if($store_info->GetStoredetails->IsPickUp == 1){ ?>      
      <div  class="footer-component-main-payment footer-component-sub item_img payments">
        <h4  class="font_size">Pickup Hours</h4>
        <ul  class="list-unstyled clear-margins">
      <?php foreach($store_info->GetStoredetails->ListPickUpStoreTime as $store_time){?>
      <li><span ><?php echo $store_time->DayID;?></span> <?php echo $store_time->StoreOpenTime;?> - <?php echo $store_time->StoreCloseTime;?> </li>
      <?php } ?>
      </ul>
      </div>
      <?php } ?>
                    </div>
                  </div>
                  <div  class="pull-right hidden">
                    <a  class="scrollTop" href="" id="return-to-top"><i >
                      <img  height="50" src="<?php echo $siteUrl;?>/assets/images/goto-top-png.svg" width="50">
                    </i>
                  </a>
                </div>
</footer>

<div  class="footer-bottom">
  <div  class="container">
    <div  class="row">
      <div  class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div  class="copyright">
          <span  class="allrights"> 2018-2021. All rights reserved</span>
        </div>
      </div>
      <div  class="col-md-4 col-sm-4 col-lg-4 col-xs-6">
        <ul  class="social-network social-circle"></ul>
      </div>
      <div  class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
        <div  class="design text_center">
          <span >Powered By </span>
          <a  href="https://accrueretail.com/" target="_blank">
            <img  alt="accrueretail" class="first_imge" src="<?php echo $siteUrl;?>/assets/images/powered-by.png"></a>
</div>
</div>
</div>
</div>
</div>


<?php
    if($_currentRoute == 'myaccount/profile-edit'){ 
      if($_GET['returnUrl'] != '' || $_GET['returnURL'] != '') { $toast_msg = "Please complete your profile.";}
    }
    if (strpos($_currentRoute, 'checkout/delivery/t') !== false) {
      $toast_msg = "Tip Applied.";
    }
    if (strpos($_currentRoute, 'checkout/pickup') !== false && $_GET['m'] == 'pi') {
      $toast_msg = "Please complete your profile.";
      $toast_flag = "E";
    }
    if (strpos($_currentRoute, 'login') !== false) {
      if($_GET['returnUrl'] == 's' || $_GET['returnURL'] == 's') { $toast_msg = "Password Reset Successfully!";}
      if($_GET['returnUrl'] == 'e' || $_GET['returnURL'] == 'e') { $toast_msg = "Your Password key expired Please reset password again";}
    }
    if($_GET['s'] == '1'){
      $toast_msg = "Request added succesfully.";
    }
    if($_GET['ps'] == 'E'){
      $toast_flag = 'E';
      $toast_msg = "We are unable to process your card at this time. Please contact our customer service.";
    }
?>
<!-- toast message -->
<div id="toast-container" class="toast-top-right toast-container">
  <div toast-component="" class="toast <?php if($toast_flag == 'E'){ echo "toast-error";}else if($toast_msg!=''){ echo "toast-success"; }?>" <?php if($toast_msg!=''){?>style="display:block;"<?php }else{?>style="display:none;"<?php } ?>>
    <div  class="toast-message">
   <?php if($toast_msg!=''){ echo $toast_msg;}?>
    </div>
  </div>
</div>



<!-- <link href="<?php echo $siteUrl;?>/css/model-popup.min.css" rel="stylesheet"> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
    $(document).on('click','.pickup-time-check',function(){
      event.preventDefault();
 $.get(siteURL + "/api/storetime/confirm").done(function (data) {
 
  if(data == "NO"){
    
    swal({
  
  text: "Your order is being placed outside of store pickup hours.  Please wait for email notification that your order is ready for pickup.",
  
  buttons: true,
 
})
.then((willDelete) => {
  if (willDelete) {
    $('form').submit(); 
  } else {
   
  }
});

  }else{
      $('form').submit();

  }
        });


    });
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<?php if($_currentRoute == 'myaccount/profile-edit'){ ?>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    var d = new Date();
    var pastYear = d.getFullYear() - 21;
    d.setFullYear(pastYear);
    dmax = (((d.getMonth() > 8) ? (d.getMonth() + 1) : ('0' + (d.getMonth() + 1))) + '/' + ((d.getDate() > 9) ? d.getDate() : ('0' + d.getDate())) + '/' + d.getFullYear());


    $( ".datepicker" ).datepicker({
      beforeShowDay: function(dt) {
	      dt_s = (((dt.getMonth() > 8) ? (dt.getMonth() + 1) : ('0' + (dt.getMonth() + 1))) + '/' + ((dt.getDate() > 9) ? dt.getDate() : ('0' + dt.getDate())) + '/' + dt.getFullYear());
	      //console.log(dmax+'===='+dt_s);
	      return [true, dmax == dt_s ? "date-hilight" : ""];
      },
      firstDay: 1,
      showOn: "button",
      buttonImage: "../date.png",
      buttonImageOnly: true,
      buttonText: '',
      changeMonth: true,
      changeYear: true,
      yearRange: '1900:-21',
      maxDate: d
    });
  } );
  </script>
  <style>
  .calendar-group img {
    width: 50px;
  }
  </style>
<?php } ?>
<script src="<?php echo $siteUrl;?>/js/jquery.validate.min.js"></script>
<script src="<?php echo $siteUrl;?>/js/script.js"></script>
</body>
</html>
