<?php

session_start();

if(
isset($_GET['id']) &&
isset($_SESSION['cart'])
){

$id = intval($_GET['id']);

foreach($_SESSION['cart'] as $key => $item){

if($item['id'] == $id){

unset($_SESSION['cart'][$key]);

break;

}

}

$_SESSION['cart'] =
array_values($_SESSION['cart']);

}

header("Location: cart.php");
exit;