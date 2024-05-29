<?php
include 'config/session.php';
include 'config/init.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'components/head.php'; ?>

  <title>Buy</title>
</head>

<body>
  <?php include 'components/header.php'; ?>
  <main id="buy">
    <aside>
      <div id="price">
        <p>Price</p>
        <div>
          <div><label for="price_from">from</label>
            <input type="number" name="price_from" id="price_from">
          </div>
          <div><label for="price_to">to</label>
            <input type="number" name="price_to" id="price_to">
          </div>
        </div>
      </div>
      <div id="search">
        <input type="text" name="skin_search" id="skin_search">
      </div>
      <div id="condition">
        <p>Condition</p>
        <div>
          <input type="checkbox" name="factory_new" id="factory_new">
          <label for="factory_new">Factory new</label>
        </div>
        <div>
          <input type="checkbox" name="minimal_wear" id="minimal_wear">
          <label for="minimal_wear">Minimal Wear</label>
        </div>
        <div>
          <input type="checkbox" name="field-tested" id="field-tested">
          <label for="field-tested">Field-Tested</label>
        </div>
        <div>
          <input type="checkbox" name="well-worn" id="well-worn">
          <label for="well-worn">Well-Worn</label>
        </div>
        <div>
          <input type="checkbox" name="battle-scarred" id="battle-scarred">
          <label for="battle-scarred">Battle-Scarred</label>
        </div>
      </div>
      <div id="extra">
        <p>Extras</p>
        <div>
          <input type="checkbox" name="stat_track" id="stat_track">
          <label for="stat_track">StatTrack™</label>
        </div>
        <div>
          <input type="checkbox" name="souvenir" id="souvenir">
          <label for="souvenir">Souvenir</label>
        </div>
        <div>
          <input type="checkbox" name="sticker" id="sticker">
          <label for="sticker">Sticker</label>
        </div>
        <div>
          <input type="checkbox" name="name_tag" id="name_tag">
          <label for="name_tag">Name Tag</label>
        </div>
        <div>
          <input type="checkbox" name="vanilla" id="vanilla">
          <label for="vanilla">Vanilla</label>
        </div>
      </div>
      <div id="sticker">
        <p>Sticker</p>
        <input type="text" name="search_sticker" id="search_sticker">
      </div>
      <div id="pattern">
        <p>Pattern ID</p>
        <input type="text" name="pattern_id" id="pattern_id">
      </div>
      <div id="fade">
        <p>Fade %</p>
      </div>
    </aside>
    <section>
      <div id="top_bar">
        <p>Counter Strike 2</p>
        <div>
          <label for="sort_by">Sort by</label>
          <select name="sort_by" id="sort_by" onchange="changeSortBuy()">
            <?php
            if (!empty($_GET['sort_by'])) {
              if ($_GET['sort_by'] == "0") {
                echo "<option value='0' selected>Default</option>";
                echo "<option value='1'>Cheapest</option>";
                echo "<option value='2'>Highest discount</option>";
                echo "<option value='3'>Newest</option>";
                echo "<option value='4'>Popular</option>";
                echo "<option value='5'>Lowest Wear</option>";
                echo "<option value='6'>Highest Wear</option>";
              }
              if ($_GET['sort_by'] == "1") {
                echo "<option value='0'>Default</option>";
                echo "<option value='1' selected>Cheapest</option>";
                echo "<option value='2'>Highest discount</option>";
                echo "<option value='3'>Newest</option>";
                echo "<option value='4'>Popular</option>";
                echo "<option value='5'>Lowest Wear</option>";
                echo "<option value='6'>Highest Wear</option>";
              }
              if ($_GET['sort_by'] == "2") {
                echo "<option value='0'>Default</option>";
                echo "<option value='1'>Cheapest</option>";
                echo "<option value='2' selected>Highest discount</option>";
                echo "<option value='3'>Newest</option>";
                echo "<option value='4'>Popular</option>";
                echo "<option value='5'>Lowest Wear</option>";
                echo "<option value='6'>Highest Wear</option>";
              }
              if ($_GET['sort_by'] == "3") {
                echo "<option value='0'>Default</option>";
                echo "<option value='1'>Cheapest</option>";
                echo "<option value='2'>Highest discount</option>";
                echo "<option value='3' selected>Newest</option>";
                echo "<option value='4'>Popular</option>";
                echo "<option value='5'>Lowest Wear</option>";
                echo "<option value='6'>Highest Wear</option>";
              }
              if ($_GET['sort_by'] == "4") {
                echo "<option value='0'>Default</option>";
                echo "<option value='1'>Cheapest</option>";
                echo "<option value='2'>Highest discount</option>";
                echo "<option value='3'>Newest</option>";
                echo "<option value='4' selected>Popular</option>";
                echo "<option value='5'>Lowest Wear</option>";
                echo "<option value='6'>Highest Wear</option>";
              }
              if ($_GET['sort_by'] == "5") {
                echo "<option value='0'>Default</option>";
                echo "<option value='1'>Cheapest</option>";
                echo "<option value='2'>Highest discount</option>";
                echo "<option value='3'>Newest</option>";
                echo "<option value='4'>Popular</option>";
                echo "<option value='5' selected>Lowest Wear</option>";
                echo "<option value='6'>Highest Wear</option>";
              }
              if ($_GET['sort_by'] == "6") {
                echo "<option value='0'>Default</option>";
                echo "<option value='1'>Cheapest</option>";
                echo "<option value='2'>Highest discount</option>";
                echo "<option value='3'>Newest</option>";
                echo "<option value='4'>Popular</option>";
                echo "<option value='5'>Lowest Wear</option>";
                echo "<option value='6' selected>Highest Wear</option>";
              }
            } else {
              echo "<option value='0' selected>Default</option>";
              echo "<option value='1'>Cheapest</option>";
              echo "<option value='2'>Highest discount</option>";
              echo "<option value='3'>Newest</option>";
              echo "<option value='4'>Popular</option>";
              echo "<option value='5'>Lowest Wear</option>";
              echo "<option value='6'>Highest Wear</option>";
            }
            ?>
          </select>
        </div>
      </div>
      <h1>Item market</h1>
      <div id="items_container">
        <?php
        $items_sql = "SELECT * FROM items WHERE NOT price = 0 AND status = 'selling'";
        if (!empty($_SESSION['userData'])) {
          $user_id = $_SESSION['userData']['user_id'];
          $items_sql .= "AND NOT fk_owner = $user_id";
        }

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

        $items = $db->sql($items_sql);

        foreach ($items as $item) {
          echo "<a href='/semester_exam_4/site/item.php?id=$item->id'>";
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