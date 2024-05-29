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
  <main id="error_page">
    <?php
    $message;

    $error_code;
    if (!empty($_GET['error'])) {
      $error_code = $_GET['error'];
      if ($error_code == 1) {
        $message = "Error 1: You need to be logged in to access that page.";
      } elseif ($error_code == 2) {
        $message = "Error 2: You do not have access to this page.";
      } elseif ($error_code == 3) {
        $message = "Error 3: This item is not for sale.";
      } elseif ($error_code == 4) {
        $message = "Error 4: Something went wrong.";
      } elseif ($error_code == 5) {
        $message = "Error 5: The page you tried to visit needs some information in the URL, that was missing.";
      } elseif ($error_code == 6) {
        $message = "Error 6: You can't change the balance on an account you are not logged in on.";
      } elseif ($error_code == 69) {
        $message = "Error 69: You are trying to add you own item to the cart.";
      } elseif ($error_code == 404) {
        $message = "Error 404: The page you are trying access either doesn't exist or is under construction.";
      } else {
      }
      echo "<h1>$message</h1>";
    } else {
      echo "<h1>...wait, how did you end up here? There were no error code sent along, so I guess you must have entered in this page in the URL by yourself.</h1>";
      echo "<h2>If this was not the case, please contact us, so we can fix what caused you to end up here.</h2>";
    }
    ?>
  </main>
  <?php include 'components/footer.php'; ?>
</body>

</html>