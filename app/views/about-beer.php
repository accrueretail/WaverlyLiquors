<?php
loadView('header', array('title' => $title, 'store_details' => $store_details));
?>

<div class="container">
<div class="margin-top">
<h1 class="tiles">Beer</h1>
<h2 class="tiles">A World-Class Beer Selection</h2>
<p>Whether you’re relaxing at the end of the day or getting together with friends and family for a barbecue or a game, we have an unrivalled assortment of beers, from the most popular domestic brands to unique imports to a serious selection of popular and hard-to-find craft beers. All at very competitive prices. We also have an expert staff on hand to back up our huge selection, so you can learn more about pale ales, stouts, lagers, and pilsners than you ever imagined.</p>

<h2 class="tiles">Come on in to the Beer Cave</h3>
<p>Bring your shopping cart right into our 30-door Beer Cave, a beer aficionado’s dream! There’s nothing else quite like it in the region. Brimming with ice-cold domestic, imported, and craft brews our cooler stretches almost the length of a football field – that’s a tremendous variety of beer by the can, bottle or growler! And you’ll find additional craft beers and microbrews in our store aisles – just steps away from the Beer Cave. It all adds up to a selection and value you won’t find anywhere else.</p>

<p>Our beer specialists are always on the lookout for new and interesting brews, so we proudly add new, hard&shy;to&shy;find beers every week. You’ll want to check in with us often for their latest discoveries!</p>
</div></div>

<?php
loadView('footer', array('store_details' => $store_details, 'store_home_details'=>$store_home_details));
?>
