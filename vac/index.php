<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0">
    <title>sbondVac</title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="shortcut icon" href="https://ul.sbond.co/i/ico/vac/logo.png">
    <link rel="shortcut icon" href="https://ul.sbond.co/i/ico/vac/logo.svg">
  </head>
  <body>
    <nav>
      <form id="steamIDForm">
        <input id="navSearch" type="search" placeholder="steamID64/URL">
        <div class="icon" id="navIcon"></div>
      </form>
    </nav>

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
          <span class="days"></span>
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

      <div id="noVac" class="hidden">NOT VAC BANNED</div>
    </div>

    <script src="js/main.js" type="text/javascript"></script>
  </body>
</html>
