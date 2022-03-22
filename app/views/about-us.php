<?php
$title = ucfirst($title);
loadView('header', array('title' => $title, 'store_details' => $store_details));

if(!isset($store_details)) {
$store_details = json_decode(cachedData('StoreHome', []));
}
?>

<div  class="container sresult">
        <div  class="row">
        <div  class="Search_div col-md-12 col-sm-12 col-lg-12 col-xs-12">
        <h4>About Us</h4>
        <ol class="breadcrumb">
        <li class="breadcrumb-item">
        <a href="<?php echo $siteUrl;?>">Home</a>
       </li>
       <li  class="breadcrumb-item">
        About Us
    </li>
</ol>
</div>
</div>
</div>
<div class="recipes-main">
<div  class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
  <div class="container">
    <div class="m-bottom">
        <p>Waverly Liquors has been in business since 1990.  We have a large selection of wines and spirits yet maintain discount warehouse like pricing.  We are a family owned business and pride ourselves on treating our customers with respect and contributing positively to the community around us.</p>
    </div>
</div>

</div>
</div>
<style>
  .recipes-main .page-navigation{width:100% !important; text-align:center;}
</style>
<?php loadView('footer', array('store_details' => $store_details, 'store_home_details'=>$store_home_details));?>
