<?php
include 'config/session.php';
include 'config/init.php';

$item_id = $_GET['id'];

$item_sql = "SELECT * FROM items WHERE id = $item_id";
$item_data = $db->sql($item_sql);
$item = $item_data[0];
if (!empty($_SESSION['userData'])) {
  if ($item->status == "Selling") {
    if ($item->fk_owner != $_SESSION['userData']['user_id']) {
      if (empty($_SESSION['userData']['cart_item_1'])) {
        $_SESSION['userData']['cart_item_1'] = $item->id;
        header("Location: cart.php");
      } elseif (empty($_SESSION['userData']['cart_item_2'])) {
        $_SESSION['userData']['cart_item_2'] = $item->id;
        header("Location: cart.php");
      } elseif (empty($_SESSION['userData']['cart_item_3'])) {
        $_SESSION['userData']['cart_item_3'] = $item->id;
        header("Location: cart.php");
      } else {
        header("Location: cart.php?error=1");
      }
    } else {
      header("location: error.php?error=69");
      exit();
    }
  } else {
    header("location: error.php?error=3");
    exit();
  }
} else {
  header("location: error.php?error=1");
  exit();
}
