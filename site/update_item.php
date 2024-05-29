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


if (!empty($_POST['data'])) {
  $data = $_POST['data'];

  $sql_statement = "UPDATE items SET price = CAST(:price AS FLOAT), status = :status WHERE id = :id";
  $sql_data = [
    ":price" => $data['price'],
    ":status" => 'Selling',
    ":id" => $item_id
  ];
  $db->sql($sql_statement, $sql_data, false);
  header("Location: update_item.php?id=$item_id");
}

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
      echo "<div id='item_update_page_container'>";

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
      echo "<p>Status: $item->status</p>";

      echo "</div>";
      echo "</div>";
      echo "</div>";
      echo "<form id='update_price' action='update_item.php?id=$item_id' method='post'>";
      echo "<div>";

      echo "<h2>Set selling price</h2>";

      echo "<div>";
      echo "<label for='update_price_input'>Item price:</label>";
      echo "<input type='number' step='0.01' id='update_price_input' name='data[price]' value='$item->price'>";
      echo "</div>";

      echo "</div>";

      echo "<button id='update_item' type='submit'>List item</button>";
      echo "<a href='/semester_exam_4/site/unlist_item.php?id=$item->id'>Return item to inventory</a>";

      echo "</form>";
      echo "</div>";
      ?>
    </section>
  </main>
  <?php include 'components/footer.php'; ?>
</body>

</html>