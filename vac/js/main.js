var ui_avatar = document.getElementById("avatar");
var ui_username = document.getElementById("username");
var ui_desc = document.getElementById("desc");
var ui_loc = document.getElementById("loc");
var ui_locImg = document.getElementById("locImg");

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

      ui_avatar.src = msg.avatar;
      ui_username.textContent = msg.username;
      ui_desc.textContent = msg.description;
      ui_loc.textContent = msg.location;
      ui_locImg.src = msg.locationImg;
    }
  });
}

getProfileInfo();
