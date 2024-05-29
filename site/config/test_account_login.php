<?php
session_start();
require "./init.php";

$_SESSION['logged_in'] = true;
$_SESSION['userData'] = [
  'steam_id' => "76561198081951705",
  'name' => "Test account",
  'avatar' => "https://avatars.steamstatic.com/ea274dc306ef099f87758887cfa43a4e7137d12c_medium.jpg",
];

$userSQL = "SELECT * FROM users WHERE steam_id = :steam_id";
$userId = [":steam_id" => $_SESSION['userData']['steam_id']];
$userCheck = $db->sql($userSQL, $userId, true);

if (empty($userCheck)) {
  $createUser = "INSERT INTO users (steam_id, steam_name, avatar) 
              VALUES(:steam_id, :steam_name, :avatar)";
  $createUserData = [
    ":steam_id" => $_SESSION['userData']['steam_id'],
    ":steam_name" => $_SESSION['userData']['name'],
    ":avatar" => $_SESSION['userData']['avatar']
  ];
  $db->sql($createUser, $createUserData, false);

  $userSQL = "SELECT * FROM users WHERE steam_id = :steam_id";
  $userId = [":steam_id" => $_SESSION['userData']['steam_id']];
  $user = $db->sql($userSQL, $userId, true);

  $_SESSION['userData']['user_id'] = $user[0]->id;
} else {
  $_SESSION['userData']['user_id'] = $userCheck[0]->id;
}

$redirect_url = "../index.php";
header("Location: $redirect_url");
exit();
