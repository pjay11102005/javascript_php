<?php
include("../DB.php");

mysqli_select_db($conn,"complaint_system");
$sector_id = $_GET['sector_id'];

$res =  mysqli_query($conn, "SELECT * FROM spots WHERE sector_id=$sector_id");
echo "<option value=''>Select Sector</option>";

while($row = mysqli_fetch_assoc($res)){
  echo "<option value='".$row['id']."'>".$row['name']."</option>";
}
?>