var ui_avatar = document.getElementById("avatar");
var ui_username = document.getElementById("username");
var ui_desc = document.getElementById("desc");
var ui_loc = document.getElementById("loc");
var ui_locImg = document.getElementById("locImg");
var ui_counter = document.getElementById("counter");
var ui_days = document.getElementById("day");
var ui_hours = document.getElementById("hour");
var ui_minutes = document.getElementById("minute");
var ui_second = document.getElementById("second");
var ui_noVac = document.getElementById("noVac");
var ui_steamIDForm = document.getElementById("steamIDForm");
var ui_navIcon = document.getElementById('navIcon');
var cd;
var handleErrPass = 0;

async function deleteErr(id){
  let notice = document.getElementById(id);

  // animation
  let animation = [
    { transform: 'translate3D(0, 0, 0)' },
    { transform: 'translate3D(0, 0, 0)', offset: 0.99 },
    { transform: 'translate3D(-200%, 0, 0)' }
  ];
  let options = {
    duration: 5000,
    easing: 'ease',
    fill: 'forwards'
  };
  let noticeAnim = notice.animate(animation, options);

  // Sleep for as long as animation
  await new Promise(r => setTimeout(r, 5000));

  // Delete notice
  notice.remove();
}

async function handleErr(err){
  let ui_notice = document.getElementById("noticeContainer");

  // Add (another) notice box with error
  ui_notice.insertAdjacentHTML('afterbegin',
    `<div class="notice" id="notice`+handleErrPass+`">
      <span>`+err+`</span>
    </div>`
  );

  // animation
  let animation = [
    { top: '-10%' },
    { top: '30px', offset: 0.1 },
    { top: '10px' }
  ];
  let noticeAnim = ui_notice.animate(animation, 100);

  deleteErr('notice' + handleErrPass);

  handleErrPass++;
}

function urlParam(returnParam=0, add, name, data=0){
  if(add){
    // Get curr url
    var url = new URL(window.location.href);
    // Set new param name/data
    var newUrl = url.searchParams.set(name, data);
    // Update curr url
    history.pushState(null, '', url);
  }
  else{
    // Get curr url
    var url = new URL(window.location.href);
    // Get param val
    var paramVal = url.searchParams.get(name);
    // put paramName and paramVal together
    var param = name + '=' + paramVal;

    // Update curr url
    var newUrl = window.location.href.replace(param, "");
    if(newUrl){
      history.pushState(null, "", newUrl);
    }
  }

  if(returnParam){
    // Return param val if requested
    return url.searchParams.get(name);
  }
}

// Search bar
ui_navIcon.onclick = function(){
  this.classList.toggle('close');
  document.getElementById('navSearch').classList.toggle('open');
}

ui_steamIDForm.onsubmit = function(){
  event.preventDefault();

  let searchBar = this['navSearch'];

  if(searchBar.value != ""){
    searchBarLoading(1);

    // Add query to 'q' url param
    urlParam(0, 1, 'q', searchBar.value);

    // searchBar not empty - get profileInfo
    queryTrafficker({ 'return':['getProfileInfo', searchBar.value] }).then((response) => {
      // send response to drawProfileInfo to display it
      drawProfileInfo(response).then(() => {

        searchBarLoading(0);
      });
    });
  }
  else{
    // searchBar empty

    // Remove 'q' params data
    urlParam(0, 0, 'q');
  }
}

function searchBarLoading(loading){
  if(loading){
    ui_navIcon.classList.add("loading");
  }
  else{
    ui_navIcon.classList.remove("loading");
  }
}

async function queryTrafficker(query){
  var response = await fetch('https://vac.sbond.co/api/trafficker.php', {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify(query)
  });

  return await response.json();
}

async function drawProfileInfo(data){
  if(typeof data.msg !== 'undefined' && data.msg.length > 0){
    var msg = data.msg[0];

    // Check if msg has err
    if(typeof msg.err !== 'undefined' && data.msg.length > 0){
      // msg contains error so handle & stop exit function
      handleErr(msg.err);
      return;
    }

    // Reset counter and novac to default states
    ui_counter.classList.remove('hidden');
    ui_noVac.classList.add('hidden');

    // Update profile UI elements
    ui_avatar.src = msg.avatar;
    ui_username.textContent = msg.username;
    ui_desc.innerHTML = msg.description;
    ui_loc.textContent = msg.location;
    ui_locImg.src = msg.locationImg;
    // document.body.style.backgroundImage = "url(" + msg.backgroundImg + ")";

    if(msg.vacStatus){
      // Set countdown to days on users ban
      makeCountdown(msg.banDays);
    }
    else{
      // User not vacced so dont show countdown
      ui_counter.classList.add('hidden');
      ui_noVac.classList.remove('hidden');
    }
  }
}

async function makeCountdown(banDays){
  clearInterval(cd);

  Date.prototype.addDays = function(d){
    return new Date(this.valueOf()+864E5*d);
  };

  // Preform very hard calculation
  let sevenYears = 2556;
  banDaysLeft = sevenYears - banDays;

  // Get date when ban is over
  var cdDate = new Date().addDays(banDaysLeft);

  // Remove hours, mins, seconds and milliseconds
  cdDate = new Date(cdDate.getFullYear(), cdDate.getMonth(), cdDate.getDate(), 0, 0, 0, 0);

  // Countdown
  cd = setInterval(function(){
    // Get time now
    var now = Date.now();

    // Get distance between now and cdDate
    var distance = cdDate - now;

    // Get time left
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Update UI
    ui_days.firstElementChild.textContent = days;
    ui_hours.firstElementChild.textContent = hours;
    ui_minutes.firstElementChild.textContent = minutes;
    ui_second.firstElementChild.textContent = seconds;

    // Hide hours/days/minutes when they are 0
    if(days === 0){
      ui_days.style.display = "none";
    }

    // Stop when countdown hits 0
    if(distance < 0){
      clearInterval(cd);
      ui_counter.style.display = "none";
    }
  }, 1000);
}
