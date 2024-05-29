<?php
include 'config/session.php';
include 'config/init.php';

if (empty($_SESSION['userData'])) {
  header("location: error.php?error=1");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'components/head.php';
  $user_name = $_SESSION['userData']['name'];
  echo "<title>$user_name's SkinsMart Inventory</title>";
  ?>
</head>

<body>
  <?php include 'components/header.php'; ?>
  <main id="skinsmart_inventory">
    <aside>
      <div id="search">
        <input type="text" name="skin_search" id="skin_search">
      </div>
      <div id="category">
        <p>Category</p>
        <div>
          <input type="checkbox" name="pistol" id="pistol">
          <label for="pistol">Pistol</label>
        </div>
        <div>
          <input type="checkbox" name="heavy" id="heavy">
          <label for="heavy">Heavy</label>
        </div>
        <div>
          <input type="checkbox" name="SMG" id="SMG">
          <label for="SMG">SMG</label>
        </div>
        <div>
          <input type="checkbox" name=rifle id=rifle>
          <label for=rifle>Rifle</label>
        </div>
        <div>
          <input type="checkbox" name="knife" id="knife">
          <label for="knife">Knife</label>
        </div>
        <div>
          <input type="checkbox" name="gloves" id="gloves">
          <label for="gloves">Gloves</label>
        </div>
        <div>
          <input type="checkbox" name="agent" id="agent">
          <label for="agent">Agent</label>
        </div>
        <div>
          <input type="checkbox" name="music_kit" id="music_kit">
          <label for="music_kit">Music Kit</label>
        </div>
        <div>
          <input type="checkbox" name="grafitti" id="grafitti">
          <label for="grafitti">Grafitti</label>
        </div>
        <div>
          <input type="checkbox" name="sticker" id="sticker">
          <label for="sticker">Sticker</label>
        </div>
      </div>
    </aside>
    <section>
      <div id="top_bar">
        <p>Counter Strike 2</p>
        <div>
          <a href="/semester_exam_4/site/sell.php">Steam inventory <i class="fa-solid fa-caret-right"></i></a>
        </div>
      </div>
      <h1>SkinsMart Inventory</h1>
      <div id="items_container">
        <?php
        $items_sql = "SELECT * FROM items WHERE fk_owner = :fk_owner";

        if (!empty($_GET['sort_by'])) {
          if ($_GET['sort_by'] == "1") {
            $items_sql .= " ORDER BY price";
          }
          // if ($_GET['sort_by'] == "2") {
          //   $items_sql .= " ORDER BY ";
          // }
          if ($_GET['sort_by'] == "3") {
            $items_sql .= " ORDER BY id DESC";
          }
          // if ($_GET['sort_by'] == "4") {
          //   $items_sql .= " ORDER BY ";
          // }
          if ($_GET['sort_by'] == "5") {
            $items_sql .= " ORDER BY FIELD(skin_wear, 'Battle-Scarred', 'Well-Worn', 'Field-Tested', 'Minimal Wear', 'Factory New', 'none')";
          }
          if ($_GET['sort_by'] == "6") {
            $items_sql .= " ORDER BY FIELD(skin_wear, 'Factory New', 'Minimal Wear', 'Field-Tested', 'Well-Worn', 'Battle-Scarred', 'none')";
          }
        }

        $user_id = $_SESSION['userData']['user_id'];
        $sql_data = [
          ":fk_owner" => $user_id
        ];
        $items = $db->sql($items_sql, $sql_data, true);

        foreach ($items as $item) {
          echo "<a href='/semester_exam_4/site/update_item.php?id=$item->id'>";
          echo "<div class='item_container'>";
          echo "<div class='item_image_container'>";

          echo "<img loading='lazy' src='https://steamcommunity-a.akamaihd.net/economy/image/$item->image' alt='A picture of $item->item_name' title='A picture of $item->item_name'>";

          echo "<div class='sticker_container'>";
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
          echo "<div class='item_container_info_box'>";
          echo "<p style='color: #$item->item_name_color'>$item->item_name</p>";
          if ($item->skin_wear != 'none') {
            echo "<p>$item->skin_wear</p>";
          }
          echo "<p class='item_price'>$item->price$</p>";
          echo "</div>";
          echo "</div>";
          echo "</a>";
        }
        ?>
      </div>
    </section>
  </main>
  <?php include 'components/footer.php'; ?>
  <script src="js/script.js"></script>
</body>

</html>