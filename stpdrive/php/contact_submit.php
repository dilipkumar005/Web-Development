<?php
require("db.php");

if($_SERVER['REQUEST_METHOD'] == "POST") {
    // Basic validation
    if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['message'])) {
        echo "Please fill all fields";
        exit;
    }

    $name = $db->real_escape_string($_POST['name']);
    $email = $db->real_escape_string($_POST['email']);
    $message = $db->real_escape_string($_POST['message']);

    // Store in database
    $query = "INSERT INTO contact_messages (name, email, message, created_at) 
              VALUES ('$name', '$email', '$message', NOW())";

    if($db->query($query)) {
        // In production, you would also send an email notification here
        echo "success";
    } else {
        echo "Database error: ".$db->error;
    }
} else {
    echo "Invalid request method";
}
?>
