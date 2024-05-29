<?php
include 'config/session.php';
include 'config/init.php';

$item_id = $_GET['id'];

$item_sql = "SELECT * FROM items WHERE id = $item_id";
$item_data = $db->sql($item_sql);
$item = $item_data[0];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'components/head.php';

  echo "<title>$item->item_name</title>";
  ?>
</head>

<body>
  <?php include 'components/header.php'; ?>
  <main id="item">
    <section>
      <?php
      echo "<div id='item_page_container'>";

      echo "<div>";
      echo "<h1>$item->item_name</h1>";
      echo "<div id='image_and_data'>";
      echo "<div id='image'>";
      echo "<img loading='lazy' src='https://steamcommunity-a.akamaihd.net/economy/image/$item->image' alt='A picture of $item->item_name' title='A picture of $item->item_name'>";

      echo "<div id='item_stickers'>";
      if ($item->stickers_1_url != null) {
        echo "<img loading='lazy' class='stickers' src='$item->stickers_1_url' alt=''>";
        if ($item->stickers_2_url != null) {
          echo "<img loading='lazy' class='stickers' src='$item->stickers_2_url' alt=''>";
          if ($item->stickers_3_url != null) {
            echo "<img loading='lazy' class='stickers' src='$item->stickers_3_url' alt=''>";
            if ($item->stickers_4_url != null) {
              echo "<img loading='lazy' class='stickers' src='$item->stickers_4_url' alt=''>";
              if ($item->stickers_5_url != null) {
                echo "<img loading='lazy' class='stickers' src='$item->stickers_5_url' alt=''>";
              }
            }
          }
        }
      }
      echo "</div>";
      echo "</div>";
      echo "<div id='data'>";
      echo "<h2>About</h2>";
      echo "<p>Price: $item->price$</p>";
      if ($item->float_value != null) {
        echo "<p>Float: $item->float_value</p>";
      } else {
        echo "<p>Float: unknown</p>";
      }

      if ($item->paint_seed != null) {
        echo "<p>Paint Seed: $item->paint_seed</p>";
      } else {
        echo "<p>Paint Seed: unknown</p>";
      }
      echo "</div>";
      echo "</div>";
      echo "</div>";
      echo "<div id='similar_and_cart'>";
      echo "<div id='similar'>";
      echo "<div id='similar_items_container'>";
      echo "<h2>Other similar</h2>";

      $similarItems = $db->sql("SELECT * FROM items WHERE NOT price = 0 AND status = 'selling' AND item_type = '$item->item_type' AND item_type = '$item->skin_wear' ORDER BY RAND() LIMIT 3");
      if (!empty($similarItems)) {
        foreach ($similarItems as $similarItem) {
          echo "<div class='item_container'>";
          echo "<div class='item_image_container'>";

          echo "<img loading='lazy' src='https://steamcommunity-a.akamaihd.net/economy/image/$similarItem->image' alt='A picture of $similarItem->item_name' title='A picture of $similarItem->item_name'>";

          // Sticker container - extracts sticker images from a long string of html
          echo "<div class='sticker_container'>";

          echo "</div>";
          echo "</div>";
          echo "<div class='item_container_info_box'>";
          echo "<p style='color: #$similarItem->item_name_color'>$similarItem->item_name</p>";
          if ($similarItem->skin_wear != 'none') {
            echo "<p>$similarItem->skin_wear</p>";
          }
          echo "</div>";
          echo "</div>";
        }
      } else {
        echo "<h3>No similar items were found</h3>";
      }
      echo "</div>";
      echo "</div>";
      echo "<div id='cart_button_area'>";
      echo "<a id='add_to_cart' href='/semester_exam_4/site/add_to_cart.php?id=$item->id'>Add to cart</a>";
      echo "</div>";
      echo "</div>";
      echo "</div>";
      ?>
    </section>
  </main>
  <?php include 'components/footer.php'; ?>
</body>

</html>