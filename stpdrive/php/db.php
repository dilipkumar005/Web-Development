<?php

$db = new mysqli("localhost","root","dilip","drive");

if($db->connect_error)
{
    die("Connection not Established");
}

?>