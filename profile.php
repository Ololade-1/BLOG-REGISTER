<?php
include('database.php');

session_start();
if (!isset($_SESSION['email'])) {
    header("location: signin.php");
    exit();
}

$email = $_SESSION['email'];
$sql = "SELECT firstname FROM registration WHERE email = ? ";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
 
    $_SESSION['firstname'] = $row['firstname'];
} else {
   
    $_SESSION['firstname'] = ""; 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <header>
        <a href="signin.php"><button class="btn1">Sign Out</button></a>
        <h1>BLOG HUB</h1>
    </header>
    
    <div class="con">
        <p>Hello ,<span style="color:green"><?php echo isset($_SESSION['firstname']) ? $_SESSION['firstname'] : 'Firstname'; ?></span>!<br> Welcome to our Blog Hub</p><br><br>
        <span style="color:green"> Start Posting and updating with us  </span>
    </div>
</body>
</html>
