<?php
if(session_status() == PHP_SESSION_NONE){
  session_start();
}
include("../DB.php");
include("../navbar.php");

mysqli_select_db($conn,"complaint_system"); 

$id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] :'';

if($_SERVER['REQUEST_METHOD'] == "POST"){
  $Title = $_POST['title'];
  $spot_id = $_POST['spot_id'];
  $category_id = $_POST['category_id'];
  $descript = $_POST['description'];

  $check = mysqli_query($conn, "SELECT * FROM complaints
   WHERE category_id =' $category_id' AND spot_id = '$spot_id' 
    AND created_at >= NOW() - INTERVAL 7 DAY");

    $is_repeated = (mysqli_num_rows($check)>0)?1:0;

  // mysqli_query ($conn,"INSERT INTO area_master(zone,sector,spot) VALUES('$Zone','$Sector','$Spot')");

  // $area_id = mysqli_insert_id($conn);
 
  mysqli_query($conn,"INSERT INTO complaints(title,description, category_id,spot_id,user_id,status,is_repeated , created_at) 
  VALUES('$Title','$descript','$category_id','$spot_id', '$id','Submitted', '$is_repeated', NOW() )");
  $cid = mysqli_insert_id($conn);

  // setcookie("zone_id",$zone_id,time()+(7*24*3600),"/");
  // setcookie("sector_id",$sector_id,time()+(7*24*3600),"/");
  // setcookie("spot_id",$spot_id,time()+(7*24*3600),"/");

  
  $file = $_FILES['document'];

if($file['type']!="application/pdf"){

$new_name= time().".pdf";
move_uploaded_file($file['tmp_name'], "../uploads/".$new_name);

mysqli_query($conn,"INSERT INTO complaint_attachments(complaint_id,file_path,uploaded_at)VALUES('$cid','$new_name',NOW())");

}
if($file['size']> 2000000){
  echo "Tooo large file";
  exit();
}


  echo "Complaint submitted succesfully!!";
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form</title>
<script>
  var saved_zone = "<?php echo $_COOKIE['zone_id'] ?? ''; ?>";
  $("#zone").val(saved_zone).change();
</script>

<style>
  #complaint_form{
    position:absolute;
    left: 400px;
    top: 130px;
    display:block;
    padding: 20px;
    margin: 20px;
    border: 2px solid black;
    
  }
</style>
</head>
<body>

<h1><center>Complaint Form</center></h1>
  <form action="" method="post" id="complaint_form" enctype="multipart/form-data">
  Title:  <input type="text" name="title" ><br/><br/>
  Description:  <textarea  name="description"></textarea><br/><br/>

  <select name="category_id" id="category_id">

  <?php
  $res = mysqli_query($conn,"SELECT * FROM categories WHERE status=1");
  while($row = mysqli_fetch_assoc($res)){
    echo "<option value='".$row['id']."'>".$row['name']."</option>";
  }
  $zones = mysqli_query($conn,"SELECT * FROM zones");
  ?>
  </select>
<br/><br/>

  <select id="zone">
    <option value="">Select Zone</option> 

    <?php
    while($c = mysqli_fetch_assoc($zones)){?>
  
    <option value="<?php echo $c['id']; ?>">
      <?php echo $c['name']; ?>
    <?php } ?>

  </select>
  <select id="sector">
    <option value="">Select sector</option>
  </select>
  <select name="spot_id" id="spot">
    <option value="">Select spot</option>
  </select>
  <br><br>
  <input type="file" name="document" accept="application/pdf" required>
<br/><br/>
  <input type="submit" value="SEND"/>
</form>
</body>

<script src="../JQuery/jquery.min.js"></script>
<script>

$("#zone").change(function(){
var zid = $(this).val();

// $.ajax({
// url:"../api/get_sectors.php",
// type: "POST",
// data: { zone_id: zone_id },
// success: function(data){
//   $("#sector").html(data);
//           }
//         });
$.get("../api/get_sectors.php", {zone_id: zid}, function(data){
  $('#sector').html('<option>Select Sector</option>' + data);
});

});
  
  $("#sector").change(function(){
  var seid = $(this).val();
$.get("../api/get_spots.php", {sector_id: seid}, function(data){
$('#spot').html(data);
});
  });

</script>
</html>
