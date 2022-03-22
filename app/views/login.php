<?php 
loadView('header', array('title' => 'Login', 'store_details' => $store_details));
?>
<div class="login-main"> 
    <div  class="container sresult">
      <div  class="row">
        
      </div>
    </div>
    <section class="padding_top">
    <div class="container">
    <div class="row">
    <app-signin _nghost-c21="">
    <div  class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <h4  class="font_size">
    <span  class="border">SIGN</span>
    <span > IN</span>
    </h4>
    <h6  class="padding_top">Hello, Welcome to your account</h6>
    <div id="login">
    <?php
    $passkey = 'G)w9:3qga>:U#v(';
    $method = 'aes128';
    ?>
    <div  class="form-group">
    <label  class="email" for="email">EMAIL ADDRESS <span class="mandatory">*</span>
    </label><input id="email" class="form-control" placeholder="Your email" required type="email" value="<?php echo openssl_decrypt($_COOKIE["userid"], $method, $passkey);?>"  >
  </div>
  <div  class="form-group">
  <label  class="password" for="pwd">PASSWORD <span class="mandatory" >*</span></label>
  <input id="pawd" class="form-control" placeholder="Password" required type="password" value="<?php echo openssl_decrypt($_COOKIE["userkey"], $method, $passkey);?>" >
  <input id="returnURL" class="form-control"  type="hidden" value="<?php echo urldecode($_GET['returnUrl']);?>">
 </div>
 <button id="login_submit" class="btn submit" type="submit">LOGIN NOW</button>
 <div  class="row">
 <div  class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
  <div  class="checkbox">
  <label>
  <input id="remember"  name="remember" type="checkbox">
  <span  class="checkmark"></span> Remember me!</label>
  </div>
</div>
<div  class="col-lg-6 col-md-6 col-sm-6 col-xs-12 forgot-pass">
  <a  class="color" data-target="#forgotModal" data-toggle="modal">Forgot your password?</a>
</div>
</div>
</div>
</div>
<div class="modal fade forgot-password-container" id="forgotModal" role="dialog" tabindex="-1">
<div  class="modal-dialog" role="document">
  <div  class="modal-content forgot-container">
 
  <div  class="modal-header forgot-header">
    <button  aria-label="Close" class="close" data-dismiss="modal" type="button">
      <span  aria-hidden="true">×</span>
    </button>
    <h4  class="modal-title text-center" id="forgotModalLabel">Forgot your Password?</h4>
  </div>
  <div  class="modal-body">
    <div id="rsec1">
    <p  class="text-center">Enter your email address below, and we'll send you instructions for resetting it.</p>
    <br>
    <div  class="form-group">
      <label  class="email" for="recipient-name">EMAIL ADDRESS <span class="mandatory" >*</span></label>
      <input  class="form-control"  name="recipient-name"  id="recipient-name" placeholder="Your email" required type="email">
    </div>
    </div>

    <div id="rsec2" style="display:none;">

        <p class="text-center"> Enter your token sent to your email address below, and new password.</p><br>
      <div class="form-group">
        <label class="email" for="recipient-name">Token <span class="mandatory">*</span></label>
        <input autocomplete="off" class="form-control border_radius ng-pristine ng-invalid ng-touched" name="ftoken" id="ftoken"  placeholder="Your Token" required="" type="text">
      </div>
      
      <div class="form-group icon-view">
        <label class="email" for="recipient-name">New Password <span class="mandatory">*</span></label>
        <input autocomplete="new-password" class="form-control border_radius ng-untouched ng-pristine ng-invalid" name="fnewpassword" id="fnewpassword" placeholder="Your Password" required="" type="password">
        <div class="eye"><i class="fa fa-eye-slash"></i></div>
      </div>
      
      <div class="form-group icon-view">
        <label class="email" for="recipient-name">Confirm Password <span class="mandatory">*</span></label>
        <input autocomplete="new-password" class="form-control border_radius ng-untouched ng-pristine ng-invalid" name="fconfirmpassword" id="fconfirmpassword" placeholder="Confirm password" required="" type="password">
        <div class="eye"><i class="fa fa-eye-slash"></i></div>
      </div>
    </div>
</div>
<input type="hidden" id="device_id" value="<?php echo $_SESSION['DEVICE_ID'];?>">
<input type="hidden" id="app_id" value="<?php echo $_SESSION['APP_ID'];?>">
<div  class="modal-footer forgot">
  <button  class="btn btn-default novalue" data-dismiss="modal" type="button">Cancel</button>
  <button  class="btn btn-default active reset_pwd" type="button">Reset Password</button>
</div>

</div>
</div>
</div>


<div  class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
  <h4  class="font_size">
  <span  class="border">CREATE</span>
  <span >A NEW ACCOUNT</span>
 </h4>
 <div  id="signup" class="create-accnt ng-untouched ng-pristine ng-invalid">
  <div  class="form-group">
  <label  class="email" for="email">EMAIL ADDRESS <span class="mandatory" >*</span></label>
  <input  autocomplete="off" class="form-control" placeholder="Your email" id="s_email" type="email" required>
</div>
<div  class="form-group">
  <label  class="password" for="pwd">PASSWORD <span class="mandatory" >*</span></label>
  <input  autocomplete="new-password" class="form-control" placeholder="Password" id="s_pawd" type="password" required>
</div>
<button id="signup_submit"  class="btn submit" type="submit">SIGN UP</button>
</div>
<h4  class="font_size">
  <span  class="border">SIGN</span>
  <span > UP TODAY AND YOU'LL BE ABLE TO </span>
</h4>
<h6  class="color_text">Speed your way through the checkout</h6>
<h6  class="color_text">Track your orders easily</h6>
<h6  class="color_text">Keep a record of all purchases</h6>
</div>
</app-signup>
</div>
</div>
    </section>
    </div>

    <?php loadView('footer', array('store_details' => $store_details, 'store_home_details'=>$store_home_details));?>

    <style>
      .mandatory{color: #a82c2e;}
      .form-group label{font-size: 14.5px;}
    </style>
