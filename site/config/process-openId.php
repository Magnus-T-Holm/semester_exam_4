<?php
session_start();
require "./init.php";

function p($arr)
{
  return '<pre>' . print_r($arr, true) . '</pre>';
}

$params = [
  'openid.assoc_handle' => $_GET['openid_assoc_handle'],
  'openid.signed'       => $_GET['openid_signed'],
  'openid.sig'          => $_GET['openid_sig'],
  'openid.ns'           => 'http://specs.openid.net/auth/2.0',
  'openid.mode'         => 'check_authentication',
];

$signed = explode(',', $_GET['openid_signed']);

foreach ($signed as $item) {
  $val = $_GET['openid_' . str_replace('.', '_', $item)];
  $params['openid.' . $item] = stripslashes($val);
}

$data = http_build_query($params);
//data prep
$context = stream_context_create([
  'http' => [
    'method' => 'POST',
    'header' => "Accept-language: en\r\n" .
      "Content-type: application/x-www-form-urlencoded\r\n" .
      'Content-Length: ' . strlen($data) . "\r\n",
    'content' => $data,
  ],
]);

//get the data
$result = file_get_contents('https://steamcommunity.com/openid/login', false, $context);

if (preg_match("#is_valid\s*:\s*true#i", $result)) {
  preg_match('#^https://steamcommunity.com/openid/id/([0-9]{17,25})#', $_GET['openid_claimed_id'], $matches);
  $steamID64 = is_numeric($matches[1]) ? $matches[1] : 0;
  echo 'request has been validated by open id, returning the client id (steam id) of: ' . $steamID64;
} else {
  echo 'error: unable to validate your request';
  exit();
}

$steam_api_key = "B4394ACDFFA3608F5A8CE56DB11B9390";

$response = file_get_contents('https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=' . $steam_api_key . '&steamids=' . $steamID64);
$response = json_decode($response, true);

$userData = $response['response']['players'][0];
$_SESSION['logged_in'] = true;
$_SESSION['userData'] = [
  'steam_id' => $userData['steamid'],
  'name' => $userData['personaname'],
  'avatar' => $userData['avatarmedium'],
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
