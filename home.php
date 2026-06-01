<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location:login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>TokoKopilot</title>

<link rel="stylesheet" href="style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

<nav>

<div class="nav-left">

<a href="index.php">

<i class="fa-solid fa-arrow-left"></i>

</a>

</div>

<div class="nav-center">

☕ TokoKopilot

</div>

<div class="nav-right">

<a href="home.php">
Home
</a>

<a href="produk.php">
Menu
</a>

<a href="history.php">
History
</a>

<a href="cart.php">
<i class="fa-solid fa-cart-shopping"></i>
</a>

<?php if($_SESSION['role']=="admin"){ ?>

<a href="admin.php">
Admin
</a>

<?php } ?>

<a href="logout.php">
Logout
</a>

</div>

</nav>

<section class="hero">

<div class="hero-text">

<h1>

Vintage Coffee
<span>Experience</span>

</h1>

<p>

Selamat datang di TokoKopilot.

Nikmati suasana coffee house
bernuansa jazz klasik dengan
berbagai pilihan kopi premium,
pastry hangat, dan dessert terbaik.

Tempat sempurna untuk bekerja,
bersantai, membaca buku,
atau menikmati waktu bersama teman.

</p>

<a
href="produk.php"
class="hero-btn">

Lihat Menu

</a>

</div>

<div class="hero-image">

<img
src="assets/image/kopi.jpg"
alt="TokoKopilot">

</div>

</section>

<section style="padding:50px 80px;">

<h1
style="
text-align:center;
font-size:50px;
margin-bottom:50px;
font-family:Georgia;
">

Mengapa TokoKopilot?

</h1>

<div
style="
display:flex;
flex-wrap:wrap;
justify-content:center;
gap:30px;
">

<div class="card">

<div class="content">

<h3>

☕ Premium Coffee

</h3>

<p>

Menggunakan biji kopi pilihan
dengan kualitas terbaik.

</p>

</div>

</div>

<div class="card">

<div class="content">

<h3>

🥐 Fresh Bakery

</h3>

<p>

Croissant, Piscok,
Cheese Cake dan berbagai
snack fresh setiap hari.

</p>

</div>

</div>

<div class="card">

<div class="content">

<h3>

🎷 Jazz Atmosphere

</h3>

<p>

Suasana hangat, vintage,
dan elegan untuk menemani
setiap momen.

</p>

</div>

</div>

</div>

</section>

<section style="padding:20px 80px 80px;">

<h1
style="
text-align:center;
font-size:50px;
margin-bottom:50px;
font-family:Georgia;
">

Best Seller

</h1>

<div class="container">

<div class="card">

<img src="assets/image/cappuccino.jpg">

<div class="content">

<h3>

Cappuccino

</h3>

<p>

Espresso premium dengan
foam susu lembut.

</p>

<div class="price">

Rp 18.000

</div>

<a
href="produk.php"
class="buy-btn">

Pesan

</a>

</div>

</div>

<div class="card">

<img src="assets/image/latte.jpg">

<div class="content">

<h3>

Latte

</h3>

<p>

Perpaduan espresso dan
susu creamy pilihan.

</p>

<div class="price">

Rp 20.000

</div>

<a
href="produk.php"
class="buy-btn">

Pesan

</a>

</div>

</div>

<div class="card">

<img src="assets/image/croissant.jpg">

<div class="content">

<h3>

Croissant

</h3>

<p>

Pastry butter premium
yang fresh setiap hari.

</p>

<div class="price">

Rp 15.000

</div>

<a
href="produk.php"
class="buy-btn">

Pesan

</a>

</div>

</div>

</div>

</section>

<footer
style="
background:#2C1810;
color:white;
padding:30px;
text-align:center;
">

<h2>

☕ TokoKopilot

</h2>

<p>

Vintage Coffee House Experience

</p>

</footer>

</body>

</html>