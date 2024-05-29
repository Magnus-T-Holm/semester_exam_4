<?php
include 'config/session.php';
include 'config/init.php'; {
  $output = $data;
  // if (is_array($output))
  //   $output = implode(',', $output);

  echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

if (empty(!$_SESSION['logged_in'])) {
  if (!empty($_GET['id'])) {
    $url_id = $_GET['id'];

    $user_id = $_SESSION['userData']['user_id'];

    if ($url_id == $user_id) {
      if (!empty($_POST['data'])) {
        $data = $_POST['data'];

        $sql_update_user = "UPDATE users SET balance = :new_balance WHERE id = :id";
        $sql_data_user = [
          ":new_balance" => $data['balance'],
          ":id" => $user_id
        ];
        $db->sql($sql_update_user, $sql_data_user, false);

        header("Location: profile.php");
      } else {
        header("Location: profile.php?error=1");
      }
    } else {
      header("Location: error.php?error=6");
    }
  } else {
    header("Location: error.php?error=5");
  }
} else {
  header("Location: error.php?error=1");
}
