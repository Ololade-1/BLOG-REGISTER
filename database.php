<?php

$hostname="Localhost";
$username="root";
$password="";
$dbname="Blog_hub";
$conn = new mysqli($hostname, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>