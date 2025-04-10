<?php
session_start();

if(empty($_SESSION['user'])){
    header("Location:login.php");
}

require("php/db.php");
$user_email = $_SESSION['user'];
$user_sql = "SELECT * FROM users WHERE email = '$user_email'";
$user_res = $db->query($user_sql);

$user_data = $user_res->fetch_assoc();
$user_name = $user_data['full_name'];
$total_storage = $user_data['storage'];
$used_storage = round($user_data['used_storage'],2);

$plan = $user_data['plans'];
$free_storage = 0;

if($plan != "premium"){
    $per = round(($used_storage*100)/$total_storage,2);
    $free_storage = $total_storage - $used_storage;
}
$user_id = $user_data['id'];
$tf = "user_".$user_id;
$p_status = "";



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <?php include('element/nav.php'); ?>
    <style>
        /* Custom navbar and menubar styling for profile page */
        .navbar {
            background-color: #1a237e !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .navbar-brand img {
            filter: brightness(0) invert(1);
        }
        .left {
            background: linear-gradient(135deg, #1a237e 0%, #303f9f 100%);
        }
        .my_menu li {
            border-radius: 5px;
            margin: 5px 0;
            transition: all 0.3s ease;
        }
        .my_menu li:hover {
            background: rgba(255,255,255,0.2) !important;
            transform: translateX(5px);
        }
        .profile_pic {
            border: 4px solid rgba(255,255,255,0.2);
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
    </style>

    <style>
        .main-container{
            width: 100%;
            height: 100vh;
        }
        .left{
            width: 20%;
            height: 100%;
            overflow-x: hidden;
            overflow-y: auto;
            background-color: #080429;
        }
        .right{
            width: 83%;
            height: 100%;
            overflow: auto;
        }
        .profile_pic{
            width: 100px;
            height: 100px;
            border-radius: 100%;
            border: 4px solid white;
        }
        .line{
            color: #fff !important;
            width: 100%;
        }
        .storage{
            width: 80%;
        }
        .thumb{
            width: 75px;
            height: 75px;
        }
        .my_menu{
            list-style: none;
            padding: 0;
            margin: 0;
            width: 100%;
        }
        .my_menu li{
            width: 100%;
            padding: 10px;
            color: #fff;
            padding-left: 40px;
        }
        .my_menu li {
            transition: all 0.3s ease;
        }
        .my_menu li:hover, .my_menu li.active {
            background-color: rgba(255,255,255,0.2);
            color: #fff;
            cursor: pointer;
            transform: translateX(5px);
        }
        .my_menu li.active {
            border-left: 3px solid #fff;
        }
        .msg{
            width: 100%;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.7);
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000000;
        }
        @media(max-width:992px){
            .right{
                width: 100%;
            }
            .mobile_menu{
                position: fixed;
                top: 0;
                left: 0;
                background-color: #080429;
                width: 0%;
                height: 100vh;
                z-index: 1000000;
                overflow: hidden;
                transition: 0.5s;

            }
        }
    </style>
</head>
<body>

    <div class="main-container d-flex" style="margin-top: 60px;">
        <div class="left d-none d-lg-block">
            <div class="d-flex justify-content-center align-items-center flex-column pt-5">
                <div class="profile-section d-flex flex-column align-items-center">
                    <div class="profile-pic-container position-relative">
                        <div class="profile_pic d-flex justify-content-center align-items-center">
                            <i class="fa fa-user fs-1 text-white"></i>
                        </div>
                        <button class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle p-0" style="width: 25px; height: 25px;" title="Change profile picture">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>
                    <div class="profile-info text-center mt-3">
                        <span class="text-white fs-4 fw-bold"><?php echo $user_name ?></span>
                        <div class="d-flex justify-content-center mt-2">
                            <span class="badge bg-<?php echo ($plan == 'premium') ? 'warning' : 'secondary' ?>">
                                <?php echo ucfirst($plan) ?> Account
                            </span>
                        </div>
                    </div>
                    <div class="profile-actions mt-3 w-100">
                        <div class="dropdown">
                            <button class="btn btn-outline-light dropdown-toggle w-100" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-cog me-2"></i>Account Settings
                            </button>
                            <ul class="dropdown-menu w-100" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item" href="#" onclick="loadPage('edit_profile.php')"><i class="fas fa-user-edit me-2"></i>Edit Profile</a></li>
                                <li><a class="dropdown-item" href="#" onclick="loadPage('change_password.php')"><i class="fas fa-lock me-2"></i>Change Password</a></li>
                                <li><a class="dropdown-item" href="#" onclick="loadPage('notification_settings.php')"><i class="fas fa-bell me-2"></i>Notification Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="php/logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <hr class="line">
                <button class="btn btn-light rounded-pill upload"> <i class="fa fa-upload"></i>Upload File</button>
                
                <div class="progress storage mt-3 d-none u_pro">
                    <div class="progress-bar bg-primary upload_p" style="width:0%"></div>
                </div>

                <div class="upload_msg"></div>

                <hr class="line">
                    <ul class="my_menu">
                        <li class="menu" p_link="my_files"><i class="fas fa-folder-open"></i> My Files</li>
                        <li class="menu" p_link="f_files"><i class="fas fa-star"></i> Favourite Files</li>
                        <li class="menu" p_link="buy_storage"><i class="fas fa-shopping-cart"></i> Buy Storage</li>
                    </ul>
                <hr class="line">

                <?php
                if($plan != "premium")
                    {
                ?>
                        <span class="text-white mb-2"><i class="fas fa-database"></i> STORAGE</span>
                        <div class="progress storage">
                            <div class="progress-bar bg-primary pb" style="width: <?php echo $per ?>%"></div>
                        </div>

                        <span class="text-white"> <span class="us"> <?php echo $used_storage ?></span>MB / <?php echo $total_storage ?>MB</span>
                        <?php
                    } else{
                        ?>
                        <span class="text-white mb-2"><i class="fas fa-database"></i> USED STORAGE</span>
                        <span class="text-white"> <span class="us"> <?php echo $used_storage ?></span>MB </span>
                        <?php
                    }
                ?>
                <!-- Logout button removed from desktop view since it's now in dropdown -->
            </div>
        </div>

        <!-- mobile menu coding start -->

        <div class="mobile_menu d-block d-lg-none">
            <i class="fas fa-times text-light fs-2 pt-3 ps-3 cut"></i>
            <div class="d-flex justify-content-center align-items-center flex-column pt-2">
                <div class="profile_pic d-flex justify-content-center align-items-center">
                    <i class="fa fa-user fs-1 text-white"></i>
                </div>
                <span class="text-white fs-3 mt-3"><?php echo $user_name ?></span>

                <hr class="line">
                <button class="btn btn-light rounded-pill upload"> <i class="fa fa-upload"></i>Upload File</button>
                
                <div class="progress storage mt-3 d-none u_pro">
                    <div class="progress-bar bg-primary upload_p" style="width:0%"></div>
                </div>

                <div class="upload_msg"></div>

                <hr class="line">
                    <ul class="my_menu">
                        <li class="menu mn" p_link="my_files"><i class="fas fa-folder-open"></i> My Files</li>
                        <li class="menu mn" p_link="f_files"><i class="fas fa-star"></i> Favourite Files</li>
                        <li class="menu mn" p_link="buy_storage"><i class="fas fa-shopping-cart"></i> Buy Storage</li>
                    </ul>
                <hr class="line">

                <?php
                if($plan != "premium")
                    {
                ?>
                        <span class="text-white mb-2"><i class="fas fa-database"></i> STORAGE</span>
                        <div class="progress storage">
                            <div class="progress-bar bg-primary pb" style="width: <?php echo $per ?>%"></div>
                        </div>

                        <span class="text-white"> <span class="us"> <?php echo $used_storage ?></span>MB / <?php echo $total_storage ?>MB</span>
                        <?php
                    } else{
                        ?>
                        <span class="text-white mb-2"><i class="fas fa-database"></i> USED STORAGE</span>
                        <span class="text-white"> <span class="us"> <?php echo $used_storage ?></span>MB </span>
                        <?php
                    }
                ?>
                <!-- Logout button removed from mobile view since it's now in dropdown -->
            </div>
        </div>
        <!-- mobile menu coding end -->

        <div class="right">
            <nav class="navbar navbar-light bg-light p-3 shadow-sm sticky-top">
                <div class="container-fluid">
                    <i class="fas fa-bars fs-4 bar d-block d-lg-none"></i>
                    <form class="d-flex ms-auto search_frm">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" id="search">
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                    </form>
                </div>
            </nav>

            <div class="content p-4">
                <div class="row">
                    <?php 
                    $file_data_sql = "SELECT * FROM $tf";
                    $file_res = $db->query($file_data_sql);

                    while($file_array = $file_res->fetch_assoc()){
                        $fd_array = pathinfo($file_array['file_name']);
                        $file_name = $fd_array['filename'];
                        $f_ext = $fd_array['extension'];
                        $basename = $fd_array['basename'];

                        echo '
                            <div class="col-md-4">
                            <div class="d-flex border align-items-center p-3 mb-3">
                                <div class="me-3">';
                                if($f_ext == "mp4"){
                                    echo "<img src='images/mp4.png' class='thumb'>";
                                } else if($f_ext == "mp3"){
                                    echo "<img src='images/mp3.png' class='thumb'>";
                                } else if($f_ext == "pdf"){
                                    echo "<img src='images/pdf.png' class='thumb'>";
                                } else if($f_ext == "docx" || $f_ext == "doc"){
                                    echo "<img src='images/doc.png' class='thumb'>";
                                } else if($f_ext == "xlsx"  || $f_ext == "xls"){
                                    echo "<img src='images/xlsx.png' class='thumb'>";
                                } else if($f_ext == "pptx"  || $f_ext == "ppt"){
                                    echo "<img src='images/ppt.png' class='thumb'>";
                                } else if($f_ext == "zip"){
                                    echo "<img src='images/zip.png' class='thumb'>";
                                }else if($f_ext == "txt"){
                                    echo "<img src='images/txt.png' class='thumb'>";
                                }else if($f_ext == "mov"){
                                    echo "<img src='images/mov.png' class='thumb'>";
                                }else if($f_ext == "wmv"){
                                    echo "<img src='images/wmv.png' class='thumb'>";
                                }else if($f_ext == "jpg"  || $f_ext == "jpeg" || $f_ext == "png" || $f_ext == "gif" || $f_ext == "webp"){
                                    echo "<img src='data/".$tf."/".$basename."' class='thumb'>";
                                }
                                echo '</div>

                                    <div class="w-100">
                                    <p>'.$file_name.'</p>
                                    <hr>
                                        <div class="d-flex justify-content-around w-100">
                                        <a href="data/'.$tf.'/'.$basename.'" target="blank"><i class="fas fa-eye"></i></a>
                                        <a href="data/'.$tf.'/'.$basename.'" download><i class="fas fa-download"></i></a>
                                        <i class="fas fa-trash"></i>
                                        </div>
                                    </div>
                            </div>
                            </div>

                        ';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="msg d-none">

    </div>

    <?php

    if($plan != "free"){
        $ed = $user_data['expiry_date'];
        $cd = date('Y-m-d');

        if($ed < $cd){
            $p_status = "deactivate";
            echo "<style>.upload,[p_link='my_files'],[p_link='f_files']{pointer-events:none}</style>";
        } else{
            $p_status = "activate";
        }
    }

?>
    <script>
        function loadPage(page) {
            $('[p_link="my_files"]').click();
            $.ajax({
                url: "php/pages/" + page,
                beforeSend: function(){
                    var div = document.createElement("DIV");
                    $(div).addClass("alert alert-success fs-2 text-center p-5");
                    $(div).html("<i class ='fas fa-spinner fa-spin display-2'></i><br>Loading...");
                    $(".msg").html(div);
                    $(".msg").removeClass("d-none");
                },
                success: function(response){
                    $(".msg").addClass("d-none");
                    $(".content").html(response);
                }
            });
        }

        $(document).ready(function(){
            $(".upload").click(function(){
                var input = document.createElement("INPUT");
                input.setAttribute("type","file");
                input.click();
                input.onchange = function(){
                    $(".u_pro").removeClass("d-none");
                    var file = new FormData();
                    file.append("data",input.files[0]);

                    var file_size = Math.floor(input.files[0].size/1024/1024);
                    var free_storage = <?php echo $free_storage ?>;
                    var plan = "<?php echo $plan; ?>";

                    function upload(){
                        $.ajax({
                            type :"POST",
                            url : "php/upload.php",
                            data : file,
                            processData:false,
                            contentType:false,
                            cache:false,
                            xhr : function(){
                                var request = new XMLHttpRequest();
                                request.upload.onprogress = function(e){
                                    var loaded = (e.loaded/1024/1024).toFixed(2);
                                    var total = (e.total/1024/1024).toFixed(2);
                                    var upload_per = ((loaded*100)/total).toFixed(0);

                                    $(".upload_p").css("width",upload_per+"%");
                                    $(".upload_p").html(upload_per+"%");
                                }
                                return request;
                            },
                            success: function(response){
                                var obj = JSON.parse(response);
                                $(".u_pro").addClass("d-none");
                                if(obj.msg == "File Upload Successfully"){
                                    var new_per = (obj.used_storage*100)/<?php echo $total_storage ?>;
                                    $(".us").html(obj.used_storage);
                                    $(".pb").css("width",new_per+"%");

                                    var div = document.createElement("DIV");
                                    div.className = "alert alert-success mt-3";
                                    div.innerHTML = obj.msg;
                                    $(".upload_msg").append(div);
                                    my_files();

                                    setTimeout(function(){
                                        $(".upload_msg").html("");
                                        $(".upload_p").css("width","0");
                                        $(".upload_p").html("");
                                    },3000);

                                } else{
                                    var div = document.createElement("DIV");
                                    div.className = "alert alert-danger mt-3";
                                    div.innerHTML = obj.msg;
                                    $(".upload_msg").append(div);

                                    setTimeout(function(){
                                        $(".upload_msg").html("");
                                        $(".upload_p").css("width","0");
                                        $(".upload_p").html("");
                                    },3000);
                                }
                            }
                        });
                    }

                    if(plan == "premium"){
                        upload();
                    } else{ 
                        if(file_size<free_storage){
                            upload();
                        } else {
                            var div = document.createElement("DIV");
                            div.className = "alert alert-danger mt-3";
                            div.innerHTML = "File Size is too Large. Kindly Purchase More Storage";
                            $(".upload_msg").append(div);

                            setTimeout(function(){
                                $(".upload_msg").html("");
                                $(".upload_p").css("width","0");
                                $(".upload_p").html("");
                                $(".u_pro").addClass("d-none");
                            },3000);
                        }
                    }

                }
            });
            // menu coding
    
            $(".menu").each(function(){
                $(this).click(function(){
                    $(".menu").removeClass("active");
                    $(this).addClass("active");
                    var page_link = $(this).attr("p_link");
                    
                    $.ajax({
                        type:"POST",
                        url:"php/pages/"+page_link+".php",
                        beforeSend: function(){
                            var div = document.createElement("DIV");
                            $(div).addClass("alert alert-success fs-2 text-center p-5");
                            $(div).html("<i class ='fas fa-spinner fa-spin display-2'></i><br>Loading...");
                            $(".msg").html(div);
    
                            $(".msg").removeClass("d-none");
                        },
                        success:function(response){
                            $(".msg").addClass("d-none")
                            $(".content").html(response);
                        }
    
                    })
                })
            });
            function my_files(){
                if("<?php echo $plan;?>" != "free"){
                    if("<?php echo $p_status; ?>" == "activate"){
                        $('[p_link="my_files"]').click();
                    } else{
                        $('[p_link="buy_storage"]').click();
                    }
                } else {
                    $('[p_link="my_files"]').click();
                }
            }
            my_files();

            $(".cut").click(function(){
                $(".mobile_menu").css({"width":"0%"})
            })
            $(".bar").click(function(){
                $(".mobile_menu").css({"width":"75%"});
            })

            $(".mn").each(function(){
                $(this).click(function(){
                    $(".mobile_menu").css({"width":"0%"});
                })
            })

            $(".search_frm").submit(function(e){
                e.preventDefault();
                var query = $("#search").val();
                $.ajax({
                        type:"POST",
                        url:"php/pages/search.php",
                        data:{
                            query:query
                        },
                        beforeSend: function(){
                            var div = document.createElement("DIV");
                            $(div).addClass("alert alert-success fs-2 text-center p-5");
                            $(div).html("<i class ='fas fa-spinner fa-spin display-2'></i><br>Loading...");
                            $(".msg").html(div);
    
                            $(".msg").removeClass("d-none");
                        },
                        success:function(response){
                            $(".msg").addClass("d-none")
                            $(".content").html(response);
                        }
    
                    })
                
            })
        }); 

</script>

<?php include('element/footer.php'); ?>

</body>
</html>
