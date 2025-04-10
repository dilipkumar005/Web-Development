<?php
session_start();
require("../db.php");

if(empty($_SESSION['user'])){
    header("Location:../../login.php");
}

$user_email = $_SESSION['user'];
$user_sql = "SELECT * FROM users WHERE email = '$user_email'";
$user_res = $db->query($user_sql);
$user_data = $user_res->fetch_assoc();

// Set default values if notification fields don't exist
if (!isset($user_data['email_notifications'])) {
    $user_data['email_notifications'] = 0;
}
if (!isset($user_data['sms_notifications'])) {
    $user_data['sms_notifications'] = 0;
}
?>
<div class="container">
    <h2 class="mb-4">Notification Settings</h2>
    <form id="notificationSettingsForm">
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="email_notifications" <?php echo $user_data['email_notifications'] ? 'checked' : '' ?>>
            <label class="form-check-label">Email Notifications</label>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="sms_notifications" <?php echo $user_data['sms_notifications'] ? 'checked' : '' ?>>
            <label class="form-check-label">SMS Notifications</label>
        </div>
        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
</div>

<script>
$(document).ready(function(){
    $("#notificationSettingsForm").submit(function(e){
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "php/update_notifications.php",
            data: $(this).serialize(),
            success: function(response){
                alert("Notification settings updated successfully");
            }
        });
    });
});
</script>
