<?php

session_start();

include 'koneksi.php';

if(!isset($_SESSION['login'])){
    header("Location:login.php");
    exit;
}

$query = mysqli_query(
$conn,
"SELECT * FROM products"
);

/*
BEST SELLER
berdasarkan 5 checkout terakhir
*/

$bestseller = [];

if(isset($_SESSION['history'])){

$lastFive = array_slice(
array_reverse($_SESSION['history']),
0,
5
);

foreach($lastFive as $trx){

if(!isset($trx['items'])){
continue;
}

foreach($trx['items'] as $it){

if(!isset($bestseller[$it['nama']])){
$bestseller[$it['nama']] = 0;
}

$bestseller[$it['nama']] += $it['qty'];

}

}

}

$bestProduct = "";

if(count($bestseller) > 0){

arsort($bestseller);

$bestProduct = array_key_first($bestseller);

}

?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Menu - TokoKopilot</title>

<link rel="stylesheet" href="style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

.menu-header{
text-align:center;
padding:60px 20px 30px;
}

.menu-header h1{
font-size:60px;
font-family:Georgia,serif;
color:#2C1810;
}

.menu-header p{
margin-top:15px;
font-size:18px;
color:#6d4c41;
}

.stock{
margin-top:10px;
font-weight:bold;
color:#4E342E;
}

.badge{
display:inline-block;
padding:8px 15px;
background:#C8A97E;
color:white;
border-radius:20px;
font-size:12px;
margin-bottom:15px;
}

.btn-group{
display:flex;
gap:10px;
margin-top:20px;
}

.detail-btn{
flex:1;
text-align:center;
padding:12px;
background:#C8A97E;
color:white;
text-decoration:none;
border-radius:10px;
}

.cart-btn{
flex:1;
text-align:center;
padding:12px;
background:#4E342E;
color:white;
text-decoration:none;
border-radius:10px;
}

.buy-btn{
flex:1;
text-align:center;
padding:12px;
background:#2C1810;
color:white;
text-decoration:none;
border-radius:10px;
}

.desc{
margin-top:10px;
color:#555;
line-height:1.7;
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

☕ TokoKopilot

</div>

<div class="nav-right">

<a href="home.php">Home</a>

<a href="produk.php">Menu</a>

<a href="history.php">History</a>

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

<div class="menu-header">

<h1>

Coffee & Bakery Menu

</h1>

<p>

Nikmati kopi premium dan camilan hangat khas TokoKopilot

</p>

</div>

<div class="container">

<?php

while($data=mysqli_fetch_array($query)){

$deskripsi = "";

switch(strtolower($data['nama_produk'])){

case "cappuccino":
$deskripsi="Perpaduan espresso premium dengan foam susu lembut dan aroma yang kaya.";
break;

case "americano":
$deskripsi="Espresso dengan air panas menghasilkan rasa kopi yang kuat dan bersih.";
break;

case "latte":
$deskripsi="Kopi susu creamy dengan tekstur lembut dan rasa seimbang.";
break;

case "espresso":
$deskripsi="Shot kopi murni dengan karakter rasa yang intens.";
break;

case "mocha":
$deskripsi="Perpaduan espresso, susu, dan cokelat premium.";
break;

case "croissant":
$deskripsi="Pastry butter berlapis dengan tekstur renyah di luar dan lembut di dalam.";
break;

case "piscok":
$deskripsi="Pisang cokelat hangat yang manis dan cocok menemani kopi.";
break;

case "cheesecake":
$deskripsi="Kue keju lembut dengan rasa creamy dan premium.";
break;

default:
$deskripsi="Menu spesial TokoKopilot yang dibuat dari bahan berkualitas.";
}

?>

<div class="card">

<img src="<?php echo $data['gambar']; ?>">

<div class="content">

<?php
if(
$bestProduct != "" &&
$data['nama_produk'] == $bestProduct
){
?>
<div class="badge">
🔥 Best Seller
</div>
<?php } ?>

<h3>

<?php echo $data['nama_produk']; ?>

</h3>

<div class="price">

Rp <?php echo number_format($data['harga']); ?>

</div>

<div class="stock">

Stok :
<?php echo $data['stock']; ?>

</div>

<p class="desc">

<?php echo $deskripsi; ?>

</p>

<div class="btn-group">

<a
href="detail.php?id=<?php echo $data['id']; ?>"
class="detail-btn">

Detail

</a>

<a
href="addcart.php?id=<?php echo $data['id']; ?>"
class="cart-btn">

<i class="fa-solid fa-cart-shopping"></i>

</a>

<a
href="beli.php?id=<?php echo $data['id']; ?>"
class="buy-btn">

Beli

</a>

</div>

</div>

</div>

<?php } ?>

</div>

</body>
</html>