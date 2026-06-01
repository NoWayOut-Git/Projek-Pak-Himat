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

/* JADIKAN ADMIN */
if(isset($_GET['make_admin'])){

$id = $_GET['make_admin'];

mysqli_query(
$conn,
"UPDATE users
SET role='admin'
WHERE id='$id'"
);

echo "
<script>
alert('User berhasil dijadikan Admin');
window.location='admin_approval.php';
</script>
";

exit;
}

/* HAPUS USER */
if(isset($_GET['hapus'])){

$id = $_GET['hapus'];

mysqli_query(
$conn,
"DELETE FROM users
WHERE id='$id'"
);

echo "
<script>
alert('User berhasil dihapus');
window.location='admin_approval.php';
</script>
";

exit;
}

$query = mysqli_query(
$conn,
"SELECT * FROM users
WHERE role='user'"
);
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Promote User</title>

<link rel="stylesheet" href="style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

<nav>

<div class="nav-left">

<a href="admin.php">

<i class="fa-solid fa-arrow-left"></i>

</a>

</div>

<div class="nav-center">

☕ Promote User

</div>

<div class="nav-right">

<a href="admin.php">Dashboard</a>

<a href="logout.php">Logout</a>

</div>

</nav>

<h1 class="title">

User Menunggu Promosi Admin

</h1>

<div class="container">

<?php while($u=mysqli_fetch_assoc($query)){ ?>

<div class="card">

<div class="content">

<h3>

<?= $u['nama']; ?>

</h3>

<p>

<?= $u['email']; ?>

</p>

<br>

<a
href="?make_admin=<?= $u['id']; ?>"
class="buy-btn">

Jadikan Admin

</a>

<br>

<a
href="?hapus=<?= $u['id']; ?>"
onclick="return confirm('Hapus user ini?')"
class="detail-btn">

Hapus User

</a>

</div>

</div>

<?php } ?>

</div>

</body>
</html>