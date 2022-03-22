<?php
$title = ucfirst($title);
loadView('header', array('title' => $title, 'store_details' => $store_details));
?>
<link href="<?php echo $siteUrl;?>/css/events.css" rel="stylesheet">
<div  class="container sresult">
        <div  class="row">
        <div  class="Search_div col-md-12 col-sm-12 col-lg-12 col-xs-12">
        <h4>Events</h4>
        <ol class="breadcrumb">
        <li class="breadcrumb-item">
        <a href="<?php echo $siteUrl;?>">Home</a>
       </li>
       <li  class="breadcrumb-item">
        Events
    </li>
</ol>
</div>
</div>
</div>

    
<div class="events-main">
  <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div  class="row">
    <?php
    $selected_events = [];
    foreach($events['EventIdList'] as $slected_event){
      array_push($selected_events, $slected_event['EventId']);
    }

    foreach($store_details->EventList as $event){ ?>
    <div  class="event-tiles">
      <div  class="details_img col-md-8 col-sm-8 col-lg-8 col-xs-12 animated fadeInLeft">
      <a>
	<img alt="<?php echo $event->EventName; ?>" class="img-responsive" src="<?php echo $event->EventLargeImage;?>">
      </a>
      </div>
      <div  class="details_content col-md-4 col-sm-4 col-lg-4 col-xs-12 animated fadeInRight">
        <div>
          <div  class="event-details-section">
            <div  class="detailed-events-section">
              <div  class="bottle-caps-red event-details-date text-center">
                <div  class="date-style"><?php echo $event->EventDateDisplayFirst;?></div>
                <br ><strong ><?php echo $event->EventDateDisplaySecond;?></strong>
              </div>
              <h6  class="event-details-heading"><?php echo $event->EventName;?></h6>
            </div>
          </div><hr >
        </div>
        <div  class="col-md-12">
          <ul >
            <li  class="IngredientText">
              <span  class="fa fa-dollar bottle-caps-red event-icon"></span>
              <span  class="event-para"><?php echo $event->EventPriceDisplay;?></span>
            </li>
            <li  class="IngredientText">
              <span  class="fa fa-history bottle-caps-red event-icon"></span>
              <span  class="event-para"><?php echo $event->EventStartEndDateDisplay;?> <br > <?php echo $event->EventStartEndTimeDisplay;?></span>
            </li>
            <li >
              <?php $event_address = [];
                array_push($event_address, $event->Address1);
                array_push($event_address, $event->Address2);
                array_push($event_address, $event->City);
                array_push($event_address, $event->State);
                array_push($event_address, $event->Zip);
                $event_address = array_filter($event_address);
                ?>
              <span  class="fa fa-map-marker bottle-caps-red event-icon"></span> <?php echo implode(', ', $event_address);?> 
              <span  class="pull-right">
                <a  target="_blank" href="https://www.google.com/maps/dir//<?php echo $event->StoreLatitude;?>, <?php echo $event->StoreLongitude;?>/data=!4m2!4m1!3e0">
                <i  class="icon icon-navigate"></i>
                </a>
              </span>
            </li>
            <h4 >Description</h4>
            <li ><span  class="eventdesc"><p><?php echo $event->EventDescription;?></p></span>
            <span  style="display: inline-block;"></span>
            <a  class="more" data-target="#event<?php echo $event->EventId;?>" data-toggle="modal" data-keyboard="true" type="button">...More</a>
          </li>
          <li ><span  class="pull-right">
            <?php
            if($_SESSION['USER_ID'] > 0){
            if(is_profile_updated()){?>
            <button <?php if(in_array($event->EventId, $selected_events)){ echo "disabled='disabled'";}?> event_id="<?php echo $event->EventId;?>" class="btn btn-primary register-event reg-evnt-<?php echo $event->EventId;?>" type="button">Register for Event</button>
            <?php } else if(!is_profile_updated()) {?>
            <a href="<?php echo $siteUrl;?>/myaccount/profile-edit?returnUrl=events?eid=<?php echo $event->EventId;?>"><button class="btn btn-primary register-event" type="button">Register for Event</button></a>
            <?php }} else { ?>
              <a href="<?php echo $siteUrl;?>/login?returnUrl=events?eid=<?php echo $event->EventId;?>"><button class="btn btn-primary register-event" type="button">Register for Event</button></a>
            <?php } ?>
          </span></li>
          </ul>
        </div>
      </div>
    </div>


<div  class="modelevent modal fade animated fadeInRightBig" data-backdrop="static" data-keyboard="true" id="event<?php echo $event->EventId;?>" role="dialog" tabindex="-1">
    <div  class="modal-dialog">
      <div  class="modal-content">
        <div  class="modal-header">
          <div  class="modal-title"><?php echo $event->EventName;?></div>
          <button  class="close" data-dismiss="modal" type="button">×</button>
        </div>

        <div class="modal-body">
          <p><?php echo $event->EventDescription;?></p>
        </div>
        
        <div class="modal-footer text-center buttons-container">
          <button class="btn btn-sm btn-danger noval" data-dismiss="modal" type="button">Close</button>
        </div>
      </div>
</div>
</div>

    <?php } ?>
</div>
</div>
</div>


<?php loadView('footer', array('store_details' => $store_details, 'store_home_details'=>$store_home_details));?>
<?php if(isset($_GET['eid']) && $_GET['eid']!=''){?>
<script>
$( document ).ready(function() {
  var ele = ".reg-evnt-"+<?php echo $_GET['eid'];?>;
  //console.log(ele);
  $(ele).trigger('click');
});
</script>
<?php } ?>
