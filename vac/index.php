<?php
  require_once('api/conf/db.php');
  require_once('api/GetProfileInfo.php');

  use Api\Database;
  use Api\GetProfileInfo;

  $database = new Database();
  $db = $database->connect();

  $getProfileInfo = new GetProfileInfo();
  $data = $getProfileInfo->data();

  //echo Database::connect();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

  </body>
</html>
