<?php

session_start();
require("../db.php");
$user_email = $_SESSION['user'];
$user_sql = "SELECT * FROM users WHERE email = '$user_email'";
$user_res = $db->query($user_sql);

$user_data = $user_res->fetch_assoc();
$plan = $user_data['plans'];
$p_status = "";
if($plan != "free"){
    $ed = $user_data['expiry_date'];
    $cd = date('Y-m-d');
    if($ed < $cd){
        $p_status = "deactivate";
    } else{
        $p_status = "activate";
    }
}
$s_btn = '<button class="btn btn-secondary w-50 buy" plan="silver" amount="170">&#8377;170 / Month</button>';
$g_btn = '<button class="btn btn-warning w-50 buy" plan="gold" amount="500">&#8377;500 / Month</button>';
$p_btn = '<button class="btn btn-primary w-50 buy" plan="premium" amount="840">&#8377;840 / Month</button>';

if($plan == "silver" && $p_status =="activate"){
    $s_btn = '<button class="btn btn-secondary w-50 buy disabled" plan="silver" amount="170">Current Plan</button>';
    $g_btn = '<button class="btn btn-warning w-50 buy" plan="gold" amount="500">&#8377;500 / Month</button>';
    $p_btn = '<button class="btn btn-primary w-50 buy" plan="premium" amount="840">&#8377;840 / Month</button>';
} else if($plan == "silver" && $p_status =="deactivate"){
    $s_btn = '<button class="btn btn-secondary w-50 buy" plan="silver" amount="170">&#8377;170 / Month</button>';
    $g_btn = '<button class="btn btn-warning w-50 buy" plan="gold" amount="500">&#8377;500 / Month</button>';
    $p_btn = '<button class="btn btn-primary w-50 buy" plan="premium" amount="840">&#8377;840 / Month</button>';  
}
else if($plan == "gold" && $p_status =="activate"){
    $s_btn = '<button class="btn btn-secondary w-50 buy disabled" plan="silver" amount="170">&#8377;170 / Month</button>';
    $g_btn = '<button class="btn btn-warning w-50 buy disabled" plan="gold" amount="500">Current Plan</button>';
    $p_btn = '<button class="btn btn-primary w-50 buy" plan="premium" amount="840">&#8377;840 / Month</button>';
}else if($plan == "gold" && $p_status =="deactivate"){
    $s_btn = '<button class="btn btn-secondary w-50 buy" plan="silver" amount="170">&#8377;170 / Month</button>';
    $g_btn = '<button class="btn btn-warning w-50 buy" plan="gold" amount="500">&#8377;500 / Month</button>';
    $p_btn = '<button class="btn btn-primary w-50 buy" plan="premium" amount="840">&#8377;840 / Month</button>';  
}
else if($plan == "premium" && $p_status =="activate"){
    $s_btn = '<button class="btn btn-secondary w-50 buy disabled" plan="silver" amount="170">&#8377;170 / Month</button>';
    $g_btn = '<button class="btn btn-warning w-50 buy disabled" plan="gold" amount="500">&#8377;500 / Month</button>';
    $p_btn = '<button class="btn btn-primary w-50 buy disabled" plan="premium" amount="840">Current Plan</button>';
}else if($plan == "premium" && $p_status =="deactivate"){
    $s_btn = '<button class="btn btn-secondary w-50 buy" plan="silver" amount="170">&#8377;170 / Month</button>';
    $g_btn = '<button class="btn btn-warning w-50 buy" plan="gold" amount="500">&#8377;500 / Month</button>';
    $p_btn = '<button class="btn btn-primary w-50 buy" plan="premium" amount="840">&#8377;840 / Month</button>';  
}
?>

<div class="row">
    <h1 class="text-center mb-5">OUR PLANS</h1>
    <div class="col-md-4 px-5 mb-5">
        <div class="card shadow" style="background-color: #EAEAEA; border-width: 4px; border-color: #B0B0B0; border-radius: 12px">
            <div class="card-body text-center border-0">
                <label class="fs-5 mt-4">SILVER</label> <br>
                <label class="fs-2">50 GB</label>
                <br> <br>
                <?php echo $s_btn; ?>
                <hr>
                <label>50 GB Storage</label>
                <hr>
                <label>24X7 Technical Support</label>
                <hr>
                <label>Data Security</label>
                <hr>
                <label>SEO Services</label>
                <hr>
                <label>Email Support</label>
                <hr>
                <label>Sharing Facility</label>
                <hr>
            </div>
        </div>
    </div>


    <!-- gold plan coding -->
    <div class="col-md-4 px-5 mb-5">
        <div class="card shadow" style="background-color: #FFEFD5; border-width: 4px;  border-color: #FFD700;  border-radius: 12px">
            <div class="card-body text-center border-0">
                <label class="fs-5 mt-4">GOLD</label> <br>
                <label class="fs-2">100 GB</label>
                <br> <br>
                <?php echo $g_btn; ?>
                <hr>
                <label>100 GB Storage</label>
                <hr>
                <label>24X7 Technical Support</label>
                <hr>
                <label>Data Security</label>
                <hr>
                <label>SEO Services</label>
                <hr>
                <label>Email Support</label>
                <hr>
                <label>Sharing Facility</label>
                <hr>
            </div>
        </div>
    </div>

    <!-- premium plan coding -->
    <div class="col-md-4 px-5 mb-5">
        <div class="card shadow" style="background-color: #E8F2FF; border-width: 4px; border-color: #007BFF; border-radius: 12px">
            <div class="card-body text-center border-0">
                <label class="fs-5 mt-4">PREMIUM</label> <br>
                <label class="fs-2">UNLIMITED</label>
                <br> <br>
                <?php echo $p_btn; ?>
                <hr>
                <label>Unlimited Storage</label>
                <hr>
                <label>24X7 Technical Support</label>
                <hr>
                <label>Data Security</label>
                <hr>
                <label>SEO Services</label>
                <hr>
                <label>Email Support</label>
                <hr>
                <label>Sharing Facility</label>
                <hr>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
        $(".buy").each(function(){
            $(this).click(function(){
                var plan = $(this).attr("plan");
                var amt = $(this).attr("amount");
                location.href = "php/pay.php?plan="+plan+"&amt="+amt;
            })
        });
    });

    
</script>