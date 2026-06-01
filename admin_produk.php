<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['login'])){
header("Location:login.php");
exit;
}

if($_SESSION['role']!="admin"){
header("Location:home.php");
exit;
}


/* UPDATE PRODUK */
if(isset($_POST['update'])){

$id = $_POST['id'];
$nama = $_POST['nama_produk'];
$harga = $_POST['harga'];
$stock = $_POST['stock'];
$deskripsi = $_POST['deskripsi'];

if($_FILES['gambar']['name'] != ""){

$gambar = $_FILES['gambar']['name'];
$tmp = $_FILES['gambar']['tmp_name'];

$path = "assets/image/".time()."_".$gambar;
move_uploaded_file($tmp,$path);

mysqli_query($conn,
"UPDATE products SET
nama_produk='$nama',
harga='$harga',
stock='$stock',
deskripsi='$deskripsi',
gambar='$path'
WHERE id='$id'"
);

}else{

mysqli_query($conn,
"UPDATE products SET
nama_produk='$nama',
harga='$harga',
stock='$stock',
deskripsi='$deskripsi'
WHERE id='$id'"
);

}

echo "<script>
alert('Produk berhasil diupdate ☕');
window.location='admin_produk.php';
</script>";

}


/* AMBIL DATA */
$query = mysqli_query($conn,"SELECT * FROM products");

?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Produk - TokoKopilot</title>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

.wrapper{
padding:50px;
max-width:1200px;
margin:auto;
}

.title-box{
text-align:center;
margin-bottom:40px;
}

.title-box h1{
font-family:Georgia;
font-size:45px;
color:#2C1810;
}

.grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
gap:25px;
}

/* CARD */
.card-edit{
background:#fffaf4;
border:1px solid #d8c3a5;
border-radius:20px;
box-shadow:0 10px 30px rgba(0,0,0,.1);
overflow:hidden;
transition:.3s;
}

.card-edit:hover{
transform:translateY(-5px);
}

.card-edit img{
width:100%;
height:200px;
object-fit:cover;
}

.card-body{
padding:20px;
}

.card-body input,
.card-body textarea{
width:100%;
padding:10px;
margin-bottom:10px;
border:1px solid #ddd;
border-radius:10px;
}

.card-body button{
width:100%;
padding:12px;
background:#4E342E;
color:white;
border:none;
border-radius:10px;
cursor:pointer;
transition:.3s;
}

.card-body button:hover{
background:#2C1810;
}

.label{
font-size:12px;
color:#777;
margin-bottom:5px;
display:block;
}

</style>

</head>

<body>

<!-- NAV -->
<nav>

<div class="nav-left">
<a href="admin.php">
<i class="fa-solid fa-arrow-left"></i>
</a>
</div>

<div class="nav-center">
☕ Manage Produk
</div>

<div class="nav-right">

<a href="home.php">Home</a>
<a href="logout.php">Logout</a>

</div>

</nav>


<div class="wrapper">

<div class="title-box">
<h1>Edit Produk Coffee Shop</h1>
</div>

<div class="grid">

<?php while($d=mysqli_fetch_array($query)){ ?>

<div class="card-edit">

<img src="<?= $d['gambar'] ?>">

<div class="card-body">

<form method="POST" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?= $d['id'] ?>">

<label class="label">Nama Produk</label>
<input type="text" name="nama_produk" value="<?= $d['nama_produk'] ?>" required>

<label class="label">Harga</label>
<input type="number" name="harga" value="<?= $d['harga'] ?>" required>

<label class="label">Stock</label>
<input type="number" name="stock" value="<?= $d['stock'] ?>" required>

<label class="label">Deskripsi</label>
<textarea name="deskripsi"><?= $d['deskripsi'] ?></textarea>

<label class="label">Ganti Gambar (opsional)</label>
<input type="file" name="gambar">

<button name="update">
Update Produk ☕
</button>

</form>

</div>

</div>

<?php } ?>

</div>

</div>

</body>
</html>