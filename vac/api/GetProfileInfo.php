<?php
  namespace Api;

  use DOMDocument;
  use DOMXpath;

  class GetProfileInfo{
    public function data(){
      return $this->extactData('https://steamcommunity.com/id/idontknowplshelp/');
    }

    private function extactData($url){
      // Get extracted data from both methods
      $extractXml = $this->extractXml($url);
      $extractScreen = $this->extractScreen($url);
      $allData = array_merge($extractXml, $extractScreen);

      return array($allData);
    }

    private function extractXml($url){
      // Get xml data
      $url = "$url?xml=1";
      $xml = simplexml_load_file($url);

      // Specific xml data
      if(isset($xml) && !empty($xml)){
        // Select data
        $steamID64 = (int) $xml->steamID64;
        $customURL = (string) "https://steamcommunity.com/id/$xml->customURL";
        $username = (string) $xml->steamID;
        $realName = (string) $xml->realname;
        $memberSince = (string) $xml->memberSince;
        $avatar = (string) $xml->avatarFull;
        $location = (string) $xml->location;
        $description = str_replace('https://steamcommunity.com/linkfilter/?url=', '', (string) $xml->summary);
        $status = (string) $xml->onlineState;
        $vacStatus = (int) $xml->vacBanned;

        // Return selected data in array
        return array(
          'steamID64' => $steamID64,
          'customURL' => $customURL,
          'username' => $username,
          'realName' => $realName,
          'memberSince' => $memberSince,
          'avatar' => $avatar,
          'location' => $location,
          'description' => $description,
          'status' => $status,
          'vacStatus' => $vacStatus
        );
      }
      else{
        return array('err' => 'error getting xml data');
      }
    }

    private function extractScreen($url){
      // Get site data
      $html = file_get_contents($url);

      // Hide html errors
      libxml_use_internal_errors(true);

      $doc = new DOMDocument;
      $doc->loadHTML($html);
      $xpath = new DOMXpath($doc);

      // Get specific elements value from xpath
      if(isset($xpath)){
        // Get ban info from page
        $banInfo = $xpath->query('/html/body/div[1]/div[7]/div[3]/div[1]/div[2]/div/div[1]/div[1]/div[2]')->item(0);

        // Remove 'Info' and remove unnecessary spaces
        $banFullMsg = str_replace('Info', '', $banInfo->textContent);
        $banFullMsg = trim(preg_replace('/\s+/', ' ', $banFullMsg));

        // Get days on ban in seperate var
        $banDays = (int) filter_var($banFullMsg, FILTER_SANITIZE_NUMBER_INT);

        // Get location image
        $locationImg = $xpath->query("/html/body/div[1]/div[7]/div[3]/div[1]/div[1]/div/div/div/div[1]/div[2]/img")->item(0);
        $locationImg = $locationImg->attributes->getNamedItem('src')->nodeValue;

        return array(
          'banFullMsg' => $banFullMsg,
          'banDays' => $banDays,
          'locationImg' => $locationImg
        );
      }

      return array('err' => 'error getting specific info');
    }
  }
