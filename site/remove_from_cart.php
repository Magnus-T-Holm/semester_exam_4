<?php
include 'config/session.php';
include 'config/init.php';

$item_id = $_GET['id'];

$item_sql = "SELECT * FROM items WHERE id = $item_id";
$item_data = $db->sql($item_sql);
$item = $item_data[0];
if (!empty($_SESSION['userData'])) {
  if (!empty($_SESSION['userData']['cart_item_1']) && $_SESSION['userData']['cart_item_1'] == $item_id) {
    unset($_SESSION['userData']['cart_item_1']);
    header("Location: cart.php");
  } elseif (!empty($_SESSION['userData']['cart_item_2']) && $_SESSION['userData']['cart_item_2'] == $item_id) {
    unset($_SESSION['userData']['cart_item_2']);
    header("Location: cart.php");
  } elseif (!empty($_SESSION['userData']['cart_item_3']) && $_SESSION['userData']['cart_item_3'] == $item_id) {
    unset($_SESSION['userData']['cart_item_3']);
    header("Location: cart.php");
  } else {
    header("Location: cart.php");
  }
} else {
  header("location: error.php?error=1");
  exit();
}
