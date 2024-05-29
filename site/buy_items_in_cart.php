<?php
include 'config/session.php';
include 'config/init.php';

$user_id = $_SESSION['userData']['user_id'];

if (!empty($_POST['data'])) {
  $items = $_POST['data'];

  $item_1 = null;
  $item_2 = null;
  $item_3 = null;

  $full_price = 0;

  if (count($items) > 0) {
    $item_1 = json_decode($items[0], true);
    $full_price += (float)$item_1["item_price"];
  }
  if (count($items) > 1) {
    $item_2 = json_decode($items[1], true);
    $full_price += (float)$item_2["item_price"];
  }
  if (count($items) > 2) {
    $item_3 = json_decode($items[2], true);
    $full_price += (float)$item_3["item_price"];
  }

  $user_sql = "SELECT balance FROM users WHERE id = :user_id";
  $user_data = [":user_id" => $user_id];
  $user_balance = $db->sql($user_sql, $user_data, true);

  if ($user_balance[0]->balance >= $full_price) {

    $sql_1 = "INSERT INTO sales_history (fk_buyer, fk_seller_1, fk_item_1, item_1_price";
    $sql_2 = "VALUES(:fk_buyer, :fk_seller_1, :fk_item_1, :item_1_price";
    $sql_data = [
      ":fk_buyer" => $user_id,
      ":fk_seller_1" => $item_1["item_owner"],
      ":fk_item_1" => $item_1["item_id"],
      ":item_1_price" => $item_1["item_price"]
    ];
    if (count($items) == 2) {
      $sql_1 .= ", fk_seller_2, fk_item_2, item_2_price)";
      $sql_2 .= ", :fk_seller_2, :fk_item_2, :item_2_price)";
      $sql_data[":fk_seller_2"] = $item_2["item_owner"];
      $sql_data[":fk_item_2"] = $item_2["item_id"];
      $sql_data[":item_2_price"] = $item_2["item_price"];
    } else if (count($items) == 3) {
      $sql_1 .= ", fk_seller_2, fk_item_2, item_2_price, fk_seller_3, fk_item_3, item_3_price)";
      $sql_2 .= ", :fk_seller_2, :fk_item_2, :item_2_price, :fk_seller_3, :fk_item_3, :item_3_price)";
      $sql_data[":fk_seller_2"] = $item_2["item_owner"];
      $sql_data[":fk_item_2"] = $item_2["item_id"];
      $sql_data[":item_2_price"] = $item_2["item_price"];
      $sql_data[":fk_seller_3"] = $item_3["item_owner"];
      $sql_data[":fk_item_3"] = $item_3["item_id"];
      $sql_data[":item_3_price"] = $item_3["item_price"];
    } else {
      $sql_1 .= ")";
      $sql_2 .= ")";
    }

    $sql_insert = $sql_1 . ' ' . $sql_2;

    $db->sql($sql_insert, $sql_data, false);


    foreach ($items as $item) {
      $item_data = json_decode($item, true);
      $sql_update_seller_balance = "UPDATE users SET balance = balance + :price WHERE id = :item_owner";
      $sql_data_seller_balance = [
        ":item_owner" => $item_data["item_owner"],
        ":price" => (float)$item_data["item_price"]
      ];
      $db->sql($sql_update_seller_balance, $sql_data_seller_balance, false);

      $sql_update_item = "UPDATE items SET fk_owner = :user_id, status = :status WHERE id = :item_id";
      $sql_data_item = [
        ":user_id" => $user_id,
        ":status" => 'Inventory',
        ":item_id" => $item_data["item_id"]
      ];
      $db->sql($sql_update_item, $sql_data_item, false);
    }

    $sql_update_user = "UPDATE users SET balance = balance - :payment WHERE id = :id";
    $sql_data_user = [
      ":payment" => $full_price,
      ":id" => $user_id
    ];
    $db->sql($sql_update_user, $sql_data_user, false);

    unset($_SESSION['userData']['cart_item_1']);
    unset($_SESSION['userData']['cart_item_2']);
    unset($_SESSION['userData']['cart_item_3']);

    header('Location: inventory.php');
  } else {
    header('Location: cart.php?error=2');
  }
} else {
  header('Location: error.php?error=4');
}
