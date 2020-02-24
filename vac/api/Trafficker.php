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
        $this->respond('msg', array('err' => 'invalid request'));
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

            // Check if steamID was sent along with request
            if(isset($val[1]) && !empty($val[1])){
              $this->respond('msg', $getProfileInfo->data($val[1]));
            }
            else{
              $this->respond('msg', array('err' => 'steamID not set or is not in the right place in your request'));
            }

            break;
          default:
            $this->respond('msg', array('err' => 'nothing to return'));
            break;
        }
      }
    }

    private function respond($name, $msg){
      echo json_encode(array($name => $msg));
    }
  }
