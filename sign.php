<?php
session_start();
include("database.php");

try{
    if (isset($_POST['signin'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Email and password are required";
        header("location: signin.php");
        exit();
    } else {
        $sql = "SELECT * FROM registration WHERE email=?";
        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            $_SESSION['error'] = "Database error: " . mysqli_error($conn);
            header("location: profile.php");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (!$result) {
            $_SESSION['error'] = "Query error: " . mysqli_error($conn);
            header("location: signin.php");
            exit();
        }

        if ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['id'] = $row['id']; 
                $_SESSION['email'] = $row['email'];
                header("location: profile.php");
                exit();
            } else {
                $_SESSION['error'] = "Incorrect email or password";
                header("location: signin.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "User not found";
            header("location: signin.php");
            exit();
        }
    }
} else {
    header("location: signin.php");
    exit();
}}
catch(throwable $e){
    print "Error :" . $e->getmessage();
}
?>
