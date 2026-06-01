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

/* TAMBAH MENU */
if(isset($_POST['tambah'])){

$nama = mysqli_real_escape_string(
$conn,
$_POST['nama_produk']
);

$harga = $_POST['harga'];

$stock = $_POST['stock'];

$deskripsi = mysqli_real_escape_string(
$conn,
$_POST['deskripsi']
);

$gambar = $_FILES['gambar']['name'];
$tmp = $_FILES['gambar']['tmp_name'];

$path = "assets/image/".time()."_".$gambar;

move_uploaded_file(
$tmp,
$path
);

mysqli_query(
$conn,
"INSERT INTO products
(
nama_produk,
harga,
gambar,
stock,
deskripsi
)
VALUES
(
'$nama',
'$harga',
'$path',
'$stock',
'$deskripsi'
)"
);

echo "
<script>
alert('Menu berhasil ditambahkan ☕');
window.location='admin.php';
</script>
";
exit;
}


/* HAPUS MENU */
if(isset($_GET['hapus'])){

$id = $_GET['hapus'];

mysqli_query(
$conn,
"DELETE FROM products
WHERE id='$id'"
);

echo "
<script>
alert('Menu berhasil dihapus');
window.location='admin.php';
</script>
";
exit;
}

$query = mysqli_query(
$conn,
"SELECT * FROM products
ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Admin Dashboard</title>

<link rel="stylesheet"
href="style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

.admin-wrapper{
max-width:1400px;
margin:auto;
padding:40px;
}

.admin-header{
text-align:center;
margin-bottom:40px;
}

.admin-header h1{
font-size:50px;
font-family:Georgia;
color:#2C1810;
}

.admin-header p{
color:#666;
margin-top:10px;
}

.admin-grid{
display:grid;
grid-template-columns:380px 1fr;
gap:30px;
}

.admin-card{
background:white;
border-radius:25px;
padding:25px;
box-shadow:0 10px 30px rgba(0,0,0,.1);
}

.admin-card h2{
margin-bottom:20px;
font-family:Georgia;
color:#2C1810;
}

.admin-card input,
.admin-card textarea{
width:100%;
padding:14px;
border:1px solid #ddd;
border-radius:12px;
margin-bottom:15px;
font-size:14px;
}

.admin-card textarea{
height:120px;
resize:none;
}

.admin-card button{
width:100%;
padding:15px;
background:#4E342E;
color:white;
border:none;
border-radius:12px;
cursor:pointer;
font-size:15px;
}

.admin-card button:hover{
background:#2C1810;
}

.admin-menu{
display:grid;
grid-template-columns:repeat(4,1fr);
gap:15px;
margin-bottom:25px;
}

.admin-menu a{
background:#fff;
padding:20px;
border-radius:20px;
text-align:center;
text-decoration:none;
color:#2C1810;
box-shadow:0 5px 15px rgba(0,0,0,.08);
transition:.3s;
}

.admin-menu a:hover{
transform:translateY(-5px);
}

.admin-menu i{
font-size:25px;
margin-bottom:10px;
display:block;
}

.table-box{
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
border-bottom:1px solid #eee;
text-align:center;
}

tr:hover{
background:#f9f5ef;
}

.product-img{
width:70px;
height:70px;
object-fit:cover;
border-radius:12px;
}

.btn-edit{
background:#C8A97E;
padding:8px 12px;
border-radius:8px;
text-decoration:none;
color:white;
}

.btn-delete{
background:#C62828;
padding:8px 12px;
border-radius:8px;
text-decoration:none;
color:white;
}

@media(max-width:1000px){

.admin-grid{
grid-template-columns:1fr;
}

.admin-menu{
grid-template-columns:repeat(2,1fr);
}

}

</style>

</head>

<body>

<nav>

<div class="nav-left">

<a href="home.php">

<i class="fa-solid fa-house"></i>

</a>

</div>

<div class="nav-center">

☕ Admin Dashboard

</div>

<div class="nav-right">

<a href="produk.php">
Toko
</a>

<a href="admin_user.php">
User
</a>

<a href="admin_approval.php">
Promote Admin
</a>

<a href="logout.php">
Logout
</a>

</div>

</nav>

<div class="admin-wrapper">

<div class="admin-header">

<h1>

Dashboard Admin

</h1>

<p>

Selamat datang,
<?= $_SESSION['nama']; ?>

</p>

</div>

<div class="admin-menu">

<a href="admin_user.php">

<i class="fa-solid fa-users"></i>

Kelola User

</a>

<a href="admin_approval.php">

<i class="fa-solid fa-user-shield"></i>

Promote Admin

</a>

<a href="admin_pesanan.php">

<i class="fa-solid fa-cart-shopping"></i>

Pesanan

</a>

<a href="admin_laporan.php">

<i class="fa-solid fa-chart-column"></i>

Laporan

</a>

</div>

<div class="admin-grid">

<!-- FORM TAMBAH -->

<div class="admin-card">

<h2>

Tambah Produk

</h2>

<form
method="POST"
enctype="multipart/form-data">

<input
type="text"
name="nama_produk"
placeholder="Nama Produk"
required>

<input
type="number"
name="harga"
placeholder="Harga"
required>

<input
type="number"
name="stock"
placeholder="Stok"
required>

<textarea
name="deskripsi"
placeholder="Deskripsi Produk">
</textarea>

<input
type="file"
name="gambar"
required>

<button
type="submit"
name="tambah">

Tambah Produk ☕

</button>

</form>

</div>

<!-- TABEL -->

<div class="admin-card">

<h2>

Daftar Produk

</h2>

<div class="table-box">

<table>

<tr>

<th>Gambar</th>
<th>Nama</th>
<th>Harga</th>
<th>Stok</th>
<th>Aksi</th>

</tr>

<?php while($d=mysqli_fetch_assoc($query)){ ?>

<tr>

<td>

<img
src="<?= $d['gambar']; ?>"
class="product-img">

</td>

<td>

<?= $d['nama_produk']; ?>

</td>

<td>

Rp <?= number_format($d['harga']); ?>

</td>

<td>

<?= $d['stock']; ?>

</td>

<td>

<a
href="editproduk.php?id=<?= $d['id']; ?>"
class="btn-edit">

Edit

</a>

<a
href="admin.php?hapus=<?= $d['id']; ?>"
onclick="return confirm('Yakin ingin menghapus produk ini?')"
class="btn-delete">

Hapus

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</div>

</div>

</body>
</html>