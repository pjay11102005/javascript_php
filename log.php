<?php
session_start();

include("DB.php");

mysqli_select_db($conn,"complaint_system");
$email = $_POST['Email'];
$pass = $_POST['password'];




$query = "SELECT * FROM users WHERE Email = '$email'";
$result = mysqli_query($conn,$query);

if(mysqli_num_rows($result) == 1){
  $rows = mysqli_fetch_assoc($result);



  if(password_verify($pass,$rows['Password'])){
  $_SESSION['user_id'] = $rows['ID'];
  $_SESSION['role'] = $rows['Role'];
  $_SESSION['name'] = $rows['Name'];

  if($rows['Role'] == 'User'){
    echo "This is User role";
    header("Location: user/dashboard.php");
    exit();
  }

  elseif($rows['Role'] == 'Admin'){
    echo "This is Admin";
    header("Location: admin/dashboard.php");
    exit();
  }

  elseif($rows['Role'] == 'Staff'){
    echo "This is Staff";
    header("Location: staff/dashboard.php");
    exit();
  }

  else{
    echo "No role";
    header("Location: register.html");
    exit();
  }

  
  }

  else{
    echo "Invalid password";
  }

  
  }

  else{
    echo "Invalid Login";
  }


?>