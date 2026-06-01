<?php

session_start();
include 'koneksi.php';

if($_SESSION['role']!="admin"){
header("Location:home.php");
exit;
}

$id=$_GET['id'];

$query=mysqli_query(
$conn,
"SELECT * FROM products
WHERE id='$id'"
);

$data=mysqli_fetch_assoc($query);


if(isset($_POST['update'])){

$nama=$_POST['nama_produk'];

$harga=$_POST['harga'];

$stock=$_POST['stock'];

$deskripsi=$_POST['deskripsi'];

mysqli_query(

$conn,

"UPDATE products
SET

nama_produk='$nama',
harga='$harga',
stock='$stock',
deskripsi='$deskripsi'

WHERE id='$id'"

);

header("Location:admin.php");

}

?>

<!DOCTYPE html>

<html>

<head>

<title>Edit Produk</title>

<link rel="stylesheet"
href="style.css">

</head>

<body>

<div class="login-container">

<div class="login-box">

<h1>

Edit Menu Kopi

</h1>

<form method="POST">

<input
type="text"
name="nama_produk"
value="<?php echo $data['nama_produk'];?>">

<input
type="number"
name="harga"
value="<?php echo $data['harga'];?>">

<input
type="number"
name="stock"
value="<?php echo $data['stock'];?>">

<textarea
name="deskripsi"
style="
width:100%;
padding:15px;
margin-top:15px;
">

<?php
echo $data['deskripsi'];
?>

</textarea>

<button
name="update">

Update

</button>

</form>

</div>

</div>

</body>

</html>