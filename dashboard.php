<?php
if(session_status() == PHP_SESSION_NONE){
  session_start();
}


include("../DB.php");
include("../navbar.php");

$name = isset($_SESSION['name']) ? $_SESSION['name'] :'';
$role = isset($_SESSION['role']) ? $_SESSION['role'] :'';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] :'';


mysqli_select_db($conn,"complaint_system");

$res = mysqli_query($conn,"SELECT c.*, sp.name AS spot FROM complaints c JOIN spots sp ON c.spot_id = sp.id WHERE c.user_id = '$user_id' ORDER BY c.created_at DESC");


// if(!isset($_SSESION['user_id'])){
//   header("Location: ../login.php");
//   exit();
// }

if($_SESSION['role'] != 'User'){
  echo "Access denied";
  exit();
}
else{ 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard_User</title>
  <style>
    #heade{
      left: 450px;
      top: 70px;
      right: auto;
    }
  </style>
</head>
<body>
  <h1>Welcome <?php echo "$name" ?> Role <?php echo "$role"?>

  <h2 id="heade">My complaints</h2>

  <table border="1" cellpadding="10">

  <tr>
    <th>ID</th>
    <th>Title</th>
    <th>Status</th>
    <th>Spot</th>
    <th>TimeLine</th>
    <th>Repeated</th>
    <th>Track</th>
  </tr>
<?php while($row = mysqli_fetch_assoc($res)){ ?>
  <tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['title']; ?></td>
    <td><?php echo $row['status']; ?></td>
    <td><?php echo $row['spot']; ?></td>

    <td><a href="my_complaints.php ? id=<?php echo $row['id']; ?>">
      View TimeLine
    </a>
  </td>
    <td><?php echo ($row['is_repeated']) ? "Yes" : "No"; ?></td>

    <td>
      <button onclick="track(<?php echo $row['id']; ?>)">Track</button>
    </td>
  </tr>
  <?php } ?>

  </table>
  <hr>

  <h3> Track Complaint</h3>

  <div id="result"></div>
<script src="../JQuery/jquery.min.js"></script>

<script>
  function track(id){
    // $.ajax({
    //   url: "../api/track_complaint.php",
    //   type: "GET",
    //   data: { id: id},
    //   success: function(res){
    //     $("#result").html(
    //       "Status: " + res.status + "<br>"+ "Date: "+ res.created_at
    //     );
    //   }
    // });

    $.get("../api/track_complaint.php", {id : id}, function(res){
  $('#result').html("Status: "+ res.status + "<br>" + "Date: "+ res.created_at);
    });

  }
</script>
  


</body>
</html>
<?php }?>