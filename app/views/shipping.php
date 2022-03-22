<?php
loadView('header', array('title' => $title, 'store_details' => $store_details));
?>
<div class="common-margin-top"><div class="page-margin"><div class="container"><div class="row"><div class="col-md-12 col-sm-12 col-lg-12 col-xs-12"><div class="common-breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="#/store">Home</a></li><li class="breadcrumb-item">Shipping</li></ol></div></div></div><div class="privacy-content"><h4>Shipping </h4><img src="<?php echo $siteUrl;?>/assets/images/img-shipping.png"><p>We cannot ship to the following states: Alabama, Arkansas, Arizona, Colorado, Delaware, Georgia, Hawaii, Iowa, Illinois, Indiana, Kansas, Kentucky, Louisiana, Massachusetts, Maryland, Maine, Michigan, Minnesota, Mississippi, Montana, North Carolina, North Dakota, New Hampshire, New York, Ohio, Oklahoma, Pennsylvania, Puerto Rico, Rhode Island, South Carolina, South Dakota, Tennessee, Texas, Utah, Virginia, Vermont, Washington, Wisconsin.</p><h5 style="margin:30px 0;">The ID and adult signature is required to receive the package.</h5><h5 style="margin:0px 0 0 0;">Estimated Delivery Time</h5><p>Please note, with extreme heat during the summer months and extreme cold during the winter months, we may hold shipments to your area here in our warehouse. If you feel this may be a problem because of a time sensitive package, please contact us to discuss other options.</p><p>Please note, due to increased volume, delivery orders can take up to 7-10 days for processing. Pick up orders are generally ready in 1-2. Faster shipping options may be available. Please contact us for more information. All packages are packed in our Styrofoam or pulp containers to ensure proper delivery. We do everything possible on our end to protect our shipments from temperature-related damage. If you are concerned about the weather in your area, you may request a specific shipping date or you may choose a faster shipping method. You will receive an email containing tracking information once your order is boxed and ready for shipment.</p><h5 style="margin:20px 0 0 0;">Returns</h5><p style="margin-bottom: 50px;">We are committed to 110% customer satisfaction! If there is any problem with your order, we want to hear about it. Please note, any problems with the receipt of your package must be called in to us within 30 days of the delivery date! If you suspect the bottle is bad, please just put the contents in the bottle. We can't take back any empty bottles. If you find any errors regarding type of product, please call us right away. We will arrange to have the package picked up and returned to us right away for inspection. Once the package is returned to us, we will inspect the contents and then send out a replacement package to you. For this reason, it is vital that you let us know of any error immediately to ensure the fastest delivery of your new shipment. If you wish to return your product for any other reason you may do so. Please re-pack the product and contact us. Please include a copy of the original sales receipt with the package. Please note: All returns are subject to a 25% restocking fee.</p></div></div></div></div>

<?php loadView('footer', array('store_details' => $store_details, 'store_home_details'=>$store_home_details));?>