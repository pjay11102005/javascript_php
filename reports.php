<?php
if(session_status() == PHP_SESSION_NONE){
  session_start();
}
$name = isset($_SESSION['name']) ? $_SESSION['name'] :'';
$role = isset($_SESSION['role']) ? $_SESSION['role'] :'';
$staff_id = $_SESSION['user_id'];

include("../navbar.php");
include("../DB.php");

mysqli_select_db($conn,"complaint_system");


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reports</title>
<style>
.head{
  
  display:flex;
  justify-content: center;
  align-items: center;
}
#Report_tab{
display: flex;
justify-content: center;
align-items: center;
height: 100vh;
}

</style>
</head>
<body>
  <h2 class="head"> Report Dashboard</h2>
  <h3 style="position: absolute; left:500px; top:220px; right:auto;"> Staff Performance</h3>

  <?php
  $query = "SELECT u.Name, COUNT(*) as total FROM complaints c JOIN users u
   ON c.assigned_to = u.id WHERE c.status = 'Resolved' GROUP BY c.assigned_to";
   $res = mysqli_query($conn,$query);
  ?>
  <div id ="Report_tab">
<table border = "1" >
<tr><th>Name</th><th>Resolved</th></tr>
<?php while($row = mysqli_fetch_assoc($res)){ ?>
  <tr>
    <td><?php echo $row['Name']?></td>
    <td><?php echo $row['total']?></td>
  </tr>
<?php  } ?>
  </table>
  </div>
  
</body>
</html>
