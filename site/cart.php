<?php
include 'config/session.php';
include 'config/init.php';

if (empty($_SESSION['userData'])) {
  header("location: error.php?error=1");
  exit();
}

$error_code = "";
if (!empty($_GET['error'])) {
  $error_code = $_GET['error'];
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'components/head.php'; ?>
  <title>Cart</title>
</head>

<body>
  <?php include 'components/header.php';

  if (empty($_SESSION['userData']['cart_item_1']) && empty($_SESSION['userData']['cart_item_2']) && empty($_SESSION['userData']['cart_item_3'])) {
    echo "<main id='shopping_cart'>";
    echo "</main>";
  } else {
    $cart_sql = "SELECT * FROM items WHERE id in (";

    if (!empty($_SESSION['userData']['cart_item_1'])) {
      $cart_1_id = $_SESSION['userData']['cart_item_1'];
      $cart_sql .= "'$cart_1_id', ";
    }
    if (!empty($_SESSION['userData']['cart_item_2'])) {
      $cart_2_id = $_SESSION['userData']['cart_item_2'];
      $cart_sql .= "'$cart_2_id', ";
    }
    if (!empty($_SESSION['userData']['cart_item_3'])) {
      $cart_3_id = $_SESSION['userData']['cart_item_3'];
      $cart_sql .= "'$cart_3_id', ";
    }
    $cart_sql = rtrim($cart_sql, ', ');
    $cart_sql .= ")";

    $cart = $db->sql($cart_sql);

    echo "<main id='shopping_cart'>";
    echo "<h1>Shopping Cart</h1>";
    if ($error_code == '1') {
      echo "<h2 id='cart_full'>Your cart is full, as it can only hold 3 items currently.</h2>";
    }

    echo "<form action='buy_items_in_cart.php' method='post'>";
    foreach ($cart as $item) {
      $item_values = "{";
      $item_values .= "'item_id': '$item->id', ";
      $item_values .= "'item_owner': '$item->fk_owner', ";
      $item_values .= "'item_price': '$item->price'}";
      $item_values = str_replace("'", '"', $item_values);


      echo "<div class='cart_item'>";
      echo "<a id='remove_from_cart' href='/semester_exam_4/site/remove_from_cart.php?id=$item->id'>Remove from cart <i class='fa-solid fa-circle-xmark'></i></a>";
      echo "<div class='item_container'>";
      echo "<div class='item_image_container'>";

      echo "<img loading='lazy' src='https://steamcommunity-a.akamaihd.net/economy/image/$item->image' alt='A picture of $item->item_name' title='A picture of $item->item_name'>";

      // Sticker container - extracts sticker images from a long string of html
      echo "<div class='sticker_container'>";

      echo "</div>";
      echo "</div>";
      echo "<div class='item_container_info_box'>";
      echo "<p style='color: #$item->item_name_color'>$item->item_name</p>";
      if ($item->skin_wear != 'none') {
        echo "<p>$item->skin_wear</p>";
      }
      echo "</div>";
      echo "</div>";
      echo "<div class='price_container'>";
      echo "<p>Price: $$item->price</p>";
      echo "<input readonly hidden name='data[]' value='$item_values'>";
      echo "</div>";

      echo "</div>";
    }
    echo "<button id='buy_button' type='submit'>Buy</button>";
    echo "</form>";
    echo "</main>";
  }
  ?>
  </div>
  </section>

  </main>
  <?php include 'components/footer.php'; ?>
</body>

</html>