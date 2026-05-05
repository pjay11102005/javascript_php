<?php
if(session_status() == PHP_SESSION_NONE){
  session_start();
}
$role = isset($_SESSION['role']) ? $_SESSION['role'] :'';

if(isset($_POST['theme'])){
  setcookie("theme", $_POST['theme'], time()+24*60*60,"/");
  header("Location: ".$_SERVER['PHP_SELF']);
}
$theme = $_COOKIE['theme'] ?? 'light';

?>

<style>
.navbar {
  background:#333;
  color:white;
  padding:10px;
  display:flex;
  justify-content:space-between;
}
.menu-icon {
  font-size:22px;
  cursor:pointer;
}
.sidebar {
  height:100%;
  width:0;
  position:fixed;
  top:0;
  left:0;
  background:#444;
  transition:0.3s;
  padding-top:60px;
  transition: 0.3s;
  overflow: hidden;
}
.sidebar a {
  padding:10px;
  display:block;
  color:white;
  text-decoration:none;
}
.sidebar button{
  background:none;
  border:none;
  color:white;
  font-size:22px;
  position:absolute;
  top:10px;
  right:10px;
  cursor:pointer;
}

.sidebar ul{
  position: absolute;
}

.sidebar.closed{
  transform: translate(-100%);
}

.sidebar a:hover {
  background:#575757;
}

body.light{
  background: white;
  color: #333;
}

body.dark{
    background:#333;
  color: white;
}

</style>
<body class="<?php echo $theme; ?>"/>
<div class="navbar">

<span class="menu-icon" onclick="openMenu()">☰</span>
  <span>
    <form action="" method="POST">
      <select name="theme" onchange="this.form.submit()">
      <option value="">Theme</option>
      <option value="dark">Dark</option>
      <option value="light">Light</option>
      </select>
      
    </form>
  </span>
  <span>Complaint System</span>
</div>

<div id="sidebar" class="sidebar">
  
<?php if($role == 'User'){ ?>
    <button  onclick="closeMenu()">✖</button>
<ul>
  <li><a href="/ProJect/user/dashboard.php">Dashboard</a></li>
  <li><a href="/ProJect/user/add_complaint_form.php">Register Complaint</a></li>
  <li><a href="/ProJect/user/my_complaints.php">My Complaints</a></li>
   <li><a href="/ProJect/logout.php">Logout</a></li>
</ul>

<?php } elseif($role == 'Staff'){ ?>
   <button onclick="closeMenu()">✖</button>
<ul>
  <li>
  <a href="/ProJect/staff/dashboard.php">Dashboard</a>
  </li>
  
    <li><a href="/ProJect/logout.php">Logout</a>
</li>
</ul>
  
<?php } elseif($role == 'Admin'){ ?>
 <button onclick="closeMenu()">✖</button>
 <ul>
  <li><a href="/ProJect/admin/dashboard.php">Dashboard</a>
  </li>
  <li>  <a href="/ProJect/admin/manage_users.php">Manage Users</a>
</li>
<li>  <a href="/ProJect/admin/assign_complaint.php">Assign Complaints</a>
</li>
<li><a href="/ProJect/admin/reports.php">Reports</a>
</li>  
 <li><a href="/ProJect/logout.php">Logout</a>
</li>
</ul>
  
<?php } ?>
  
</div>

<script>
function openMenu(){
  document.getElementById("sidebar").style.width="200px";
  
}
function closeMenu(){
  document.getElementById("sidebar").style.width="0px";
}
</script>