<?php

session_start();

include 'koneksi.php';

$id = $_GET['id'];

$query = mysqli_query(
$conn,
"SELECT * FROM products WHERE id='$id'"
);

$data = mysqli_fetch_assoc($query);

$detail = "";

switch(strtolower($data['nama_produk'])){

case "cappuccino":
$detail = "Perpaduan espresso premium dan foam susu lembut yang menghasilkan rasa seimbang serta aroma khas kopi Italia.";
break;

case "americano":
$detail = "Espresso yang dipadukan dengan air panas untuk menghasilkan cita rasa kopi yang kuat namun ringan diminum.";
break;

case "latte":
$detail = "Kombinasi espresso dan susu creamy dengan tekstur lembut yang cocok untuk segala suasana.";
break;

case "espresso":
$detail = "Kopi murni dengan ekstraksi sempurna untuk menghasilkan rasa yang intens dan kaya karakter.";
break;

case "mocha":
$detail = "Campuran espresso premium, susu segar, dan cokelat berkualitas tinggi.";
break;

case "croissant":
$detail = "Pastry butter berlapis yang renyah di luar dan lembut di dalam.";
break;

case "piscok":
$detail = "Pisang cokelat hangat dengan kulit renyah dan isian lumer.";
break;

case "cheesecake":
$detail = "Kue keju premium dengan tekstur lembut dan rasa creamy.";
break;

default:
$detail = "Menu spesial TokoKopilot dengan bahan berkualitas premium.";
}

?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>
<?php echo $data['nama_produk']; ?>
- TokoKopilot
</title>

<link rel="stylesheet" href="style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

.detail-container{

max-width:1200px;

margin:auto;

padding:60px;

display:flex;

gap:60px;

align-items:center;

}

.detail-image{

flex:1;

}

.detail-image img{

width:100%;

border-radius:30px;

box-shadow:0 15px 35px rgba(0,0,0,.2);

}

.detail-content{

flex:1;

}

.detail-content h1{

font-size:55px;

font-family:Georgia,serif;

margin-bottom:20px;

color:#2C1810;

}

.detail-price{

font-size:35px;

font-weight:bold;

color:#4E342E;

margin-bottom:25px;

}

.detail-desc{

line-height:2;

font-size:17px;

color:#555;

margin-bottom:25px;

}

.info-box{

background:#fff;

padding:20px;

border-radius:15px;

box-shadow:0 5px 15px rgba(0,0,0,.08);

margin-bottom:25px;

}

.info-box p{

margin-bottom:10px;

}

.qty{

width:120px;

padding:12px;

border-radius:10px;

border:1px solid #ddd;

font-size:16px;

margin-bottom:20px;

}

.action{

display:flex;

gap:15px;

}

.cart-btn{

flex:1;

background:#C8A97E;

color:white;

text-decoration:none;

text-align:center;

padding:15px;

border-radius:12px;

}

.buy-btn{

flex:1;

background:#2C1810;

color:white;

text-decoration:none;

text-align:center;

padding:15px;

border-radius:12px;

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

<a href="cart.php">Keranjang</a>

<a href="history.php">History</a>

</div>

</nav>

<div class="detail-container">

<div class="detail-image">

<img src="<?php echo $data['gambar']; ?>">

</div>

<div class="detail-content">

<h1>

<?php echo $data['nama_produk']; ?>

</h1>

<div class="detail-price">

Rp <?php echo number_format($data['harga']); ?>

</div>

<div class="detail-desc">

<?php echo $detail; ?>

</div>

<div class="info-box">

<p>☕ Dibuat fresh setiap hari</p>

<p>🎷 Nuansa Jazz & Vintage Coffee House</p>

<p>⭐ Menggunakan bahan premium</p>

<p>🔥 Disajikan hangat dan berkualitas</p>

<p>📦 Stok tersedia:
<b><?php echo $data['stock']; ?></b></p>

</div>

<form action="addcart.php?id=<?php echo $data['id']; ?>" method="POST">

<label>Jumlah Pesanan</label>

<br><br>

<input
type="number"
name="qty"
value="1"
min="1"
max="<?php echo $data['stock']; ?>"
class="qty">

<div class="action">

<button
type="submit"
class="cart-btn"
style="border:none;cursor:pointer;">

Tambah Keranjang

</button>

<a
href="beli.php?id=<?php echo $data['id']; ?>"
class="buy-btn">

Beli Sekarang

</a>

</div>

</form>

</div>

</div>

</body>
</html>