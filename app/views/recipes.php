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
        <h4>Recipes</h4>
        <ol class="breadcrumb">
        <li class="breadcrumb-item">
        <a href="<?php echo $siteUrl;?>">Home</a>
       </li>
       <li  class="breadcrumb-item">
        Recipes
    </li>
</ol>
</div>
</div>
</div>

<?php
//print_r($recipes);
$total_products = $recipes['RecipeCount'];

$no_of_pages = ceil($total_products/$pageSize);
$end = $pageNumber*$pageSize;
$start = $end-$pageSize+1;
?>   
<div class="recipes-main">
<div  class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
  <div class="container">
    <div  class="page-navigation">
    <ul class="pagination">
    <li class="page-item <?php if($pageNumber <= 1){?>disabled<?php } ?>">
        <a aria-label="First" class="page-link prev_next" href="<?php echo modify_url(array('pageNumber'=>1));?>" tabindex="-1" page="1">
          <span aria-hidden="true">««</span>
        </a>
      </li>
      <li class="page-item <?php if($pageNumber <= 1){?>disabled<?php } ?>">
        <a aria-label="Previous" class="page-link prev_next" href="<?php echo modify_url(array('pageNumber'=>$pageNumber-1));?>" tabindex="-1" page="<?php echo $pageNumber-1; ?>">
          <span aria-hidden="true">«</span>
        </a>
      </li>
      <?php ?>
      <li class="page-item <?php if($pageNumber == 1){echo 'active';}?>">
        <a class="page-link" href="<?php echo modify_url(array('pageNumber'=>1));?>"> 1 
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
        <a class="page-link <?php echo $i;?>" href="<?php echo modify_url(array('pageNumber'=>$i));?>" > <?php echo $i;?> </a>
      </li>
      <?php }} ?>
      <?php for($i=$pageNumber; $i<=$pageNumber+2 && $i<$no_of_pages;$i++){ if($i>1){?>
        <li class="page-item <?php if($pageNumber == $i){echo 'active';}?>">
        <a class="page-link" href="<?php echo modify_url(array('pageNumber'=>$i));?>"> <?php echo $i;?> </a>
      </li>
      <?php }} ?>

      <?php if($pageNumber<$no_of_pages-3){ ?>
      <li class="page-item disabled">
        <a class="page-link">...</a>
      </li>
      <?php } ?>
      <li class="page-item <?php if($pageNumber == $no_of_pages){echo 'active';}?>">
        <a class="page-link" href="<?php echo modify_url(array('pageNumber'=>$no_of_pages));?>"> <?php echo $no_of_pages;?> </a>
      </li>
      <li class="page-item  <?php if($pageNumber >= $no_of_pages){?>disabled<?php } ?>">
        <a aria-label="Next" class="page-link prev_next" href="<?php echo modify_url(array('pageNumber'=>$pageNumber+1));?>" page="<?php echo $pageNumber+1; ?>">
          <span aria-hidden="true">»</span>
        </a>
      </li>
      <li class="page-item <?php if($pageNumber >= $no_of_pages){?>disabled<?php } ?>">
        <a aria-label="Last" class="page-link prev_next" href="<?php echo modify_url(array('pageNumber'=>$no_of_pages));?>"  page="<?php echo $no_of_pages; ?>">
          <span aria-hidden="true">»»</span>
        </a>
      </li>
   </ul>
    </div>  
    <?php foreach($recipes['ListRecipe'] as $recipe){?>
<div  class="recipes col-lg-3 col-md-3 col-sm-3 col-xs-12 item_img animated fadeInLeft">
    <div  class="row">
    <div  class="thumbnail">
      <a href="<?php echo $siteUrl; ?>/recipe-details/<?php echo $recipe['RecipeId']; ?>">
	<img alt="<?php echo $recipe['Title'];?>"  src="<?php echo $recipe['ThumbNailImage'];?>">
        <div  class="caption">
          <h6  class="text_center"><?php echo $recipe['Title'];?></h6>
        </div>
      </a>
    </div>
  </div>
</div>
    <?php } ?>



<div  class="page-navigation">
<ul class="pagination">
    <li class="page-item <?php if($pageNumber <= 1){?>disabled<?php } ?>">
        <a aria-label="First" class="page-link prev_next" href="<?php echo modify_url(array('pageNumber'=>1));?>" tabindex="-1" page="1">
          <span aria-hidden="true">««</span>
        </a>
      </li>
      <li class="page-item <?php if($pageNumber <= 1){?>disabled<?php } ?>">
        <a aria-label="Previous" class="page-link prev_next" href="<?php echo modify_url(array('pageNumber'=>$pageNumber-1));?>" tabindex="-1" page="<?php echo $pageNumber-1; ?>">
          <span aria-hidden="true">«</span>
        </a>
      </li>
      <?php ?>
      <li class="page-item <?php if($pageNumber == 1){echo 'active';}?>">
        <a class="page-link" href="<?php echo modify_url(array('pageNumber'=>1));?>"> 1 
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
        <a class="page-link <?php echo $i;?>" href="<?php echo modify_url(array('pageNumber'=>$i));?>" > <?php echo $i;?> </a>
      </li>
      <?php }} ?>
      <?php for($i=$pageNumber; $i<=$pageNumber+2 && $i<$no_of_pages;$i++){ if($i>1){?>
        <li class="page-item <?php if($pageNumber == $i){echo 'active';}?>">
        <a class="page-link" href="<?php echo modify_url(array('pageNumber'=>$i));?>"> <?php echo $i;?> </a>
      </li>
      <?php }} ?>

      <?php if($pageNumber<$no_of_pages-3){ ?>
      <li class="page-item disabled">
        <a class="page-link">...</a>
      </li>
      <?php } ?>
      <li class="page-item <?php if($pageNumber == $no_of_pages){echo 'active';}?>">
        <a class="page-link" href="<?php echo modify_url(array('pageNumber'=>$no_of_pages));?>"> <?php echo $no_of_pages;?> </a>
      </li>
      <li class="page-item  <?php if($pageNumber >= $no_of_pages){?>disabled<?php } ?>">
        <a aria-label="Next" class="page-link prev_next" href="<?php echo modify_url(array('pageNumber'=>$pageNumber+1));?>" page="<?php echo $pageNumber+1; ?>">
          <span aria-hidden="true">»</span>
        </a>
      </li>
      <li class="page-item <?php if($pageNumber >= $no_of_pages){?>disabled<?php } ?>">
        <a aria-label="Last" class="page-link prev_next" href="<?php echo modify_url(array('pageNumber'=>$no_of_pages));?>"  page="<?php echo $no_of_pages; ?>">
          <span aria-hidden="true">»»</span>
        </a>
      </li>
   </ul>
  </div> 
</div>

</div>
</div>
<style>
  .recipes-main .page-navigation{width:100% !important; text-align:center;}
</style>
<?php loadView('footer', array('store_details' => $store_details, 'store_home_details'=>$store_home_details));?>
