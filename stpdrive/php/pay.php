<?php
session_start();
require("db.php");
$plan = $_GET['plan'];
$amt = $_GET['amt'];
$user_email = $_SESSION['user'];

$res = $db->query("SELECT * FROM users WHERE email = '$user_email'");
$data = $res->fetch_assoc();
$name = $data['full_name'];

require("../src/Instamojo.php");

$api = new Instamojo\Instamojo('test_2aa07d34d42f1c44a4d8f2df6cb','test_553ba39a6f13a69de6344ea2ead', 'https://test.instamojo.com/api/1.1/');

try {
    $response = $api->paymentRequestCreate(array(
        "purpose" => "S T P Drive ".$plan." Plan",
        "amount" => $amt,
        "send_email" => true,
        "email" => $user_email,
        "buyer_name" => $name,
        "redirect_url" => "http://localhost:3000/php/stpdrive/php/update_plan.php?plan=".$plan
        ));
    $main_url = $response['longurl'];

    Header("Location:$main_url");
}
catch (Exception $e) {
    print('Error: ' . $e->getMessage());
}
?>