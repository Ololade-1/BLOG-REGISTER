<?php
session_start();
include("database.php");

function send_password_reset($name, $email, $token) {




}

if(isset($_POST['password_reset_link'])){
    $email= mysqli_real_escape_string($conn, $_POST['email']);
    $token= md5(rand());

    $check_email="SELECT email FROM registration WHERE email='$email' LIMIT 1";
    $check_email_run = mysqli_query($conn, $check_email );

    if(mysqli_num_rows( $check_email_run)> 0){
    $row = mysqli_fetch_array( $check_email_run);
    $get_name = $row['firstname'];
    $get_email= $row['email'];
    
    $update_token ="UPDATE registration SET verify_token ='$token' WHERE email='$get_email' LIMIT 1";
    $update_token_run= mysqli_query($conn, $update_token);

    if($update_token_run){
            send_password_reset($get_name,$get_email,$token);
            $_SESSION['status']="we emailed you a password reset";
            header("location: verify.php");
    }

    }else{
        $_SESSION['status']="something went wrong. #1";
        header("location: verify.php");
    }


}





 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link rel="stylesheet" href="verify.css">
</head>
<body>

<div class="container">
    <h2>Reset Your Password</h2>
<form method="post" action="verify.php">
        <div class="form-group">
            <label for="otp">Enter Email address</label>
            <input type="text" id="otp" name="otp" required>
        <button type="submit">Send Password Reset Link</button>
    </form>
</div>

</body>
</html>
