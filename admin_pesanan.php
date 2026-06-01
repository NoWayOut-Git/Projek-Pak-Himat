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

/* SELESAIKAN PESANAN */
if(isset($_GET['done'])){

$id = intval($_GET['done']);

mysqli_query(
$conn,
"UPDATE orders
SET status='Selesai'
WHERE id='$id'"
);

echo "
<script>
alert('Pesanan selesai');
window.location='admin_pesanan.php';
</script>
";
exit;
}


/* HAPUS PESANAN */
if(isset($_GET['hapus'])){

$id = intval($_GET['hapus']);

mysqli_query(
$conn,
"DELETE FROM order_items
WHERE order_id='$id'"
);

mysqli_query(
$conn,
"DELETE FROM orders
WHERE id='$id'"
);

echo "
<script>
alert('Pesanan dihapus');
window.location='admin_pesanan.php';
</script>
";
exit;
}


$query = mysqli_query(
$conn,
"SELECT *
FROM orders
ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Admin Pesanan</title>

<link rel="stylesheet"
href="style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

.wrapper{
padding:50px;
max-width:1300px;
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

.grid{
display:grid;
grid-template-columns:
repeat(auto-fit,minmax(350px,1fr));
gap:25px;
}

.card-order{
background:#fffaf4;
border:1px solid #d8c3a5;
border-radius:20px;
padding:20px;
box-shadow:0 10px 25px rgba(0,0,0,.1);
}

.card-order h3{
font-family:Georgia;
color:#2C1810;
margin-bottom:10px;
}

.info{
line-height:1.8;
color:#555;
}

.price{
font-size:22px;
font-weight:bold;
color:#4E342E;
margin-top:15px;
}

.badge{
display:inline-block;
padding:6px 12px;
border-radius:20px;
color:white;
font-size:12px;
margin-top:10px;
}

.pending{
background:#C8A97E;
}

.done{
background:green;
}

.actions{
display:flex;
gap:10px;
margin-top:20px;
}

.btn{
flex:1;
padding:10px;
text-align:center;
text-decoration:none;
border-radius:10px;
color:white;
}

.done-btn{
background:#4E342E;
}

.delete-btn{
background:#C62828;
}

.item-box{
margin-top:15px;
padding-top:15px;
border-top:1px solid #ddd;
}

.item{
font-size:14px;
margin-bottom:8px;
}

</style>

</head>

<body>

<nav>

<div class="nav-left">

<a href="admin.php">
<i class="fa-solid fa-arrow-left"></i>
</a>

</div>

<div class="nav-center">
☕ Admin Pesanan
</div>

<div class="nav-right">

<a href="admin.php">
Dashboard
</a>

<a href="logout.php">
Logout
</a>

</div>

</nav>

<div class="wrapper">

<div class="title">
<h1>Manajemen Pesanan</h1>
</div>

<div class="grid">

<?php if(mysqli_num_rows($query)>0){ ?>

<?php while($p=mysqli_fetch_assoc($query)){ ?>

<div class="card-order">

<h3>
<?= $p['invoice']; ?>
</h3>

<div class="info">

👤 <?= $p['customer']; ?>
<br>

📍 <?= $p['alamat']; ?>
<br>

📞 <?= $p['hp']; ?>
<br>

💳 <?= $p['metode']; ?>
<br>

📅 <?= $p['tanggal']; ?>

</div>

<div class="price">

Rp <?= number_format($p['total']); ?>

</div>

<?php

$itemQuery = mysqli_query(
$conn,
"SELECT *
FROM order_items
WHERE order_id='".$p['id']."'"
);

?>

<div class="item-box">

<?php while($item=mysqli_fetch_assoc($itemQuery)){ ?>

<div class="item">

<?= $item['qty']; ?>
x
<?= $item['nama_produk']; ?>

</div>

<?php } ?>

</div>

<?php if($p['status']=="Selesai"){ ?>

<span class="badge done">
Selesai
</span>

<?php } else { ?>

<span class="badge pending">
<?= $p['status']; ?>
</span>

<?php } ?>

<div class="actions">

<?php if($p['status']!="Selesai"){ ?>

<a
href="admin_pesanan.php?done=<?= $p['id']; ?>"
class="btn done-btn">

Selesai

</a>

<?php } ?>

<a
href="admin_pesanan.php?hapus=<?= $p['id']; ?>"
onclick="return confirm('Hapus pesanan ini?')"
class="btn delete-btn">

Hapus

</a>

</div>

</div>

<?php } ?>

<?php } else { ?>

<div style="
text-align:center;
width:100%;
padding:100px;
">

<h2 style="
font-family:Georgia;
color:#2C1810;
">

Belum ada pesanan ☕

</h2>

<p>
Pesanan customer akan muncul di sini
</p>

</div>

<?php } ?>

</div>

</div>

</body>
</html>