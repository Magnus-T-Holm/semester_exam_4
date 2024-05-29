<?php
include 'config/session.php';
include 'config/init.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'components/head.php'; ?>
  <title>Frontpage</title>
</head>

<body>
  <?php include 'components/header.php'; ?>
  <main>
    <section id="top_banner">
      <div>
        <p>Buy, Sell and Trade skins now on <br> Skinsmart Fees down to 0%!</p>
        <p>Join us now!</p>
      </div>
    </section>
    <section id="new_deals_section">
      <h2>New Deals</h2>
      <div id="new_deals_container">
        <?php
        $newItems = $db->sql("SELECT * FROM items WHERE NOT price = 0 AND status = 'selling' ORDER BY id DESC LIMIT 8");

        foreach ($newItems as $item) {
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
    <section id="partner_program_section">
      <h2>Partner Program</h2>
      <div id="partner_program_container">
        <div>
          <p>Sell unlimited skins for a 0% fee for only 6.7€ a month!</p>
          <p>Level up your account by using Skinsmart and earn rewards.</p>
          <p>Read more about the benefits and alternatives of our partner program <a href="#">here.</a></p>
        </div>
        <i class="fa-solid fa-handshake-simple"></i>
      </div>
    </section>
    <section id="trading_forum_section">
      <h2>Trading Forum</h2>
      <div>
        <p>People are interested in your skins!</p>
        <p>Come in contact with them through our Trading Forum and see what deals you can make with them!</p>
      </div>
      <div id="trading_forum_items_container">
        <?php
        $newItems = $db->sql("SELECT * FROM items WHERE NOT price = 0 AND status = 'selling' ORDER BY id DESC LIMIT 8");

        foreach ($newItems as $item) {
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
      <div>
        <p>Multiple features are usable in our Trading Forum go check it out right <a href="/semester_exam_4/site/trade.php">now!</a></p>
      </div>
    </section>
  </main>
  <?php include 'components/footer.php'; ?>
</body>

</html>