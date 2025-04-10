<?php
session_start();
require("db.php");

if(empty($_SESSION['user'])){
    die(json_encode(['status' => 'error', 'message' => 'Unauthorized']));
}

try {
    $full_name = $_POST['full_name'] ?? '';
    $email = $_SESSION['user'];
    
    if(empty($full_name)) {
        throw new Exception('Full name is required');
    }

    $sql = "UPDATE users SET full_name = ? WHERE email = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ss", $full_name, $email);
    
    if($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully']);
    } else {
        throw new Exception('Failed to update profile');
    }
} catch(Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
