<?php
session_start();
if (isset($_SESSION['register'])) {
    header("location: signin.php");
    exit; 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>


<div class="pics">
<a href="first.php" style=" font-size: 20px;  color: white; text-decoration: none; margin-left: 50%;">Back</a>
    <img src="twit.jpg" alt="">

    <div class="header">
    <?php      
include 'database.php';

$msg = "";

if (isset($_POST['submit'])) {
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
    $hashpassword = password_hash($password, PASSWORD_DEFAULT);
    $code = mysqli_real_escape_string($conn, md5(rand()));

   
    if (empty($firstname) || empty($lastname) || empty($phone) || empty($email) || empty($password) || empty($cpassword)) {
        $msg = "<div class='alert alert-danger'><span style='color:red;'>Please fill in all fields.</span></div>";
    } elseif (strlen($password) < 6) { 
        $msg = "<div class='alert alert-danger'><span style='color:red;'>Password must be at least 8 characters long.</span></div>";
    } elseif (!preg_match('/[A-Z]/', $password)) {
        $msg = "<div class='alert alert-danger'><span style='color:red;'>Password must contain at least one capital letter.</span></div>";
    } elseif (!preg_match('/[0-9]/', $password)) {
        $msg = "<div class='alert alert-danger'><span style='color:red;'>Password must contain at least one digit.</span></div>";
    } elseif (!preg_match('/[^a-zA-Z0-9]/', $password)) {
        $msg = "<div class='alert alert-danger'><span style='color:red;'>Password must contain at least one symbol.</span></div>";
    } elseif ($password !== $cpassword) {
        $msg = "<div class='alert alert-danger'><span style='color:red;'>Password and Confirm Password do not match.</span></div>";
    } else {
        if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM registration WHERE email='{$email}'")) > 0) {
            $msg = "<div class='alert alert-danger'>{$email} -<span style='color:red'> This email address already exists.</span></div>";
        } else {
            $sql = "INSERT INTO registration (firstname, lastname, phone, email, password, code) VALUES ('{$firstname}', '{$lastname}', '{$phone}', '{$email}', '{$hashpassword}', '{$code}');";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $msg = "<div class='alert alert-info'><span style='color:green;'>We have sent you a verification link</span></div>";
            } else {
                $msg = "<div class='alert alert-danger'><span style='color:red;'>Something went wrong</span></div>";
            }
        }
    }
}
?>



 <p><span style="color:white">Create an Account</span></p>
<?php echo $msg;?>
        <form action="signup.php" method="post">
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" placeholder="Enter your Firstname" value="<?php if(isset($_POST['submit'])) { echo $_POST['firstname']; } ?>">


            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" placeholder="Enter your lastname" value="<?php if(isset($_POST['submit'])) { echo $_POST['lastname']; } ?>">

            <label for="number">Phone Number:</label>
            <input type="text" id="phone" name="phone" placeholder="Enter your Phone Number" value="<?php if(isset($_POST['submit'])) { echo $_POST['phone']; } ?>">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your Email" value="<?php if(isset($_POST['submit'])) { echo $_POST['email']; } ?>">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your Password">

            <label for="cpassword">Confirm Password:</label>
            <input type="password" id="cpassword" name="cpassword" placeholder="Confirm your Password">

            <button type="submit" class="btn" name="submit">Register</button>
        </form>
        <p><span style="color:white">Already have an Account</span>, 
        <a href="signin.php"><span style="color:green">Sign in Now</span></a></p>

    </div>
</body>
</html>
