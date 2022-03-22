<?php
$title = 'Contact Us';
?>

<?php
//print_r($_POST);exit;
if(isset($_POST['email']) && $_POST['email'] != ''){
    $url =API_URL.'api/Store/StoreContactUs';

    $name = $_POST['name'];
    $contact_email = $_POST['email'];
    $phone = $_POST['phone'];
    $subject = addslashes($_POST['subject']);
    $message = addslashes($_POST['message']);

    $data = array("StoreId"=>$_SESSION['STORE_ID'],"AppId"=>$appId, "ContactUsEmail"=>$contact_email, "Message"=>$message, "Name"=>$name, "Phone"=>$phone, "Subject"=>$subject,"SessionId"=>$_SESSION['SESSION_ID'],"UserId"=>$_SESSION['USER_ID'],"DeviceId"=>$_SESSION['DEVICE_ID'], "DeviceType"=>"W");
    $curl = curl_init();
    $response = api_call($curl, $url, $data);
    $json_res = json_decode($response);
    $_GET['s'] = 1;
}
?>
