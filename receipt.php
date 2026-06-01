<?php
session_start();
include 'koneksi.php';

if(!isset($_GET['invoice'])){
die("Invoice tidak ditemukan");
}

$invoice = mysqli_real_escape_string(
$conn,
$_GET['invoice']
);

$order = mysqli_query(
$conn,
"SELECT *
FROM orders
WHERE invoice='$invoice'
LIMIT 1"
);

$data = mysqli_fetch_assoc($order);

if(!$data){
die("Receipt tidak ditemukan");
}

$items = mysqli_query(
$conn,
"SELECT *
FROM order_items
WHERE order_id='".$data['id']."'"
);
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Receipt - TokoKopilot</title>

<link rel="stylesheet" href="style.css">

<style>

.receipt{
max-width:700px;
margin:50px auto;
background:white;
padding:30px;
border-radius:20px;
box-shadow:0 10px 30px rgba(0,0,0,.1);
}

.center{
text-align:center;
}

.center h2{
margin:0;
color:#2C1810;
font-family:Georgia;
}

.center p{
color:#777;
margin-top:5px;
}

.line{
border-top:2px dashed #ccc;
margin:20px 0;
}

.info{
line-height:2;
color:#333;
}

.items{
margin-top:20px;
}

.item{
display:flex;
justify-content:space-between;
padding:12px 0;
border-bottom:1px solid #eee;
}

.total{
margin-top:25px;
text-align:right;
font-size:24px;
font-weight:bold;
color:#2C1810;
}

.status{
display:inline-block;
padding:8px 15px;
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
display:block;
text-align:center;
margin-top:30px;
padding:15px;
background:#2C1810;
color:white;
text-decoration:none;
border-radius:10px;
font-weight:bold;
}

.btn:hover{
opacity:.9;
}

</style>

</head>

<body>

<nav>

<div class="nav-left">

<a href="history.php">
←
</a>

</div>

<div class="nav-center">
☕ Receipt
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

</div>

</nav>

<div class="receipt">

<div class="center">

<h2>
☕ TOKOKOPILOT
</h2>

<p>
Receipt Pembayaran
</p>

</div>

<div class="line"></div>

<div class="info">

<b>Invoice :</b>
<?= $data['invoice']; ?>

<br>

<b>Tanggal :</b>
<?= $data['tanggal']; ?>

<br>

<b>Nama :</b>
<?= $data['customer']; ?>

<br>

<b>Alamat :</b>
<?= $data['alamat']; ?>

<br>

<b>No HP :</b>
<?= $data['hp']; ?>

<br>

<b>Metode :</b>
<?= $data['metode']; ?>

<br>

<b>Status :</b>

<?php if($data['status']=="Lunas"){ ?>

<span class="status lunas">
<?= $data['status']; ?>
</span>

<?php } else { ?>

<span class="status cod">
<?= $data['status']; ?>
</span>

<?php } ?>

</div>

<div class="line"></div>

<h3>Detail Pesanan</h3>

<div class="items">

<?php while($item = mysqli_fetch_assoc($items)){ ?>

<div class="item">

<div>

<?= $item['qty']; ?>
x
<?= $item['nama_produk']; ?>

</div>

<div>

Rp
<?= number_format(
$item['harga'] * $item['qty']
); ?>

</div>

</div>

<?php } ?>

</div>

<div class="total">

Total :
Rp <?= number_format($data['total']); ?>

</div>

<a
href="home.php"
class="btn">

🏠 Kembali ke Home

</a>

</div>

</body>
</html>