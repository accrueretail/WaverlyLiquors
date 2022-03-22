<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="row">
    <?php if($type != 'edit-address'){?>
        <div class="add-new-address">
            <div class="location-address">
                <button class="btn-address" id="add-addr-btn" tabindex="0">Add New Address</button>
            </div>
            <?php 
            foreach($addresses['ListAddress'] as $address){
                
                $my_address = [];
                array_push($my_address, $address['Address1']);
                array_push($my_address, $address['Address2']);
                array_push($my_address, $address['City']);
                array_push($my_address, $address['State']);
		array_push($my_address, $address['Zip']);

		if($_GET['f'] != '1'){
            ?>
            <div class="address-table-tile ng-star-inserted">
                <table class="table table-responsive">
                    <tbody>
                        <tr>
                            <td><span class="text-muted text-uppercase ng-star-inserted"><?php if($address['IsDefault'] == '1'){?><small>Favorite</small><?php } ?></span></td>
                            <td class="text-right">
                                <div class="dropdown dropdown-favorite">
                                    <a aria-expanded="false" aria-haspopup="true" class="text-muted" data-toggle="dropdown" id="dLabel" type="button">
                                        <span class="fa fa-ellipsis-v more-icon"></span><span class="icon icon-ellipsis-vert more-icon"></span>
                                    </a>
                                    <ul aria-labelledby="dLabel" class="dropdown-menu dropdown-favorite-open">
                                        <?php if($address['IsDefault'] != '1'){?>
                                        <li class="ng-star-inserted"><a class="addr-fav" addr="<?php echo $address['AddressId'];?>">Add to Favorite</a></li>
                                        <?php } ?>
                                        <li><a href="<?php echo $siteUrl; ?>/myaccount/edit-address/<?php echo $address['AddressId'];?>">Edit</a></li>
                                        <li><a class="addr-del" addr="<?php echo $address['AddressId'];?>">Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="address-container-section" colspan="2">
                                <h5></h5><p><?php echo implode(', ',array_filter($my_address));?></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php }} ?>
            
        </div>
        <?php } ?>
        <?php 
        if($type == 'edit-address'){
            foreach($addresses['ListAddress'] as $address){
                if($addressId == $address['AddressId']){
                    $curent_address = $address;
                }
            }
        }
        //Print_r($curent_address);
        ?>
        <div class="container">
            <div class=" col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <div id="add-new-addr-form" style="<?php if($type != 'edit-address' && $_GET['f'] != '1'){?>display:none;<?php } ?>">
            <div class="row">
                <div class="col-md-12">
                    <h4><?php if($type != 'edit-address'){ echo 'Add New Address';}else{ echo 'Your Information';}?></h4>
                    <div class="row add-newaddress">
                        <div class="col-md-12">
                        <form method="POST" name="add-address" action="<?php echo $siteUrl?>/myaccount/manage-addresses" class="ng-untouched ng-pristine ng-invalid">
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-uppercase">First Name <span>*</span>
                                <input required autocomplete="none" value="<?php echo $_SESSION['FirstName'];?>" class="form-control ng-untouched ng-pristine ng-valid" name="pFirstName" placeholder="" type="name">
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-uppercase">Last Name <span>*</span>
                                <input required autocomplete="none" value="<?php echo $_SESSION['LastName'];?>"  class="form-control ng-untouched ng-pristine ng-valid" name="pLastName" placeholder="" type="name">
                                </label>
                            </div>
                        </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-uppercase">Phone Number <span>*</span>
                                    <input required class="form-control ng-untouched ng-pristine ng-valid"  value="<?php echo $_SESSION['ContactNo'];?>"  name="pContactNo" placeholder="" type="text" maxlength="14">
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        </div>
                    </div>
                    
                    <h4>Delivery Information</h4>
                    <div class="row add-newaddress">
                        <div class="col-md-12">
                            
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-uppercase">First Name <span>*</span>
                                            <input required class="form-control ng-untouched ng-pristine ng-valid"  value="<?php echo $curent_address['FirstName'];?>" name="aFirstName" placeholder="" type="name">
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-uppercase">Last Name <span>*</span>
                                            <input required class="form-control ng-untouched ng-pristine ng-valid" value="<?php echo $curent_address['LastName'];?>" name="aLastName" placeholder="" type="name">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-uppercase">Address 1 <span>*</span>
                                            <input required autocapitalize="off" value="<?php echo $curent_address['Address1'];?>" autocorrect="off"  class="form-control ng-untouched ng-pristine ng-invalid pac-target-input" name="aAddress1" placeholder="" spellcheck="off" type="text" autocomplete="off">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-uppercase">Address 2 
                                                <input class="form-control ng-untouched ng-pristine ng-valid"  value="<?php echo $curent_address['Address2'];?>"name="aAddress2" placeholder="" type="name">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-uppercase">City <span>*</span>
                                            <input required class="form-control ng-untouched ng-pristine ng-invalid"  value="<?php echo $curent_address['City'];?>" name="aCity" placeholder="" type="name">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-uppercase">State <span>*</span>
                                            <input required class="form-control ng-untouched ng-pristine ng-invalid"  value="<?php echo $curent_address['State'];?>" name="aState" placeholder="" type="name" maxlength="2">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-uppercase">Zip Code <span>*</span>
                                            <input maxlength="5" oninput="this.value = this.value.replace(/[^0-9a-z]/gi, '')
" required class="form-control ng-untouched ng-pristine ng-invalid"  value="<?php echo $curent_address['Zip'];?>" name="aZip" placeholder="" type="name">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-uppercase">NICKNAME 
                                                <input class="form-control ng-untouched ng-pristine ng-valid"  value="<?php echo $curent_address['AddressName'];?>" name="aAddressName" placeholder="" type="name">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-uppercase">Phone Number <span>*</span>
                                            <input required class="form-control ng-untouched ng-pristine ng-valid" value="<?php echo $curent_address['ContactNo'];?>" name="aContactNo" placeholder="" type="text" maxlength="14">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-uppercase">
                                                <input name="aIsDefault" value="1" type="checkbox" class="ng-untouched ng-pristine ng-valid" <?php if($curent_address['IsDefault']){echo 'checked="checked"';} ?> > SET AS FAVORITE 
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <input type="hidden" name="AddressId" value="<?php echo $curent_address['AddressId'];?>">
                                <input type="hidden" name="Gender" value="<?php echo $_SESSION['Gender'];?>">
                                <input type="hidden" name="EmailId" value="<?php echo $_SESSION['EmailId'];?>">
				<input type="hidden" name="ContactNo" value="<?php echo $_SESSION['ContactNo'];?>">
				<input type="hidden" name="redirectURL" value="<?php echo $_GET['redirectURL'];?>">

                                <div class="col-md-12 text-right">
                                    <div class="form-group">
                                        <div class="btn_right buttons-container">
					<?php
                                            if($_GET['redirectURL'] != ''){ ?>
                                            <a href="<?php echo $siteUrl;?>/<?php echo $_GET['redirectURL']; ?>" class="btn btn-default novalue" >Cancel</a>
                                            <?php } else{ ?>
                                            <a href="<?php echo $siteUrl;?>/myaccount/manage-addresses" class="btn btn-default novalue" >Cancel</a>
                                            <?php } ?>					    
					    <button class="btn btn-default close" type="submit">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                                            </div>
                                            </div>

    </div>
</div>
<style>
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{ border-top: solid 1px transparent;}
    .add-newaddress label span{ color:#a82c2e;}
    .text-uppercase{ color:#333; font-size:14px;}
    .add-newaddress .form-control {
    border-radius: 0px;
    height: 45px;
    border: solid 1px #e6e6e6;
}
.add-newaddress label {
    width: 90%;
}
.btn_right a.novalue {
    background: #a82c2e !important;
    color: #fff;
    padding: 11px 25px;
    font-size: 0.9em;
    font-stretch: normal;
    line-height: normal;
    letter-spacing: normal;
    text-align: left;
    color: #ffffff;
    opacity: 1;
    text-shadow: none !important;
    border: none;
}
.btn_right a.novalue:focus{ color:#fff !important;  outline:none; box-shadow:none; border:none;}
.btn_right button.close {
    background-color: #a82c2e !important;
    font-size: 0.9em;
    font-stretch: normal;
    line-height: normal;
    letter-spacing: normal;
    text-align: left;
    color: #ffffff;
    padding: 11px 30px;
    opacity: 1;
    text-shadow: none !important;
    border: none;
}
.add-new-address .address-container-section p{ text-align:left; color:#333;}
</style>
