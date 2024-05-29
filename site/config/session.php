<?php
session_start();
if (!empty($_SESSION['logged_in'])) {
  $avatar = $_SESSION['userData']['avatar'];
};
