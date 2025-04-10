<?php

require("db.php");

$id =$_POST['sid'];
$status = $_POST['s_status'];
$table = $_POST['s_folder'];

$update = "UPDATE $table SET star ='$status' WHERE id ='$id'";

$res = $db->query($update);
if($res){
    echo "success";
} else{
    echo "failed";
}
?>