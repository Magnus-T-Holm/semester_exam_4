<?php
include 'config/session.php';
include 'config/init.php';

if (!$_SESSION['logged_in']) {
  header("location: error.php?error=1");
  exit();
}

$username = $_SESSION['userData']['name'];
$user_id = $_SESSION['userData']['user_id'];

$user_sql = $db->sql("SELECT * FROM users WHERE id = $user_id");
$user = $user_sql[0];

?>
<!doctype html>
<html>

<head>
  <?php include 'components/head.php';

  echo "<title>$username - Profile</title>";
  ?>
</head>

<body>
  <?php include 'components/header.php'; ?>

  <main id="profile">
    <div>
      <?php
      echo "<h1>Welcome $username</h1>";

      $message;
      $error_code;
      if (!empty($_GET['error'])) {
        $error_code = $_GET['error'];
        if ($error_code == 1) {
          $message = "Error 1: You need to be logged in to access that page.";
        }
        echo "<h2>$message</h2>";
      }

      echo "<img loading='lazy' src='$avatar'>";

      echo "<form id='update_balance' action='update_balance.php?id=$user->id' method='post'>";
      echo "<div>";

      echo "<h2>Update you account balance</h2>";

      echo "<div>";
      echo "<label for='update_balance_input'>Current balance:</label>";
      echo "<input type='number' step='0.01' id='update_balance_input' name='data[balance]' value='$user->balance'>";
      echo "</div>";

      echo "</div>";

      echo "<button id='update_balance_button' type='submit'>Update balance</button>";
      echo "</form>";
      ?>
    </div>
  </main>

  <?php include 'components/footer.php'; ?>
</body>

</html>