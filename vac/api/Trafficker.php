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

        if($val == "getProfileInfo"){
          require_once($_SERVER['DOCUMENT_ROOT'] . '/api/GetProfileInfo.php');

          $getProfileInfo = new GetProfileInfo();
          // $getProfileInfo->data();

          $this->sendMsg('msg', $getProfileInfo->data());
        }
      }
    }

    private function sendMsg($name, $msg){
      echo json_encode(array($name => $msg));
    }
  }
