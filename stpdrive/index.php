<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
</head>
<body>

<!--navbar coding-->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top py-3">
    <div class="container-fluid">
        <a class="navbar-brand ms-3" href="index.php">
            <img src="images/logo.png" alt="logo" width="170">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item px-3">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item px-3">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item px-3">
                    <a class="nav-link" href="contact.php">Contact Us</a>
                </li>
                <li class="nav-item ps-3 pe-5">
                    <a class="nav-link" href="about.php">About Us</a>
                </li>
                <li class="nav-item px-3 bg-light rounded me-3">
                    <a class="nav-link text-dark" href="login.php">Log In</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- form coding -->

<div class="container main-con">
    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6 p-5">

        <form action="" class="signup-form">
            <h1 class="text-center mb-4">Create Your Account</h1>

            <div class="mb-4">
                <label for="username" class="form-label mb-2">Username</label>
                <input type="text" id="username" class="form-control" required placeholder="Enter your username">
            </div>

            <div class="mb-4 email_con">
                <label for="email" class="form-label mb-2">Email Address</label>
                <div class="position-relative">
                    <input type="email" id="email" class="form-control" required placeholder="your@email.com">
                    <i class="fa fa-circle-notch fa-spin email_loader d-none position-absolute" style="right: 15px; top: 50%; transform: translateY(-50%)"></i>
                </div>
            </div>

            <div class="mb-4 pass_con">
                <label for="password" class="form-label mb-2">Password</label>
                <div class="position-relative">
                    <input type="password" id="password" class="form-control" required placeholder="Create a password">
                    <i class="fa fa-eye pass_icon position-absolute" style="right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer"></i>
                </div>
            </div>

            <div class="mb-4 d-flex justify-content-between align-items-center">
                <small class="text-muted">Click Generate for a secure password</small>
                <button type="button" class="btn btn-outline-danger btn-sm pass-gen">Generate</button>
            </div>

            <div class="d-grid gap-2 mb-4">
                <button class="btn btn-primary btn-lg register_btn" type="submit" disabled>
                    <span class="register-text">Create Account</span>
                    <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                </button>
            </div>

            <div class="msg"></div>
            <div class="login-link">
                Already have an account? <a href="login.php" class="fw-medium">Log in here</a>
            </div>
        </form>

        <!-- activation code form -->

        <form action="" class="activation-form d-none">
            <h1 class="text-center mb-4">Verify Your Account</h1>
            <p class="text-center text-muted mb-4">We've sent an activation code to your email</p>

            <div class="mb-4">
                <label for="activation_code" class="form-label mb-2">Activation Code</label>
                <input type="text" class="form-control" id="activation_code" required placeholder="Enter 6-digit code">
            </div>

            <div class="d-grid gap-2 mb-4">
                <button class="btn btn-primary btn-lg activation_btn" type="submit">
                    <span class="activation-text">Verify Account</span>
                    <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                </button>
            </div>

            <div class="text-center">
                <small class="text-muted">Didn't receive code? <a href="#" class="resend-link">Resend</a></small>
            </div>

            <div class="activation_msg"></div>
        </form>

        </div>
    </div>
</div>

<!-- javaScript coding -->

<script>

// password generate

    $(document).ready(function() {
        $(".pass-gen").click(function(e) {
            e.preventDefault();
                $("#password").attr("type","text");
                $(".pass_icon").css({color:"black"});

            $.ajax({
                type: "POST",
                url: "php/generate_password.php",
                beforeSend: function() {
                    $(".pass_icon").removeClass("fa fa-eye");
                    $(".pass_icon").addClass("fa fa-circle-notch fa-spin");
                },
                success: function(response){
                    $(".pass_icon").removeClass("fa fa-circle-notch fa-spin");
                    $(".pass_icon").addClass("fa fa-eye");
                    $("#password").val(response.trim());
                }
            })
        });

        // password show hide coding

        $(".pass_icon").click(function(){
            if($("#password").attr("type") == "password") {
                $("#password").attr("type","text");
                $(this).css({color:"black"});
            } else{
                $("#password").attr("type","password");
                $(this).css({color:"#ccc"});
            }
        });

        // email loader coding

        $("#email").on('input', function() {
            $(".email_loader").removeClass("d-none");
        });

        //check already register user

        $("#email").on('change',function() {
            $.ajax({
                type : "POST",
                url : "php/check_user.php",
                data :{
                    email : $(this).val()
                },
                success : function(response) {
                    // alert(response);
                    $(".email_loader").removeClass("fa fa-circle-notch fa-spin");
                        if(response.trim() == "notfound") {
                            $(".email_loader").removeClass("fa fa-times-circle");
                            $(".email_loader").addClass("fa fa-check-circle");
                            $(".email_loader").css({color:"green"});
                            $(".register_btn").removeAttr("disabled");
                        } else{
                            $(".email_loader").removeClass("fa fa-check-circle");
                            $(".email_loader").addClass("fa fa-times-circle");
                            $(".email_loader").css({color:"red"});
                            $(".register_btn").attr("disabled","disabled")
                        }
                }
            })
        });

        // storing data in database
        // signup form
        $(".signup-form").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type : "POST",
                url : "php/register.php",
                data : {
                    username : $("#username").val(),
                    email : $("#email").val(),
                    password : $("#password").val()
                },
                beforeSend : function(){
                    $(".register_btn").html("Please Wait...");
                    $(".register_btn").attr("disabled","disabled");
                },
                success : function(response) {
                    $(".register_btn").html("Register Now !");
                    $(".register_btn").removeAttr("disabled","disabled")
                    if(response.trim() == "success"){
                        var div = document.createElement("DIV");
                        div.className = "alert alert-success mt-3";
                        div.innerHTML = "Register Success !";
                        $(".msg").append(div);

                        setTimeout(function(){
                            $(".msg").html("");
                            // $(".signup-form").trigger('reset');
                            $(".signup-form").addClass("d-none");
                            $(".activation-form").removeClass("d-none")
                        },3000);
                    } else if(response.trim() == "usermatch"){
                        var div = document.createElement("DIV");
                        div.className = "alert alert-warning mt-3";
                        div.innerHTML = "User Already Exist !";
                        $(".msg").append(div);

                        setTimeout(function() {
                            $(".msg").html("");
                            $(".signup-form").trigger('reset');
                        },3000);
                    } else {
                        var div = document.createElement("DIV");
                        div.className = "alert alert-danger mt-3";
                        div.innerHTML = "Registration Failed !";
                        $(".msg").append(div);

                        setTimeout(function() {
                            $(".msg").html("");
                            $(".signup-form").trigger('reset');
                        },3000);
                    }
                }
            })
        });

        $(".activation-form").submit(function(e){
            e.preventDefault();
            $.ajax({
                type : "POST",
                url : "php/check_activation_code.php",
                data : {
                    email : $("#email").val(),
                    atc : $("#activation_code").val()
                },
                beforeSend : function() {
                    $(".activation_btn").find('.activation-text').addClass('d-none');
                    $(".activation_btn").find('.spinner-border').removeClass('d-none');
                    $(".activation_btn").attr("disabled","disabled");
                },
                success : function(response){
                    $(".activation_btn").find('.activation-text').removeClass('d-none');
                    $(".activation_btn").find('.spinner-border').addClass('d-none');
                    $(".activation_btn").removeAttr("disabled");
                    
                    if(response.trim() == "active"){
                        var div = document.createElement("DIV");
                        div.className = "alert alert-success mt-3";
                        div.innerHTML = "Account activated successfully! Redirecting to login...";
                        $(".activation_msg").html(div);

                        setTimeout(function(){
                            window.location = "login.php";
                        },2000);
                    } else {
                        var div = document.createElement("DIV");
                        div.className = "alert alert-danger mt-3";
                        div.innerHTML = response;
                        $(".activation_msg").html(div);
                    }
                }
            });
        });

        // Resend activation code
        $(".resend-link").click(function(e){
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "php/resend_activation.php",
                data: {
                    email: $("#email").val()
                },
                beforeSend: function() {
                    $(".resend-link").html('<i class="fas fa-circle-notch fa-spin"></i> Sending...');
                },
                success: function(response) {
                    $(".resend-link").html('Resend');
                    if(response.trim() == "sent") {
                        var div = document.createElement("DIV");
                        div.className = "alert alert-success mt-3";
                        div.innerHTML = "New activation code sent to your email!";
                        $(".activation_msg").html(div);
                    } else {
                        var div = document.createElement("DIV");
                        div.className = "alert alert-danger mt-3";
                        div.innerHTML = "Failed to resend code. Please try again.";
                        $(".activation_msg").html(div);
                    }
                }
            });
        });

    });
</script>

<?php include('element/footer.php'); ?>

</body>
</html>
