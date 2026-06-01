<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['login'])){
header("Location:login.php");
exit;
}

if($_SESSION['role']!="admin"){
header("Location:home.php");
exit;
}


/* HAPUS USER */
if(isset($_GET['hapus'])){

$id = $_GET['hapus'];

/* proteksi biar admin gak kehapus sembarangan */
$cek = mysqli_query($conn,"SELECT * FROM users WHERE id='$id'");
$data = mysqli_fetch_assoc($cek);

if($data && $data['role'] == 'admin'){
echo "<script>
alert('Admin tidak bisa dihapus!');
window.location='admin_user.php';
</script>";
exit;
}

mysqli_query($conn,"DELETE FROM users WHERE id='$id'");

echo "<script>
alert('User berhasil dihapus');
window.location='admin_user.php';
</script>";
exit;

}

$query = mysqli_query($conn,"SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin User - TokoKopilot</title>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

.wrapper{
padding:50px;
max-width:1100px;
margin:auto;
}

.title{
text-align:center;
margin-bottom:40px;
}

.title h1{
font-family:Georgia;
font-size:45px;
color:#2C1810;
}

/* TABLE STYLE */
table{
width:100%;
border-collapse:collapse;
background:#fffaf4;
border-radius:20px;
overflow:hidden;
box-shadow:0 10px 30px rgba(0,0,0,.1);
}

th{
background:#2C1810;
color:white;
padding:15px;
text-align:center;
}

td{
padding:15px;
text-align:center;
border-bottom:1px solid #eee;
}

tr:hover{
background:#f5eee6;
}

/* BADGE ROLE */
.badge{
padding:6px 12px;
border-radius:20px;
font-size:12px;
color:white;
}

.admin{
background:#C8A97E;
}

.user{
background:#4E342E;
}

/* BUTTON */
.delete{
color:#C62828;
font-weight:bold;
text-decoration:none;
}

.delete:hover{
text-decoration:underline;
}

.info{
font-size:13px;
color:#777;
}

</style>

</head>

<body>

<!-- NAV -->
<nav>

<div class="nav-left">
<a href="admin.php">
<i class="fa-solid fa-arrow-left"></i>
</a>
</div>

<div class="nav-center">
☕ Manage User
</div>

<div class="nav-right">

<a href="home.php">Home</a>
<a href="logout.php">Logout</a>

</div>

</nav>


<div class="wrapper">

<div class="title">
<h1>User Management</h1>
<p class="info">Kelola akun pengguna TokoKopilot</p>
</div>

<table>

<tr>
<th>ID</th>
<th>Username</th>
<th>Role</th>
<th>Aksi</th>
</tr>

<?php while($u=mysqli_fetch_array($query)){ ?>

<tr>

<td><?= $u['id'] ?></td>

<td><?= $u['username'] ?></td>

<td>

<?php if($u['role']=="admin"){ ?>
<span class="badge admin">Admin</span>
<?php } else { ?>
<span class="badge user">User</span>
<?php } ?>

</td>

<td>

<a class="delete"
onclick="return confirm('Hapus user ini?')"
href="admin_user.php?hapus=<?= $u['id'] ?>">

Hapus

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>