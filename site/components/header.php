<header>
  <a href="/semester_exam_4/site/index.php">
    <img loading='lazy' id="logo_full_version" src="./img/logo_white.png" alt="">
  </a>
  <div>
    <nav>
      <a id="buy_link" href="/semester_exam_4/site/buy.php">Buy</a>
      <a id="sell_link" href="/semester_exam_4/site/sell.php">Sell</a>
      <a id="trade_link" href="/semester_exam_4/site/trade.php">Trade</a>
      <a id="cart" href="/semester_exam_4/site/cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
    </nav>
    <?php

    if (!empty($_SESSION['logged_in'])) {
      echo "<a href='/semester_exam_4/site/profile.php'><img loading='lazy' src='$avatar' alt='Profile'></a>";
      echo "<a href='logout.php'>Logout</a>";
    } else {
      echo "<div id='login_container'>";
      echo "<div id='steam_login'>";
      echo "<a href='/semester_exam_4/site/config/init-openId.php'><i class='fa-brands fa-steam'></i> <span>Login with Steam</span></a>";
      echo "</div>";
      echo "<a href='/semester_exam_4/site/config/test_account_login.php'>Login with Test account</a>";
      echo "</div>";
    }
    ?>
  </div>
</header>