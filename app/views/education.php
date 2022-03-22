<?php
loadView('header', array('title' => $title, 'store_details' => $store_details));
?>

<div class="container">
    <div class="margin-top">
        <h1 class="tiles">Education &amp; Seminar</h1>
        <h2 class="tiles">Our Dedication To Education</h2>
        <p>We are truly passionate about our profession and with over forty years of industry experience our staff is well qualified to assist you. Whether you’re planning a large party or a romantic dinner for two, we’ve got you covered. Or maybe like many of our customers, you’d enjoy attending one of our popular seminars which are held regularly in our Education and Tasting Center.</p>
        <h3 class="tiles">Education and Tasting Center</h3>
        <p>Our Education and Tasting Center located in-store, regularly hosts fun and informative seminars and tastings. Learn about single malt scotches, Kentucky bourbons, Fine Wines, Craft Beers, Cocktail making and more. These seminars are generally FREE but seating is limited so reservations are required. Be notified in advance by joining our email list below or regularly check our calendar events page.</p>
        
        <h3 class="tiles">Party Planning Guide</h3>
        <p>Here are a few general guidelines to help you plan for party. You will need to consider the number of guests you are having, the total number of hours the party will last, and the types of beverages you plan on serving. For instance, you may decide to serve just beer and wine or you may want to serve beer wine and liquors. Click here to learn more.</p>
        <h3 class="tiles">Wine Pairing Guide</h3>
        <p>Want to learn the secret to selecting the perfect wine for your meal? The main rule to remember about pairing wine with food is that you should drink what you like. With that in mind here are some basic guidelines to follow.</p>
    </div>
</div>

<?php
loadView('footer', array('store_details' => $store_details, 'store_home_details'=>$store_home_details));
?>
