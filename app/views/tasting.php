<?php
loadView('header', array('title' => $title, 'store_details' => $store_details));
?>

<div class="container">
    <div class="margin-top">
        <h1 class="tiles">Wine Tasting Station</h1>
        <h2 class="tiles">Exceptional Selection From Around The World</h2>
        <p>Whether you’re in search of a fine vintage to mark a special occasion or a simple everyday red or white “just because,” we have the wine to suit your taste and your budget. Our wines hail from the premier growing regions around the globe and represent the best the world has to offer. Our selection truly is tremendous: still wines, sparkling wines, desert wines, ports, sherry, sake and more. We have it all, from the most popular brands to boutique wineries not readily available elsewhere.</p>
        <h3 class="tiles">Wine Specialists to Assist You</h3>
        <p>Our knowledgeable staff is always eager to help you make the perfect selections. Whether you require food pairing recommendations, party planning assistance, or just a great bottle at the best price our wine specialists will be there to assist you.</p>
        <h3 class="tiles">Visit our Wine Tasting Station</h3>
        <p>Care to sample? Stop in anytime! Our Wine Tasting Station – lets you taste 8 wines from a selection of 16 with our FREE Tasting Card. It’s the perfect way to find the wine to match your mood or your main course. Our selection of wines in the Tasting Station changes each week, so be sure to stop in often to sample our latest!</p>
        
        <h2 class="tiles">Wine Discount Policy</h2>
        <p>We keep our wine prices competitive, assuring you a terrific value. And you can get an even better wine value with us. Here is how it works:</p>
        <p><strong>10%</strong> Mix and match 6-11 bottles of wine to save 10%<br> (valid on 750ml and 1.5L bottles)<br><strong>20%</strong> Mix and match 12 or more bottles of wine to save 20%<br> (valid on 750ml bottles only)<br> Sale items count towards quantity but do not receive additional discount.Other exceptions may apply. Ask us for details!</p>
    </div>
</div>

<?php
loadView('footer', array('store_details' => $store_details, 'store_home_details'=>$store_home_details));
?>
