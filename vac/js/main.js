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

async function getProfileInfo(){
  queryTrafficker({ 'return':'getProfileInfo' }).then((response) => {
    if(typeof response.msg !== 'undefined' && response.msg.length > 0){
      var msg = response.msg[0];

      // Update profile UI elements
      ui_avatar.src = msg.avatar;
      ui_username.textContent = msg.username;
      ui_desc.textContent = msg.description;
      ui_loc.textContent = msg.location;
      ui_locImg.src = msg.locationImg;

      // Set countdown to days on users ban
      makeCountdown(msg.banDays);
    }
  });
}

async function makeCountdown(banDays){
  Date.prototype.addDays = function(d){
    return new Date(this.valueOf()+864E5*d);
  };

  banDaysLeft = 2556 - banDays;

  // Get date when ban is over
  var cdDate = new Date().addDays(banDaysLeft);

  // Remove hours, mins, seconds and milliseconds
  var cdDate = new Date(cdDate.getFullYear(), cdDate.getMonth(), cdDate.getDate(), 0, 0, 0, 0);

  // Countdown
  var cd = setInterval(function(){
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

getProfileInfo();
