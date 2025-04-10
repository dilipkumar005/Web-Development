<?php
session_start();
require("db.php");

if(empty($_SESSION['user'])){
    die(json_encode(['status' => 'error', 'message' => 'Unauthorized']));
}

try {
    $user_email = $_SESSION['user'];
    $email_notifications = isset($_POST['email_notifications']) ? 1 : 0;
    $sms_notifications = isset($_POST['sms_notifications']) ? 1 : 0;

    $sql = "UPDATE users SET 
            email_notifications = ?,
            sms_notifications = ?
            WHERE email = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("iis", $email_notifications, $sms_notifications, $user_email);
    
    if($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Notification settings updated successfully']);
    } else {
        throw new Exception('Failed to update notification settings');
    }
} catch(Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
