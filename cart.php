<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Keranjang - TokoKopilot</title>

<link rel="stylesheet" href="style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

.remove-btn{
display:inline-block;
margin-top:10px;
padding:8px 15px;
background:#C62828;
color:white;
text-decoration:none;
border-radius:8px;
font-size:14px;
}

.remove-btn:hover{
opacity:.9;
}

.empty-box{
text-align:center;
padding:80px;
width:100%;
}

</style>

</head>

<body>

<nav>

<div class="nav-left">

<a href="produk.php">
<i class="fa-solid fa-arrow-left"></i>
</a>

</div>

<div class="nav-center">

☕ TokoKopilot

</div>

<div class="nav-right">

<a href="home.php">Home</a>

<a href="produk.php">Menu</a>

<a href="history.php">History</a>

<a href="cart.php">
<i class="fa-solid fa-cart-shopping"></i>
</a>

<?php if(isset($_SESSION['role']) && $_SESSION['role']=="admin"){ ?>

<a href="admin.php">
Admin
</a>

<?php } ?>

<a href="logout.php">
Logout
</a>

</div>

</nav>

<h1 class="title">

Keranjang Belanja

</h1>

<div class="container">

<?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0){ ?>

<?php foreach($_SESSION['cart'] as $cart){ ?>

<?php

$subtotal =
$cart['harga'] * $cart['qty'];

$total += $subtotal;

?>

<div class="card">

<img src="<?= $cart['gambar']; ?>">

<div class="content">

<h3>

<?= $cart['nama']; ?>

</h3>

<p style="margin-top:8px;color:#6d4c41;">

Jumlah :
<b><?= $cart['qty']; ?></b>

</p>

<div class="price">

Rp <?= number_format($subtotal); ?>

</div>

<a
href="hapuscart.php?id=<?= $cart['id']; ?>"
class="remove-btn"
onclick="return confirm('Hapus produk dari keranjang?')">

Hapus

</a>

</div>

</div>

<?php } ?>

<?php } else { ?>

<div class="empty-box">

<h2
style="
font-family:Georgia;
color:#2C1810;
">

Keranjang masih kosong ☕

</h2>

<p
style="
margin-top:10px;
color:#6d4c41;
">

Yuk pilih kopi favorit kamu dulu

</p>

<br>

<a
href="produk.php"
class="hero-btn">

Lihat Menu

</a>

</div>

<?php } ?>

</div>

<?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0){ ?>

<div
style="
text-align:center;
padding:40px;
">

<div
style="
background:#fffaf4;
display:inline-block;
padding:25px 50px;
border-radius:20px;
box-shadow:0 10px 30px rgba(0,0,0,.1);
border:1px solid #d8c3a5;
">

<h2
style="
font-family:Georgia;
color:#2C1810;
margin-bottom:10px;
">

Total Pembayaran

</h2>

<h1
style="
color:#4E342E;
font-size:35px;
margin-bottom:20px;
">

Rp <?= number_format($total); ?>

</h1>

<a
href="checkout.php"
class="hero-btn">

Checkout Sekarang

</a>

</div>

</div>

<?php } ?>

</body>
</html>