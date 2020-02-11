<?php
  require_once('api/conf/Database.php');
  require_once('api/GetProfileInfo.php');

  use Api\Database;
  use Api\GetProfileInfo;

  // $database = new Database();
  // $db = $database->connect();
  //
  // $getProfileInfo = new GetProfileInfo();
  // $data = $getProfileInfo->data();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>sbondVac</title>
    <link rel="stylesheet" href="/css/main.css">
  </head>
  <body>
    <div class="userHeadContainer">
      <div class="wrapper">
        <div class="profilePicture">
          <img src="https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/13/1322e6f5b9a8a9891e75814653d55027854ff064_full.jpg" alt="">
        </div>
        <div class="data">
          <span id="username">sbondo1234</span>
          <span id="desc">Mighty kille of cs game ever the third</span>
          <span id="country"><img src="https://steamcommunity-a.akamaihd.net/public/images/countryflags/rs.gif" alt="">Serbia</span>
        </div>
      </div>
    </div>

    <div class="counterContainer">
      <div class="counter">
        <div id="day">
          <span>630</span>
          <span>Days</span>
        </div>
        <div id="hour">
          <span>23</span>
          <span>Hours</span>
        </div>
        <div id="minute">
          <span>51</span>
          <span>Minutes</span>
        </div>
      </div>
    </div>

    <script src="js/main.js" type="text/javascript"></script>
  </body>
</html>
