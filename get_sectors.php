<?php
include("../DB.php");

$zone_id = $_GET['zone_id'];

mysqli_select_db($conn,"complaint_system");

$res =  mysqli_query($conn, "SELECT * FROM sectors WHERE zone_id=$zone_id");
echo "<option value=''>Select Sector</option>";

while($row = mysqli_fetch_assoc($res)){
  echo "<option value='".$row['id']."'>".$row['name']."</option>";
}
?>