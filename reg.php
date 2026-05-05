<?php

$host = "localhost";
$password = "JSP@123jay";
$dbname = "complaint_system";

$mysqli = new mysqli($host, 'root', $password, $dbname);

// Checking if the connection actually worked
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$pass = $_POST['pass'];
$hashedPwd = password_hash($pass,PASSWORD_DEFAULT);

$Name = $_POST['name'];
$Mail = $_POST['Email'];
$Role = $_POST['role'];

$stmt = $mysqli->prepare("INSERT INTO users(Name, Email, Role,Password) VALUES(?,?,?,?)");
$stmt->bind_param("ssss", $Name, $Mail, $Role, $hashedPwd);

$stmt->execute();

mysqli_close($mysqli);

?>