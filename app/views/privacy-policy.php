<?php
loadView('header', array('title' => $title, 'store_details' => $store_details));
?>

<div class="common-margin-top">
    <div class="page-margin">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                    <div class="common-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo $siteUrl;?>">Home</a></li>
                            <li class="breadcrumb-item">Privacy Policy</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="privacy-content">
                <h4 style="text-align: center; margin: 10px 0;">PRIVACY POLICY</h4>
                <p>We, Waverly Liquors, are committed to your privacy. Our pledge is to safeguard and ensure the proper use of your personal information. We understand the importance of using our personal information appropriately.</p>

                <p>In order to make our information policies transparent, on this page we describe the following:</p>
                <ul class="pptt">
                    <li>What personally identifiable information of yours or third party personally identification is collected from you through the web site</li>
                    <li>The organization collecting the information</li>
                    <li>How the information is used</li>
                    <li>With whom the information may be shared</li>
                    <li>What choices are available to you regarding collection, use and distribution of the information</li>
                    <li>The kind of security procedures that are in place to protect the loss, misuse or alteration of information under our control</li>
                    <li>How you can correct any inaccuracies in the information</li>
                </ul>
                <p>If you feel that we are not abiding by our posted privacy policy, you should first contact us through email at<a href="mailto:wliquors@gmail.com">wliquors@gmail.com</a> or by mail to our store address, 172 Route 25A, east Setauket, NY 11733.</p>
                <h4>Information Collection and Use</h4>
                <p>Waverly Liquors is the sole owner of the information collected on this site. We will not sell, share, or rent this information to others in ways different from what is disclosed in this statement. Waverly Liquors collects information from our customers at several different points on our website.</p>
                <h4>Registration</h4>
                <p>No registration is required in order to use this website, although a customer must create an account prior to any purchase. During account creation a customer is required to give their name, email address, zip code, and a password. This information is used to contact our customers about the services on our site for which they have expressed interest. It is optional for a customer to provide a phone number, but encouraged so we can have another means to contact you regarding your order.</p>

                <h4>Ordering</h4>
                <p>
                    We request information from our customers on our order form. Here a customer must provide contact information (like name and shipping address) and financial information (like credit card number, expiration date). This information is used for billing purposes and to fill the customer’s orders. If we have trouble processing an order, this contact information is used to get in touch with the user.</p>
                <h4>Cookies</h4>
                <p>
                    A cookie is a piece of data stored on the visitor's hard drive containing information specific to that visitor's use of the website. Any information placed in the cookie is accessible only to wliquors.com, and will not be sold or shared with anyone else under any circumstances. We use a cookie to store a unique session identifier, and this allows us to maintain your shopping cart from one page request to the next. We are also able to maintain your session information from one visit to the next. By setting a cookie on our site, our customers do not have to log in more than once, thereby saving time while on our site. If a customer rejects the cookie, they may still browse our site. Unfortunately, the customer experience will be greatly curtailed, as the customer will be unable to log in or make a purchase.</p>
                <h4>Log Files</h4>
                <p>
                    We use IP addresses to analyze trends, administer the site, track customer's movement, and gather broad demographic information for aggregate use. IP addresses are not linked to personally identifiable information.</p>
                <h4>Sharing</h4>
                <p>
                    Waverly Liquors will share aggregate demographic information with its partners. This is not linked to any personal information that can identify any individual person.</p>
                <p>We use an outside credit card processing company to bill customers for goods and services. Our website is built and supported by Accrueretail who help with the technical operation of our website and provide additional service as required. These companies do not retain, share, store or use personally identifiable information for any secondary purposes.
                    We value your privacy very much at Waverly Liquors, and will never release any account information to anyone outside of the necessary core groups that help our business function, like those mentioned above unless our customers give us the authority to do so.</p>
                <h4>Links</h4>
                <p>This web site may contain links to other sites. Please be aware that Waverly Liquors is not responsible for the privacy practices of such other sites. We encourage our customers to be aware when they leave our site and to read the privacy statements of each and every web site that collects personally identifiable information. This privacy statement applies solely to information collected by this Web site.</p>
                <h4>Newsletter</h4>
                <p>
                    If a customer wishes to subscribe to our newsletter, we ask for contact information such as name and email address and zip code. If at any time you should wish to unsubscribe, simply follow the link in your newsletter to update your email preferences. You may send us an email at <a href="mailto:wliquors@gmail.com">wliquors@gmail.com</a>.</p>
                <h4>Security</h4>

                <p>When our order form asks customers to enter sensitive information (such as credit card number and/or social security number), that information is encrypted and is protected with the best encryption software in the industry - SSL (Secure Socket Layers), provided by Thawte, a leading encryption software company available today. While on a secure page such as our order form, the lock icon on the bottom of Web browsers such as Google Chrome, Netscape Navigator and Microsoft Internet Explorer becomes locked, as opposed to unlocked, or open, when you are just 'surfing'.</p>
                <p>While we use SSL encryption to protect sensitive information online, we also do everything in our power to protect customer-information offline. All of our customers' information, like the sensitive information mentioned above, is restricted in our offices. Only employees who need the information to perform a specific job (for example, a salesperson) are given access to personally identifiable information.</p>
                <p>If you have any questions about the security at our website, you can send an email to <a href="mailto:wliquors@gmail.com">wliquors@gmail.com</a>.</p>

                <h4>Correcting/Updating Personal Information</h4>
                <p>If your personal information changes (such as your shipping or billing address, etc.), you can add new information or delete any addresses or credit cards from your account at the "My Account" page of our site. You can also modify your login information and opt out of our newsletter from the same page. You can always call us at (631) 941-3103 to speak to us.</p>

            </div>
        </div>
    </div>
</div>

<?php
loadView('footer', array('store_details' => $store_details, 'store_home_details'=>$store_home_details));
?>