<?php
include 'config/session.php';
include 'config/init.php';

if (!$_SESSION['logged_in']) {
  header("location: error.php?error=1");
  exit();
}

function str_contains($haystack, $needle): bool
{
  if (is_string($haystack) && is_string($needle)) {
    return '' === $needle || false !== strpos($haystack, $needle);
  } else {
    return false;
  }
}

function get_string_between($string, $start, $end)
{
  $string = ' ' . $string;
  $ini = strpos($string, $start);
  if ($ini == 0) return '';
  $ini += strlen($start);
  $len = strpos($string, $end, $ini) - $ini;
  return substr($string, $ini, $len);
}

// Setting the Steam64 ID for the user
$steamid = $_SESSION['userData']['steam_id'];

// Test ID
// $steamid = 76561198081951705;

// Making a requst to the Steam API, to get all CS:GO / CS2 items in the users inventory
$requestPayload = [
  'code' => 'string',
  'facilityCodes' => ['string']
];

$SteamAPI = curl_init();
curl_setopt($SteamAPI, CURLOPT_URL, "https://steamcommunity.com/inventory/$steamid/730/2?l=english&count=5000");
curl_setopt($SteamAPI, CURLOPT_POST, 1);
curl_setopt($SteamAPI, CURLOPT_POSTFIELDS, json_encode($requestPayload));  //Post Fields
curl_setopt($SteamAPI, CURLOPT_RETURNTRANSFER, true);

$headers = [
  'Content-Type: application/json',
  'Authorization: Bearer b30f3aea-7978-49bb-9ea7-33eddfc80afa',
];

curl_setopt($SteamAPI, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($SteamAPI);

curl_close($SteamAPI);
// End of request

// Turning the json data from the request into an array and splitting it into a descriptions and an assets array
$json_data_as_array = json_decode($response);

$inventory_descriptions = $json_data_as_array->descriptions;
$inventory_assets = $json_data_as_array->assets;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'components/head.php'; ?>
  <title>Sell</title>
</head>

<body>
  <?php include 'components/header.php'; ?>
  <main id="steam_inventory">
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
          <a href="/semester_exam_4/site/inventory.php">SkinsMart inventory <i class="fa-solid fa-caret-right"></i></a>
        </div>
      </div>
      <h1>Steam Inventory</h1>
      <form action="add_to_inventory.php" method="post">
        <div id="items_container">
          <?php
          // Looping through the inventory_descriptions array and displaying select information
          if (!empty($inventory_descriptions)) {
            foreach ($inventory_descriptions as $description) {
              if ($description->tradable == 1) {
                $item_values = "{";

                if (!empty($description->market_actions)) {
                  foreach ($description->tags as $tags) {
                    if ($tags->localized_category_name == "Type") {
                      $item_values .= '"item_type": "' . $tags->localized_tag_name . '", ';
                    }

                    if ($tags->localized_category_name == "Category") {
                      if ($tags->localized_tag_name = 'StatTrak™') {
                        $item_values .= '"has_stat_track": "1", ';
                      }
                    }

                    if ($tags->localized_category_name == "Exterior") {
                      if ($tags->localized_tag_name = "Factory New") {
                        $item_values .= '"skin_wear": "Factory New", ';
                      } else if ($tags->localized_tag_name = "Minimal Wear") {
                        $item_values .= '"skin_wear": "Minimal Wear", ';
                      } else if ($tags->localized_tag_name = "Field Tested") {
                        $item_values .= '"skin_wear": "Field Tested", ';
                      } else if ($tags->localized_tag_name = "Well Worn") {
                        $item_values .= '"skin_wear": "Well Worn", ';
                      } else {
                        $item_values .= '"skin_wear": "Battle Scarred", ';
                      }
                    }
                  }

                  $item_values .= '"image": "' . $description->icon_url . '", ';

                  $item_values .= '"item_name": "' . $description->name . '", ';

                  $item_values .= '"item_name_color": "' . $description->name_color . '", ';

                  foreach ($description->descriptions as $descriptions) {
                    if (str_contains($descriptions->value, "sticker_info")) {
                      $item_values .= '"has_sticker": "1", ';
                      $sticker_html = get_string_between($descriptions->value, "<center>", "<br>");
                      $sticker_html_change_quote = str_replace('"', "'", $sticker_html);
                      $sticker_array = explode("'", $sticker_html_change_quote);

                      if (count($sticker_array) >= 3) {
                        $item_values .= '"stickers_1_url": "' . $sticker_array[1] . '", ';
                        if (count($sticker_array) >= 5) {
                          $item_values .= '"stickers_2_url": "' . $sticker_array[3] . '", ';
                          if (count($sticker_array) >= 7) {
                            $item_values .= '"stickers_3_url": "' . $sticker_array[5] . '", ';
                            if (count($sticker_array) >= 9) {
                              $item_values .= '"stickers_4_url": "' . $sticker_array[7] . '", ';
                              if (count($sticker_array) >= 11) {
                                $item_values .= '"stickers_5_url": "' . $sticker_array[9] . '", ';
                              }
                            }
                          }
                        }
                      }
                    }
                  }

                  $item_values = rtrim($item_values, ', ');

                  $item_values .= "}";
                } else {
                  foreach ($description->tags as $tags) {
                    if ($tags->localized_category_name == "Type") {
                      if ($tags->localized_tag_name == "Music Kit") {
                        $item_values .= '"item_type": "' . $tags->localized_tag_name . '", ';
                      } else {
                        $item_values .= '"item_type": " ' . $tags->localized_tag_name . '", ';
                      }
                    }
                  }
                  $item_values .= '"image": "' . $description->icon_url . '", ';
                  $item_values .= '"item_name": " ' . $description->name . '", ';
                  $item_values .= '"item_name_color": "' . $description->name_color . '", ';

                  $item_values = rtrim($item_values, ', ');

                  $item_values .= "}";
                }

                if (!empty($description->market_actions)) {
                  // ------------------------- CSFloat API call start -------------------------
                  // Finding and saving the asset_id for the item, for use in CSFloat API call
                  // $asset_id = '';
                  // foreach ($inventory_assets as $asset) {
                  //   if ($asset->classid == $description->classid) {
                  //     $asset_id = $asset->assetid;
                  //   }
                  // }

                  // Going further down into the description array and getting the last part of the inspect link for the item, for use in CSFloat API call
                  // $link = '';
                  // foreach ($description->market_actions as $market_action) {
                  //   $link = $market_action->link;
                  // }
                  // $inspect_id = substr($link, strpos($link, "D") + 1);

                  // CSGO Float API call for the item
                  // $requestPayload = [
                  //   'code' => 'string',
                  //   'facilityCodes' => ['string']
                  // ];

                  // $CSFloat = curl_init();
                  // curl_setopt($CSFloat, CURLOPT_URL, "http://192.38.129.227:5433/?s=$steamid&a=$asset_id&d=$inspect_id");
                  // curl_setopt($CSFloat, CURLOPT_CUSTOMREQUEST, 'GET');
                  // curl_setopt($CSFloat, CURLOPT_POSTFIELDS, json_encode($requestPayload));  //Post Fields
                  // curl_setopt($CSFloat, CURLOPT_RETURNTRANSFER, true);

                  // $headers = [
                  //   'Content-Type: application/json',
                  //   'Authorization: Bearer b30f3aea-7978-49bb-9ea7-33eddfc80afa',
                  // ];

                  // curl_setopt($CSFloat, CURLOPT_HTTPHEADER, $headers);

                  // $api_response = curl_exec($CSFloat);

                  // curl_close($CSFloat);
                  // End of CSFloat API call
                  // $api_response_as_array = json_decode($api_response);
                  // $iteminfo = $api_response_as_array->iteminfo;
                  // ------------------------- CSFloat API call end -------------------------

                  foreach ($description->tags as $tags) {
                    if ($tags->localized_category_name == "Type") {
                      $uniqueId = $description->classid . $description->instanceid;
                      echo "<label for='$uniqueId'>";
                      echo "<div class='item_container $tags->localized_tag_name'>";
                      echo "<div class='item_image_container'>";
                      echo "<div class='checkbox_container'>";
                      echo "<input type='checkbox' class='$tags->localized_tag_name' name='data[]' id='$uniqueId' value='$item_values'>";
                      echo "</div>";
                    }
                  }
                  echo "<img loading='lazy' src='https://steamcommunity-a.akamaihd.net/economy/image/$description->icon_url' alt='A picture of $description->market_hash_name' title='A picture of $description->market_hash_name'>";

                  // Sticker container - extracts sticker images from a long string of html
                  echo "<div class='sticker_container'>";
                  foreach ($description->descriptions as $descriptions) {
                    if (str_contains($descriptions->value, "sticker_info")) {
                      echo get_string_between($descriptions->value, "<center>", "<br>");
                    }
                  }
                  echo "</div>";
                  echo "</div>";
                  echo "<div class='item_container_info_box'>";
                  echo "<p style='color: #$description->name_color'>$description->name</p>";
                  // foreach ($description->tags as $tags) {
                  //   if ($tags->localized_category_name == "Exterior") {
                  //     echo "<p>$tags->localized_tag_name - $iteminfo->floatvalue</p>";
                  //   }
                  // }
                  echo "</div>";
                  echo "</div>";
                  echo "</label>";
                } else {
                  foreach ($description->tags as $tags) {
                    if ($tags->localized_category_name == "Type") {
                      if ($tags->localized_tag_name == "Music Kit") {
                        $uniqueId = $description->classid . $description->instanceid;
                        echo "<label for='$uniqueId'>";
                        echo "<div class='item_container music_kit'>";
                        echo "<div class='item_image_container'>";
                        echo "<div class='checkbox_container'>";
                        echo "<input type='checkbox' class='music_kit' name='data[]' id='$uniqueId' value='$item_values'>";
                        echo "</div>";
                      } else {
                        $uniqueId = $description->classid . $description->instanceid;
                        echo "<label for='$uniqueId'>";
                        echo "<div class='item_container $tags->localized_tag_name'>";
                        echo "<div class='item_image_container'>";
                        echo "<div class='checkbox_container'>";
                        echo "<input type='checkbox' class='$tags->localized_tag_name' name='data[]' id='$uniqueId' value='$item_values'>";
                        echo "</div>";
                      }
                    }
                  }
                  echo "<img loading='lazy' src='https://steamcommunity-a.akamaihd.net/economy/image/$description->icon_url' alt='A picture of $description->market_hash_name' title='A picture of $description->market_hash_name'>";
                  echo "</div>";
                  echo "<div class='item_container_info_box'>";
                  echo "<p style='color: #$description->name_color'>$description->name</p>";
                  echo "</div>";
                  echo "</div>";
                  echo "</label>";
                }
              }
            }
          }
          ?>
        </div>
        <button id="add_to_inventory" type="submit">Add to SkinsMart inventory</button>
      </form>
    </section>
  </main>
  <?php include 'components/footer.php'; ?>
</body>

</html>