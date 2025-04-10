<?php
session_start();
require("../db.php");

if(empty($_SESSION['user'])){
    header("Location:../../login.php");
}
?>
<div class="container">
    <h2 class="mb-4">Change Password</h2>
    <form id="changePasswordForm">
        <div class="mb-3">
            <label class="form-label">Current Password</label>
            <input type="password" class="form-control" name="current_password" required>
        </div>
        <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" class="form-control" name="new_password" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Confirm New Password</label>
            <input type="password" class="form-control" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary">Change Password</button>
    </form>
</div>

<script>
$(document).ready(function(){
    $("#changePasswordForm").submit(function(e){
        e.preventDefault();
        if($("input[name='new_password']").val() !== $("input[name='confirm_password']").val()){
            alert("New passwords don't match!");
            return;
        }
        
        $.ajax({
            type: "POST",
            url: "php/update_password.php",
            data: $(this).serialize(),
            success: function(response){
                try {
                    const result = JSON.parse(response);
                    if(result.status === 'success') {
                        alert(result.message);
                        window.location.reload();
                    } else {
                        alert(result.message);
                    }
                } catch(e) {
                    alert('Error processing response');
                }
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });
});
</script>
