<?php 
//print_r($recipe);
$title = $recipe['RecipeDetail']['Title'];
loadView('header', array('title' => $title, 'store_details' => $store_details));
?>


<div  class="container sresult">
        <div  class="row">
        <div  class="Search_div col-md-12 col-sm-12 col-lg-12 col-xs-12">
        <h4>Recipe Details</h4>
        <ol class="breadcrumb">
        <li class="breadcrumb-item">
        <a href="<?php echo $siteUrl;?>">Home</a>
       </li>
       <li  class="breadcrumb-item">
        <a href="<?php echo $siteUrl;?>/recipes">Recipes</a>
    </li>
       <li  class="breadcrumb-item">
        <a>Recipe Details</a>
    </li>
</ol>
</div>
</div>
</div>

   
<div class="product-detail-main">

<section  class="content">
<div  class="container">
<div  class="row">
<div  class="details_img col-md-8 col-sm-8 col-lg-8 col-xs-12 animated fadeInLeft">
<img alt="<?php echo $recipe['RecipeDetail']['Title'];?>"  class="img-responsive" src="<?php echo $recipe['RecipeDetail']['DetailImage'];?>">
</div>

<div  class="details_content col-md-4 col-sm-4 col-lg-4 col-xs-12 animated fadeInRight">
    <h1 class="recipe_name"><?php echo $recipe['RecipeDetail']['Title'];?></h1>
    <ul>
      <h4 class="ingredients">Ingredients</h4>
      <div class="IngredientText recipe-ingredients">
      <?php echo $recipe['RecipeDetail']['IngredientText'];?>
      </div>
    </ul>
</div>
<div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
  <div class="Searchrelated_div no-b-border">
    <h5>Instructions</h5>
  </div>
  <div class="instruction_text">
  <?php echo $recipe['RecipeDetail']['InstructionText'];?>
  </div><br>
</div>
</div>
</section>

</div>

<?php loadView('footer', array('store_details' => $store_details, 'store_home_details'=>$store_home_details));?>
