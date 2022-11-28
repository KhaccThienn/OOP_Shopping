<?php
session_start();
include "Database.php";
$db = new Database();

$conn = $db->connectToDB();

include 'Cart.php';
$cart = new Cart;

$id = !empty($_GET['id']) ? $_GET['id'] : 0;
$action = !empty($_GET['action']) ? $_GET['action'] : 'add'; // add, delete, update, clear
$quantity = !empty($_GET['quantity']) ? $_GET['quantity'] : 1; // add, delete, update, clear
$quantity = $quantity > 0 ? ceil($quantity) : 1;

$carts = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

if ($action == 'add') {

  $sql = "SELECT * FROM product WHERE id = $id";

  $query = mysqli_query($conn, $sql);

  if (mysqli_num_rows($query) == 1) {
    $pro = mysqli_fetch_assoc($query);
    $cart->add($pro);
  }
}

if ($action == 'delete') {
  $cart->remove($id);
}

if ($action == 'update') {
  $cart->update($id, $quantity);
}

if ($action == 'clear') {
  $cart->clear();
}


header('location: view-cart.php');
