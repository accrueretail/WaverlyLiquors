<?php
loadView('header', array('title' => $title, 'store_details' => $store_details));
?>

<div class="container">
    <div class="margin-top">
        <h1 class="tiles">Spirits</h1>
        <h2 class="tiles">We Have Every Spirit Under The Sun</h2>
        <p>With us, you’ll find almost every spirit and premium cocktail imaginable, for high-end splurges and budget-conscious shoppers and everyone in between. Single barrel bourbon, single malt scotch, domestic and imported vodka, rum, gin, cordials, cognac, brandy and so much more. What’s more you’ll find all the mixes and ingredients you’ll need to create your favorite cocktail. Or if you’d prefer, choose from our large selection of ready-to-drink cocktails – just pour and enjoy! Need a cocktail shaker, bartender’s tool kit or other bar supplies? We have those too. So come on in, browse our wide aisles and feel good knowing that you’re experiencing the best selection and prices around.</p>
        
        <h3 class="tiles">Microdistilleries are all the rage</h3>
        <p>And don’t forget to check out our ever-expanding collection of hand-crafted spirits from the new wave of microdistilleries. Primarily made in the USA, these small-batch distillers are creating some of the best spirits the world has to offer. From white whiskies to world-class bourbons to unique rums and vodkas these craft spirits are growing rapidly in popularity. Come on in and browse… but come back often as we’re introducing new products all the time!</p>
    </div>
    </div>

<?php
loadView('footer', array('store_details' => $store_details, 'store_home_details'=>$store_home_details));

?>
