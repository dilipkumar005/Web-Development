<?php
session_start();

require("db.php");
$user_email = $_SESSION['user'];

$plan = $_GET['plan'];
$storage = "";
if($plan == "silver"){
    $storage = 51200;
} else if($plan == "gold"){
    $storage = 102400;
} else if($plan == "premium"){
    $storage = 0;
}

$purchase_date = Date('Y-m-d');
$pd = new DateTime($purchase_date);
$pd->add(new DateInterval('P30D'));
$ed = $pd->format('Y-m-d');


$update = "UPDATE users SET plans='$plan',storage='$storage',purchase_date='$purchase_date',expiry_date='$ed' WHERE email='$user_email'";

if($db->query($update)){
    header("Location:../profile.php");
} else{
    echo "update failed!";
}

?>