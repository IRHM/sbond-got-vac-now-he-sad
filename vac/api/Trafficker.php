<?php
  namespace Api;

  use Api\GetProfileInfo;

  $trafficker = new Trafficker();
  $trafficker->handleRequest();

  class Trafficker{
    public function handleRequest(){
      // Get JSON from POST request
      $JSON = @file_get_contents('php://input');

      // If no JSON then exit
      if(!is_object(json_decode($JSON))){
        $this->sendMsg('err', 'invalid request');
        exit();
      }

      // Decode JSON
      $args = json_decode($JSON, true);

      // Check what is wanted
      if(isset($args['return'])){
        $val = $args['return'];

        switch($val[0]){
          case "getProfileInfo":
            require_once($_SERVER['DOCUMENT_ROOT'] . '/api/GetProfileInfo.php');
            $getProfileInfo = new GetProfileInfo();

            // Check for steamID
            if(isset($val[1]) && !empty($val[1])){
              // Val[1] in the request arr should be a steamID
              // if it doesn't resemble one cancel and send an error
              $steamID = $val[1];

              if(ctype_digit($steamID)){
                // steamID64
                $this->sendMsg('msg', $getProfileInfo->data('steamID64', $steamID));
              }
              else if(strpos($steamID, 'steamcommunity.com/id')){
                // steam customURL
                $this->sendMsg('msg', $getProfileInfo->data('customURL', $steamID));
              }
              else{
                // Not in supported format
                $this->sendMsg('err', 'didnt detect any steam id');
                exit();
              }
            }
            else{
              $this->sendMsg('err', 'no steamid set in request');
              exit();
            }

            break;
          default:
            $this->sendMsg('err', 'nothing to return');
            break;
        }
      }
    }

    private function sendMsg($name, $msg){
      echo json_encode(array($name => $msg));
    }
  }
