<?php
session_start();
include("../DB.php");

$cid = $_POST['cid'];
$status = $_POST['status'];
$staff_id = $_SESSION['user_id'];

mysqli_select_db($conn,"complaint_system");

// UPDATE STATUS
if($status == 'Resolved'){
mysqli_query($conn, "
UPDATE complaints 
SET status='Resolved' 
WHERE id='$cid'
");
}
else{
mysqli_query($conn, "
UPDATE complaints 
SET status='$status' 
WHERE id='$cid'
");

}

// INSERT HISTORY
mysqli_query($conn, "
INSERT INTO complaint_history(complaint_id, status, updated_by, updated_at)
VALUES('$cid', '$status', '$staff_id', NOW())
");

echo "Inserted successfully";

header("Location: dashboard.php");
?>