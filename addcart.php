<?php
session_start();
include 'koneksi.php';

$id = intval($_GET['id']);

$qty = isset($_POST['qty'])
? intval($_POST['qty'])
: 1;

if($qty < 1){
$qty = 1;
}

$query = mysqli_query(
$conn,
"SELECT * FROM products WHERE id='$id'"
);

$data = mysqli_fetch_assoc($query);

if(!$data){

echo "<script>
alert('Produk tidak ditemukan');
window.location='produk.php';
</script>";

exit;
}

if($data['stock'] < $qty){

echo "<script>
alert('Stok tidak mencukupi');
window.location='detail.php?id=$id';
</script>";

exit;
}

if(!isset($_SESSION['cart'])){
$_SESSION['cart'] = [];
}

$found = false;

foreach($_SESSION['cart'] as &$item){

if($item['id'] == $id){

$jumlahBaru = $item['qty'] + $qty;

if($jumlahBaru > $data['stock']){

echo "<script>
alert('Jumlah melebihi stok yang tersedia');
window.location='detail.php?id=$id';
</script>";
exit;

}

$item['qty'] = $jumlahBaru;

$found = true;
break;

}

}

if(!$found){

$_SESSION['cart'][] = [

"id" => $data['id'],
"nama" => $data['nama_produk'],
"harga" => $data['harga'],
"gambar" => $data['gambar'],
"qty" => $qty

];

}

header("Location: cart.php");
exit;
?>