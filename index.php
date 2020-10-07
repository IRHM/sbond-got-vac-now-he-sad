<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0">
    <title>sbondVac</title>
    <link rel="shortcut icon" href="/img/logo.png">
    <link rel="shortcut icon" href="/img/logo.svg">
    <link rel="stylesheet" href="/css/main.css">
    <script src="/js/main.js" defer></script>
    <script async defer data-website-id="5903d738-7e73-48ea-8238-f3afc9d24d73" src="https://anal.sbond.co/umami.js"></script>
  </head>
  <body>
    <nav>
      <form id="steamIDForm">
        <input id="navSearch" type="search" placeholder="steamID64/URL" autocomplete="off">
        <div class="icon" id="navIcon"></div>
      </form>
    </nav>

    <div class="noticeContainer" id="noticeContainer"></div>

    <div id="mainContent" class="hidden">
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
    </div>
  </body>
</html>
