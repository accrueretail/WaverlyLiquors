<?php
loadView('header', array('title' => $title, 'store_details' => $store_details));
?>

<div class="about-us">
    <div class="parallax">
        <div class="container">
            <div class="Searchrelated_div col-md-12 col-sm-12 col-lg-12 col-xs-12">
                <h4>Contact Us</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $siteUrl;?>">Home</a></li>
                    <li class="breadcrumb-item active"><a>Contact Us</a></li>
                </ol>
            </div><hr>
        </div>
    </div>
</div>
<div class="container">
    <form class="ng-pristine ng-invalid ng-touched" method="POST" action="<?php echo $siteUrl;?>/contact-us">
        <div class="row"><div class="contact-section">
            <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 contactform">
                <img class="mb20" src="<?php echo $siteUrl;?>/assets/images/logo.png" width="180">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-uppercase">Name <span>*</span></label>
                            <input class="form-control ng-pristine ng-invalid ng-touched" name="name" type="text" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-uppercase">E-Mail <span>*</span></label>
                            <input class="form-control ng-pristine ng-invalid ng-touched" name="email" type="email" required>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-uppercase">Phone <span>*</span></label>
                            <input appphonemask="" class="form-control ng-pristine ng-invalid ng-touched" name="phone" id="phone-number" maxlength="14" type="text"  required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-uppercase">Subject <span>*</span></label>
                            <input class="form-control ng-pristine ng-valid ng-touched" name="subject" type="textarea" value="Website - Contact Us" required>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group"><br>
                        <label class="text-uppercase">MESSAGE <span>*</span></label>
                        <textarea class="form-control no-resize contact-textarea ng-pristine ng-valid ng-touched" name="message" spellcheck="false"  required></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button class="btn btn-brand contact" type="submit">Send</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6"><div class="row"><div class="contact-address-section"><div class="contact-map"><!----><iframe allowfullscreen="" frameborder="0" height="100%" style="border:0" width="100%" src="https://maps.google.com/maps?q=<?php echo $store_details->Latitude;?>,<?php echo $store_details->Longitude;?>&amp;hl=es;z=14&amp;output=embed"></iframe></div></div></div></div></div><div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 hidden"><div class="row"><div class="contact-map"><iframe allowfullscreen="" frameborder="0" height="250" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d30450.055707493928!2d78.3587207751071!3d17.44741093471787!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bcb93ddadd565cd%3A0xb0ea84e8a712b1d3!2sTechmatic+Systems!5e0!3m2!1sen!2sin!4v1551765856885" style="border:0" width="100%"></iframe></div></div></div></div></form></div>

<?php
loadView('footer', array('store_details' => $store_details, 'store_home_details'=>$store_home_details));
?>
