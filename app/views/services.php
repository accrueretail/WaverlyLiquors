<?php
loadView('header', array('title' => $title,'store_details' => $store_details));
?>

<div class="container">
    <div class="margin-top">
        <h1 class="tiles">Services</h1>
        <h2 class="tiles">Your Superstore For Fine Wine, Spirits &amp; All Types Of Beer</h2>
        <h3 class="tiles">Custom Order Service</h3>
        <p>Can’t find what you are looking for? Send us a picture of the product and desired quantity. We will research and order on your behalf at most fair price.</p>
        <h3 class="tiles">Party Planning Service</h3>
        <p>Tell us the purpose of celebration, number of attendees, and theme of your party, we will help you plan for all type of adult beverages.</p>
        <h3 class="tiles">Gift Ideas</h3>
        <p>Birthdays, weddings, anniversaries, house warmings, holidays, whatever the occasion we can help you select a gift that will surely be enjoyed.</p>
        <h3 class="tiles">Party Planning</h3>
        <p>Here are a few general guidelines to help you plan your party. You will need to consider the number of guests you are having, the total number of hours the party will last, and the types of beverages you plan on serving.</p>
        <h3 class="tiles">Wine Pairing Guide</h3>
        <p>The main rule to remember about pairing wine with food is that you should drink what you like.</p>
    </div>
</div>

<?php
loadView('footer', array('store_details' => $store_details, 'store_home_details'=>$store_home_details));
?>
