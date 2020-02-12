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
  queryTrafficker({ 'return':'getProfileInfo', }).then((response) => {
    // console.log(JSON.stringify(response));

    for(const key of Object.keys(response)){
      var prof = response[key];

      var steamID64 = prof[0]['steamID64'];
      var customURL = prof[0]['customURL'];
      var username = prof[0]['username'];
      var realName = prof[0]['realName'];
      var memberSince = prof[0]['memberSince'];
      var avatar = prof[0]['avatar'];
      var location = prof[0]['location'];
      var status = prof[0]['status'];
      var vacStatus = prof[0]['vacStatus'];

      var banFullMsg = prof[1]['banFullMsg'];
      var banDays = prof[1]['banDays'];
    }

  });

}

getProfileInfo();
