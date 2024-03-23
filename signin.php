<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signin Form</title>
    <link rel="stylesheet" href="signin.css">
</head>
<body>
    <div class="pics">
        <img src="twit.jpg" alt="">
    </div>
    <div class="header">
        <p><span style="color:white; font-size:35px;">Sign In Here</span></p>
        <?php
if(isset($_SESSION['error'])) {
    echo "<div style='color:red'>".$_SESSION['error']."</div>";
    unset($_SESSION['error']); 
}
?>
        <form action="sign.php" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>  

            <button class="btn1" type="submit" name="signin">Sign In</button>
            <a href="verify.php"><span style="color:white">Forgot Password?</span></a>
        </form>

        <p><span style="color:white">If you don't have an account yet</span>, <br>
        <a href="signup.php"><span style="color:green">Create an Account</span></a></p>
    </div>
</body>
</html>
