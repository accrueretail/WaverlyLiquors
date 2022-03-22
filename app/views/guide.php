<?php
loadView('header', array('title' => $title, 'store_details' => $store_details));
?>

<div class="container guide">
    <div class="margin-top">
        <h1 class="tiles">Guide And Advice</h1>
        <div class="aboutus-content">
            <div class="aboutus-left-div-img uc">
                <img src="<?php echo $siteUrl;?>/assets/images/underconstruction.png">
            </div>
        </div>
    </div>
</div>

<?php
loadView('footer', array('store_details' => $store_details, 'store_home_details'=>$store_home_details));
?>
