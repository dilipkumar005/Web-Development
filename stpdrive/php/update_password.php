<?php
session_start();
require("db.php");

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(empty($_SESSION['user'])){
    file_put_contents('password_change.log', date('Y-m-d H:i:s')." - Unauthorized access attempt\n", FILE_APPEND);
    die(json_encode(['status' => 'error', 'message' => 'Unauthorized']));
}

try {
    $user_email = $_SESSION['user'];
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    
    file_put_contents('password_change.log', date('Y-m-d H:i:s')." - Password change attempt for $user_email\n", FILE_APPEND);

    // Verify current password
    $sql = "SELECT password FROM users WHERE email = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    if(!$user) {
        throw new Exception('User not found');
    }

    // Check password using MD5 (legacy) or password_verify (modern)
    $password_valid = false;
    
    if(md5($current_password) === $user['password']) {
        $password_valid = true;
        file_put_contents('password_change.log', date('Y-m-d H:i:s')." - MD5 password verified for $user_email\n", FILE_APPEND);
    } elseif(password_verify($current_password, $user['password'])) {
        $password_valid = true;
        file_put_contents('password_change.log', date('Y-m-d H:i:s')." - Modern password verified for $user_email\n", FILE_APPEND);
    }

    if(!$password_valid) {
        file_put_contents('password_change.log', date('Y-m-d H:i:s')." - Incorrect current password for $user_email\n", FILE_APPEND);
        throw new Exception('Current password is incorrect');
    }
    
    if(strlen($new_password) < 8) {
        throw new Exception('Password must be at least 8 characters');
    }

    // Update password using MD5
    $hashed_password = md5($new_password);
    $sql = "UPDATE users SET password = ? WHERE email = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ss", $hashed_password, $user_email);
    
    if($stmt->execute()) {
        // Verify the update was successful
        $sql = "SELECT password FROM users WHERE email = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("s", $user_email);
        $stmt->execute();
        $result = $stmt->get_result();
        $updated_user = $result->fetch_assoc();
        
        if(md5($new_password) === $updated_user['password']) {
            file_put_contents('password_change.log', date('Y-m-d H:i:s')." - Password successfully changed for $user_email\n", FILE_APPEND);
            echo json_encode(['status' => 'success', 'message' => 'Password updated successfully']);
        } else {
            throw new Exception('Password change verification failed');
        }
    } else {
        throw new Exception('Failed to update password in database');
    }
} catch(Exception $e) {
    file_put_contents('password_change.log', date('Y-m-d H:i:s')." - Error: ".$e->getMessage()."\n", FILE_APPEND);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
