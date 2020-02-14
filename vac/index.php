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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>sbondVac</title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="shortcut icon" href="https://ul.sbond.co/i/ico/vac/logo.png">
    <link rel="shortcut icon" href="https://ul.sbond.co/i/ico/vac/logo.svg">
  </head>
  <body>
    <div class="userHeadContainer">
      <div class="wrapper">
        <div class="profilePicture">
          <img id="avatar" src="" alt="">
        </div>
        <div class="data">
          <span id="username">Getting username</span>
          <span id="desc">Getting bio</span>
          <div class="locationWrap">
            <img id="locImg" src="" alt="">
            <span id="loc">Getting Location</span>
          </div>
        </div>
      </div>
    </div>

    <div class="counterContainer">
      <div id="counter" class="counter">
        <div id="day">
          <span></span>
          <span>Days</span>
        </div>
        <div id="hour">
          <span></span>
          <span>Hours</span>
        </div>
        <div id="minute">
          <span></span>
          <span>Minutes</span>
        </div>
        <div id="second">
          <span></span>
          <span>Seconds</span>
        </div>
      </div>
    </div>

    <script src="js/main.js" type="text/javascript"></script>
  </body>
</html>
