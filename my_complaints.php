<?php
if(session_status() == PHP_SESSION_NONE){
  session_start();
}

include("../DB.php");
include("../navbar.php");

mysqli_select_db($conn,"complaint_system");

if($_SERVER['REQUEST_METHOD'] == "GET"){
$cid = $_GET['id'];

}
  

$res = mysqli_query($conn, "
SELECT ch.*, u.name 
FROM complaint_history ch
JOIN users u ON ch.updated_by = u.id
WHERE complaint_id='$cid'
ORDER BY updated_at ASC
");
?>

<h3>Complaint Timeline</h3>

<?php while($row = mysqli_fetch_assoc($res)){ ?>
<div style="border-left:2px solid black; margin:10px; padding:10px;">
    <b><?php echo $row['status']; ?></b><br>
    By: <?php echo $row['name']; ?><br>
    Time: <?php echo $row['updated_at']; ?>
</div>
<?php } ?>