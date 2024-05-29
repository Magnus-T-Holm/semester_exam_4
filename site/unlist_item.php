<?php
include 'config/session.php';
include 'config/init.php';

$item_id = $_GET['id'];

$item_sql = "SELECT * FROM items WHERE id = $item_id";
$item_data = $db->sql($item_sql);
$item = $item_data[0];
if (!empty($_SESSION['userData'])) {
  if ($_SESSION['userData']['user_id'] != $item->fk_owner) {
    header("location: error.php?error=2");
    exit();
  }
} else {
  header("location: error.php?error=1");
  exit();
}

$sql_statement = "UPDATE items SET status = :status WHERE id = :id";
$sql_data = [
  ":status" => 'Inventory',
  ":id" => $item_id
];
$db->sql($sql_statement, $sql_data, false);
header("Location: update_item.php?id=$item_id");
