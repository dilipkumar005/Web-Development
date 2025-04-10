<?php

require("db.php");

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $pattern = "1234567890";
    $length = strlen($pattern)-1;
    $v_code = [];
    for($i=0; $i<6; $i++)
    {
        $index = rand(0, $length);
        $v_code[] = $pattern[$index];
    }

    $ver_code = implode($v_code);

    $full_name = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $check = "SELECT email FROM users WHERE email = '$email'";
    $response = $db->query($check);

    if($response->num_rows != 0){
        echo "usermatch";
    } else{
        $send_atc = mail($email,"Activation Code","Thank you for choosing our product. <p> Your Activation code is </p>".$ver_code,"From : mrdeep8923@gmail.com");
        if($send_atc) {
            // echo "User Not Found!!";
            $store = "INSERT INTO users(full_name,email,password,activation_code)
		VALUES('$full_name','$email','$password','$ver_code')";
    
            if($db->query($store)){
                echo "success";
            } else{
                echo "failed";
            }

        } else{
            echo "Try again with other Email Id";
        }

    }

    
} else{
    echo "unauthorised request";
}
?>