<?php
// Database connection
require_once('db.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode('Invalid email format');
        exit;
    }

    // Check if user exists
    $stmt = $conn->prepare("SELECT activation_code FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo json_encode('User not found');
        exit;
    }

    $user = $result->fetch_assoc();
    $activation_code = $user['activation_code'];

    // In a real application, you would send the activation code via email
    // This is just a simulation
    $mail_sent = true; // Simulate successful email sending

    if ($mail_sent) {
        echo json_encode('sent');
    } else {
        echo json_encode('Failed to send activation code');
    }
} else {
    echo json_encode('Invalid request method');
}
?>
