<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['login'])){
header("Location:login.php");
exit;
}

$user_id = $_SESSION['user_id'];

$query = mysqli_query(
$conn,
"SELECT *
FROM orders
WHERE user_id='$user_id'
ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Riwayat Pembelian</title>

<link rel="stylesheet" href="style.css">

<style>

.history-container{
max-width:1100px;
margin:auto;
padding:40px;
}

.history-card{
background:white;
padding:25px;
margin-bottom:20px;
border-radius:15px;
box-shadow:0 5px 15px rgba(0,0,0,.1);
}

.invoice{
font-size:20px;
font-weight:bold;
color:#2C1810;
}

.total{
font-size:22px;
font-weight:bold;
margin-top:10px;
color:#4E342E;
}

.badge{
display:inline-block;
padding:6px 12px;
border-radius:20px;
color:white;
font-size:12px;
margin-top:10px;
}

.lunas{
background:green;
}

.cod{
background:orange;
}

.btn{
display:inline-block;
margin-top:15px;
padding:10px 15px;
background:#2C1810;
color:white;
text-decoration:none;
border-radius:10px;
}

.kosong{
text-align:center;
padding:100px;
}

</style>

</head>

<body>

<nav>

<div class="nav-left">

<a href="home.php">
<i class="fa-solid fa-arrow-left"></i>
</a>

</div>

<div class="nav-center">
☕ Riwayat Pembelian
</div>

<div class="nav-right">

<a href="home.php">Home</a>
<a href="produk.php">Menu</a>
<a href="cart.php">Cart</a>

<?php if($_SESSION['role']=="admin"){ ?>
<a href="admin.php">Admin</a>
<?php } ?>

<a href="logout.php">Logout</a>

</div>

</nav>

<div class="history-container">

<h1>☕ Riwayat Pembelian</h1>

<?php if(mysqli_num_rows($query) > 0){ ?>

<?php while($item = mysqli_fetch_assoc($query)){ ?>

<div class="history-card">

<div class="invoice">
<?= $item['invoice'] ?>
</div>

<p>
👤 <?= $item['customer'] ?>
</p>

<p>
💳 <?= $item['metode'] ?>
</p>

<p>
📅 <?= $item['tanggal'] ?>
</p>

<div class="total">
Rp <?= number_format($item['total']) ?>
</div>

<?php if($item['status']=="Lunas"){ ?>

<span class="badge lunas">
<?= $item['status'] ?>
</span>

<?php } else { ?>

<span class="badge cod">
<?= $item['status'] ?>
</span>

<?php } ?>

<br>

<a
class="btn"
href="receipt.php?invoice=<?= $item['invoice'] ?>">
Lihat Receipt
</a>

</div>

<?php } ?>

<?php } else { ?>

<div class="kosong">

<h2>Belum ada transaksi</h2>

<p>Silakan belanja terlebih dahulu</p>

</div>

<?php } ?>

</div>

</body>
</html>