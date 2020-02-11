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
    console.log(JSON.stringify(response));
  });

}

getProfileInfo();
