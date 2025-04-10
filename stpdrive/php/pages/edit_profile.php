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
?>
<div class="container">
    <h2 class="mb-4">Edit Profile</h2>
    <form id="editProfileForm">
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-control" name="full_name" value="<?php echo $user_data['full_name'] ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="<?php echo $user_data['email'] ?>" readonly>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<script>
$(document).ready(function(){
    $("#editProfileForm").submit(function(e){
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "php/update_profile.php",
            data: $(this).serialize(),
            success: function(response){
                alert("Profile updated successfully");
                window.location.reload();
            }
        });
    });
});
</script>
