<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

if(!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0){
    header("Location: produk.php");
    exit;
}

$total = 0;

foreach($_SESSION['cart'] as $item){
    $total += $item['harga'] * $item['qty'];
}

if(isset($_POST['bayar'])){

    $nama   = mysqli_real_escape_string($conn, trim($_POST['nama']));
    $alamat = mysqli_real_escape_string($conn, trim($_POST['alamat']));
    $hp     = mysqli_real_escape_string($conn, trim($_POST['hp']));
    $metode = mysqli_real_escape_string($conn, trim($_POST['metode']));

    if(
        empty($nama) ||
        empty($alamat) ||
        empty($hp) ||
        empty($metode)
    ){

        echo "<script>
        alert('Lengkapi data terlebih dahulu');
        </script>";

    }else{

        $invoice = "INV".date("YmdHis");

        $status = ($metode == "COD")
        ? "Belum Dibayar"
        : "Lunas";

        mysqli_query(
            $conn,
            "INSERT INTO orders
            (
                invoice,
                user_id,
                customer,
                alamat,
                hp,
                metode,
                total,
                status,
                tanggal
            )
            VALUES
            (
                '$invoice',
                '".$_SESSION['user_id']."',
                '$nama',
                '$alamat',
                '$hp',
                '$metode',
                '$total',
                '$status',
                NOW()
            )"
        );

        $order_id = mysqli_insert_id($conn);

        foreach($_SESSION['cart'] as $item){

            mysqli_query(
                $conn,
                "INSERT INTO order_items
                (
                    order_id,
                    produk_id,
                    nama_produk,
                    harga,
                    qty
                )
                VALUES
                (
                    '$order_id',
                    '".$item['id']."',
                    '".$item['nama']."',
                    '".$item['harga']."',
                    '".$item['qty']."'
                )"
            );

            mysqli_query(
                $conn,
                "UPDATE products
                SET stock = stock - ".$item['qty']."
                WHERE id = '".$item['id']."'
            ");
        }

        unset($_SESSION['cart']);

        header("Location: receipt.php?invoice=".$invoice);
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Checkout - TokoKopilot</title>

<link rel="stylesheet" href="style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

.checkout{
max-width:800px;
margin:50px auto;
background:white;
padding:30px;
border-radius:20px;
box-shadow:0 10px 30px rgba(0,0,0,.1);
}

input,
select{
width:100%;
padding:12px;
margin-top:10px;
margin-bottom:15px;
border:1px solid #ddd;
border-radius:10px;
}

button{
width:100%;
padding:15px;
background:#2C1810;
color:white;
border:none;
border-radius:10px;
cursor:pointer;
}

.qris-box{
display:none;
text-align:center;
margin:20px 0;
}

.fake-qris{
width:220px;
height:220px;
margin:auto;
background:
repeating-linear-gradient(
90deg,
black 0px,
black 10px,
white 10px,
white 20px
);
border:10px solid black;
}

.debit-box{
display:none;
}

.total{
font-size:25px;
text-align:center;
margin-bottom:20px;
font-weight:bold;
}

</style>

</head>

<body>

<nav>

<div class="nav-left">

<a href="cart.php">
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

<div class="checkout">

<h1>☕ Checkout</h1>

<div class="total">
Total : Rp <?= number_format($total) ?>
</div>

<form method="POST">

<input
type="text"
name="nama"
placeholder="Nama Lengkap"
required>

<input
type="text"
name="alamat"
placeholder="Alamat"
required>

<input
type="text"
name="hp"
placeholder="No HP"
required>

<select
name="metode"
id="metode"
onchange="ubahMetode()"
required>

<option value="">
Pilih Pembayaran
</option>

<option value="QRIS">
QRIS
</option>

<option value="Debit">
Debit / Kredit
</option>

<option value="COD">
COD
</option>

</select>

<div class="qris-box" id="qris">

<h3>Scan QRIS</h3>

<div class="fake-qris"></div>

<p>QRIS TokoKopilot</p>

</div>

<div class="debit-box" id="debit">

<input type="text" placeholder="Nomor Kartu">

<input type="text" placeholder="Nama Pemilik">

<input type="text" placeholder="MM/YY">

<input type="text" placeholder="CVV">

</div>

<button
type="submit"
name="bayar">

Bayar Sekarang

</button>

</form>

</div>

<script>

function ubahMetode(){

let metode =
document.getElementById("metode").value;

document.getElementById("qris").style.display="none";
document.getElementById("debit").style.display="none";

if(metode=="QRIS"){
document.getElementById("qris").style.display="block";
}

if(metode=="Debit"){
document.getElementById("debit").style.display="block";
}

}

</script>

</body>
</html>