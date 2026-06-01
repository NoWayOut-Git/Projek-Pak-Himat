<?php
include 'koneksi.php';

if(isset($_POST['register'])){

$nama = $_POST['nama'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$cek = mysqli_query($conn,
"SELECT * FROM users WHERE email='$email'"
);

if(mysqli_num_rows($cek) > 0){

echo "<script>
alert('Email sudah digunakan');
window.location='register.php';
</script>";
exit;

}

mysqli_query($conn,
"INSERT INTO users(nama,email,password,role)
VALUES(
'$nama',
'$email',
'$password',
'user'
)"
);

echo "<script>
alert('Register berhasil');
window.location='login.php';
</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<a
href="index.php"
style="
position:absolute;
top:20px;
left:20px;
font-size:25px;
color:#2C1810;
text-decoration:none;
">
←
</a>

<div class="login-container">

<div class="login-box">

<h1>☕ Register</h1>

<form method="POST">

<input
type="text"
name="nama"
placeholder="Nama"
required>

<input
type="email"
name="email"
placeholder="Email"
required>

<input
type="password"
name="password"
placeholder="Password"
required>

<button name="register">
Daftar
</button>

</form>

<p style="text-align:center;margin-top:15px;">
Sudah punya akun?
<a href="login.php">Login</a>
</p>

</div>

</div>

</body>
</html>