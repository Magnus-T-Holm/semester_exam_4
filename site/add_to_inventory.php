<?php
include 'config/session.php';
include 'config/init.php';


if (!empty($_POST['data'])) {
  $selected_options = $_POST['data'];
  foreach ($selected_options as $option) {
    $data = json_decode($option, true);
    if (json_last_error() === JSON_ERROR_NONE) {
      $sql_1 = "INSERT INTO items (item_name, item_name_color, item_type, fk_owner, image, status";
      $sql_2 = "VALUES(:item_name, :item_name_color, :item_type, :fk_owner, :image, :status";
      $sql_data = [
        ":item_name" => $data['item_name'],
        ":item_name_color" => $data['item_name_color'],
        ":item_type" => $data['item_type'],
        ":fk_owner" => $_SESSION['userData']['user_id'],
        ":item_type" => $data['item_type'],
        ":image" => $data['image'],
        ":status" => 'Inventory'
      ];
      if (!empty($data['skin_wear'])) {
        $sql_1 .= ", skin_wear";
        $sql_2 .= ", :skin_wear";
        $sql_data[":skin_wear"] = $data['skin_wear'];
      }

      if (!empty($data['has_stat_track'])) {
        $sql_1 .= ", has_stat_track";
        $sql_2 .= ", :has_stat_track";
        $sql_data[":has_stat_track"] = $data['has_stat_track'];
      }

      if (!empty($data['has_sticker'])) {
        $sql_1 .= ", has_sticker";
        $sql_2 .= ", :has_sticker";
        $sql_data[":has_sticker"] = $data['has_sticker'];
      }

      if (!empty($data['stickers_1_url'])) {
        $sql_1 .= ", stickers_1_url";
        $sql_2 .= ", :stickers_1_url";
        $sql_data[":stickers_1_url"] = $data['stickers_1_url'];
      }
      if (!empty($data['stickers_2_url'])) {
        $sql_1 .= ", stickers_2_url";
        $sql_2 .= ", :stickers_2_url";
        $sql_data[":stickers_2_url"] = $data['stickers_2_url'];
      }
      if (!empty($data['stickers_3_url'])) {
        $sql_1 .= ", stickers_3_url";
        $sql_2 .= ", :stickers_3_url";
        $sql_data[":stickers_3_url"] = $data['stickers_3_url'];
      }
      if (!empty($data['stickers_4_url'])) {
        $sql_1 .= ", stickers_4_url";
        $sql_2 .= ", :stickers_4_url";
        $sql_data[":stickers_4_url"] = $data['stickers_4_url'];
      }
      if (!empty($data['stickers_5_url'])) {
        $sql_1 .= ", stickers_5_url";
        $sql_2 .= ", :stickers_5_url";
        $sql_data[":stickers_5_url"] = $data['stickers_5_url'];
      }

      $sql_1 .= ")";
      $sql_2 .= ")";

      $sql_insert = $sql_1 . ' ' . $sql_2;
      $db->sql($sql_insert, $sql_data, false);
    }
  }
  header('Location: sell.php');
}
header('Location: sell.php');
