<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['login'])){
    header("Location:login.php");
    exit;
}

if($_SESSION['role'] != "admin"){
    header("Location:home.php");
    exit;
}

/* TOTAL PENDAPATAN */
$qPendapatan = mysqli_query(
    $conn,
    "SELECT SUM(total) AS total FROM orders"
);

$dPendapatan = mysqli_fetch_assoc($qPendapatan);

$totalPendapatan = $dPendapatan['total'] ?? 0;


/* TOTAL TRANSAKSI */
$qTransaksi = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM orders"
);

$dTransaksi = mysqli_fetch_assoc($qTransaksi);

$totalTransaksi = $dTransaksi['total'];


/* TOTAL ITEM TERJUAL */
$qItem = mysqli_query(
    $conn,
    "SELECT SUM(qty) AS total
     FROM order_items"
);

$dItem = mysqli_fetch_assoc($qItem);

$totalItem = $dItem['total'] ?? 0;


/* DETAIL TRANSAKSI */
$query = mysqli_query(
    $conn,
    "SELECT
        o.invoice,
        o.customer,
        o.metode,
        o.total,
        o.tanggal
     FROM orders o
     ORDER BY o.id DESC"
);
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Laporan Penjualan</title>

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

.stats{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
gap:20px;
margin-bottom:40px;
}

.card-stat{
background:#fffaf4;
border:1px solid #d8c3a5;
border-radius:20px;
padding:25px;
text-align:center;
box-shadow:0 10px 25px rgba(0,0,0,.1);
}

.card-stat h2{
color:#4E342E;
font-size:30px;
margin-bottom:10px;
}

.card-stat p{
color:#6d4c41;
}

.table-box{
background:white;
padding:25px;
border-radius:20px;
box-shadow:0 10px 30px rgba(0,0,0,.1);
overflow-x:auto;
}

table{
width:100%;
border-collapse:collapse;
}

th{
background:#2C1810;
color:white;
padding:14px;
}

td{
padding:14px;
text-align:center;
border-bottom:1px solid #eee;
}

tr:hover{
background:#f9f5ef;
}

.empty{
text-align:center;
padding:80px;
color:#666;
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

☕ Laporan Penjualan

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

<h1>

Dashboard Laporan

</h1>

</div>

<div class="stats">

<div class="card-stat">

<h2>

Rp <?= number_format($totalPendapatan) ?>

</h2>

<p>

Total Pendapatan

</p>

</div>

<div class="card-stat">

<h2>

<?= $totalTransaksi ?>

</h2>

<p>

Total Transaksi

</p>

</div>

<div class="card-stat">

<h2>

<?= $totalItem ?>

</h2>

<p>

Total Item Terjual

</p>

</div>

</div>

<div class="table-box">

<h2 style="margin-bottom:20px;">

Detail Transaksi

</h2>

<?php if(mysqli_num_rows($query) > 0){ ?>

<table>

<tr>

<th>Invoice</th>
<th>Pelanggan</th>
<th>Metode</th>
<th>Total</th>
<th>Tanggal</th>

</tr>

<?php while($row = mysqli_fetch_assoc($query)){ ?>

<tr>

<td>

<?= $row['invoice'] ?>

</td>

<td>

<?= $row['customer'] ?>

</td>

<td>

<?= $row['metode'] ?>

</td>

<td>

Rp <?= number_format($row['total']) ?>

</td>

<td>

<?= $row['tanggal'] ?>

</td>

</tr>

<?php } ?>

</table>

<?php } else { ?>

<div class="empty">

<h2>

Belum ada transaksi ☕

</h2>

<p>

Transaksi checkout akan muncul di sini

</p>

</div>

<?php } ?>

</div>

</div>

</body>
</html>