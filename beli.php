<?php
session_start();
include 'koneksi.php';

$id = intval($_GET['id']);

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

if($data['stock'] <= 0){

echo "<script>
alert('Stok habis');
window.location='produk.php';
</script>";

exit;
}

/*
Kosongkan cart lama
karena fitur Beli Sekarang
*/

$_SESSION['cart'] = [];

$_SESSION['cart'][] = [

"id" => $data['id'],
"nama" => $data['nama_produk'],
"harga" => $data['harga'],
"gambar" => $data['gambar'],
"qty" => 1

];

header("Location: checkout.php");
exit;
?>