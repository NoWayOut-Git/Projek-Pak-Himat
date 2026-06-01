<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>TokoKopilot - Vintage Coffee House</title>

<link rel="stylesheet" href="style.css">

<style>

/* LANDING PAGE EXTRA STYLE */
.landing{
min-height:100vh;
display:flex;
align-items:center;
justify-content:center;
flex-direction:column;
text-align:center;
padding:60px;
background:
linear-gradient(rgba(44,24,16,.7),rgba(44,24,16,.7)),
url('assets/image/kopi.jpg');
background-size:cover;
background-position:center;
color:white;
}

.landing h1{
font-size:70px;
font-family:Georgia;
margin-bottom:20px;
}

.landing h1 span{
color:#C8A97E;
}

.landing p{
max-width:600px;
font-size:18px;
line-height:2;
color:#f5eee6;
margin-bottom:40px;
}

.btn-group{
display:flex;
gap:20px;
}

.btn{
padding:15px 35px;
border-radius:50px;
text-decoration:none;
font-weight:bold;
transition:.3s;
}

.login-btn{
background:#C8A97E;
color:#2C1810;
}

.login-btn:hover{
background:#fff;
}

.register-btn{
border:2px solid #C8A97E;
color:#C8A97E;
}

.register-btn:hover{
background:#C8A97E;
color:#2C1810;
}

.footer-text{
margin-top:50px;
font-size:13px;
opacity:.7;
}

</style>

</head>

<body>

<div class="landing">

<h1>
☕ TokoKopilot
<br>
<span>Vintage Coffee Experience</span>
</h1>

<p>
Selamat datang di TokoKopilot — tempat di mana aroma kopi
bertemu dengan nuansa jazz klasik dan suasana hangat
ala coffee house vintage.
</p>

<div class="btn-group">

<a href="login.php" class="btn login-btn">
Login
</a>

<a href="register.php" class="btn register-btn">
Register
</a>

</div>

<div class="footer-text">
© 2026 TokoKopilot • Crafted with ☕ & Jazz
</div>

</div>

</body>
</html>