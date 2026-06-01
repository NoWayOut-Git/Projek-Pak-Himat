<?php
session_start();
include 'koneksi.php';

$error = "";

if(isset($_POST['login'])){

$email = $_POST['email'];
$password = $_POST['password'];

$query = mysqli_query(
$conn,
"SELECT * FROM users WHERE email='$email'"
);

$data = mysqli_fetch_assoc($query);

if($data){

if(password_verify($password,$data['password'])){

$_SESSION['login']=true;
$_SESSION['nama']=$data['nama'];
$_SESSION['role']=$data['role'];
$_SESSION['user_id']=$data['id'];

if($data['role']=="admin"){
header("Location:admin.php");
}else{
header("Location:home.php");
}

exit;

}else{
$error="Password salah";
}

}else{
$error="Email tidak ditemukan";
}

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login - TokoKopilot</title>

<link rel="stylesheet" href="style.css">

<style>

/* tambahan biar lebih clean */
.login-box h1{
font-family:Georgia;
color:#2C1810;
}

</style>

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

<h1>☕ TokoKopilot Login</h1>

<?php if($error != ""){ ?>
<div class="error">
<?= $error ?>
</div>
<?php } ?>

<form method="POST">

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

<button type="submit" name="login">
Masuk ☕
</button>

</form>

<p style="text-align:center;margin-top:15px;">
Belum punya akun?
<a href="register.php">Register</a>
</p>

</div>

</div>

</body>
</html>