<?php
session_start();
include("../DB.php");
mysqli_select_db($conn,"complaint_system");

$cid = (int) $_POST['cid'];
$staff_id = (int) $_POST['staff_id'];
$admin_id = isset($_SESSION['user_id'])?$_SESSION['user_id']:'';

echo "This is test". $cid ." ". $staff_id;
// UPDATE ASSIGNMENT
mysqli_query($conn, "
UPDATE complaints 
SET assigned_to='$staff_id', status='Assigned'
WHERE id='$cid'
");

// ADD HISTORY
mysqli_query($conn, "
INSERT INTO complaint_history(complaint_id, status, updated_by, updated_at)
VALUES('$cid','Assigned','$admin_id', NOW())
");

header("Location: dashboard.php");
?>