<?php
include("../DB.php");

mysqli_select_db($conn,"complaint_system");
header("Content-Type: application/json");

$id = $_GET['id'];

$res = mysqli_query($conn,"SELECT  status, created_at FROM complaints WHERE id = '$id'");

echo json_encode(mysqli_fetch_assoc($res));

?>