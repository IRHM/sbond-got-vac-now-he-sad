<?php
  namespace Api;

  use DOMDocument;
  use DOMXpath;

  class GetProfileInfo{
    public function data($type, $id){
      if($type == 'steamID64'){
        return $this->extactData("https://steamcommunity.com/profiles/$id");
      }
      else if($type == 'customURL'){
        return $this->extactData($id);
      }
      else{
        return array('err' => 'type not understood');
      }
    }

    private function extactData($url){
      // Get extracted data from both methods
      $extractXml = $this->extractXml($url);
      $extractScreen = $this->extractScreen($extractXml['vacStatus'], $url);
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
        $description = strip_tags(
          // Only allow certain html tags and replace div with span
          str_replace(
            'https://steamcommunity.com/linkfilter/?url=',
            '',
            str_replace(
              'div',
              'span',
              (string) $xml->summary)
          ),
          '<br><b><u><i><a><span>'
        );
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

    private function extractScreen($vacStatus, $url){
      // Get site data
      $html = file_get_contents($url);

      // Hide html errors
      libxml_use_internal_errors(true);

      $doc = new DOMDocument;
      $doc->loadHTML($html);
      $xpath = new DOMXpath($doc);

      // Get specific elements value from xpath
      if(isset($xpath)){
        $banFullMsg = 0;
        $banDays = 0;

        // Get location image
        $locationImg = $xpath->query("/html/body/div[1]/div[7]/div[3]/div[1]/div[1]/div/div/div/div[1]/div[2]/img")->item(0);

        if(isset($locationImg) && !empty($locationImg)){
          $locationImg = $locationImg->attributes->getNamedItem('src')->nodeValue;
        }

        // Get background image
        $backgroundImg = $xpath->query("/html/body/div[1]/div[7]/div[3]/div[1]")->item(0);

        if(isset($backgroundImg) && !empty($backgroundImg)){
          $backgroundImg = $backgroundImg->attributes->getNamedItem('style')->nodeValue;

          // Check if element has background image has url
          if(preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $backgroundImg, $match)){
            $backgroundImg = $match[0][0];
          }
          else{
            $backgroundImg = 0;
          }
        }
        else{
          // Background element not found
          $backgroundImg = 0;
        }

        // Get ban info from page if vacced
        if($vacStatus){
          $banInfo = $xpath->query('/html/body/div[1]/div[7]/div[3]/div[1]/div[2]/div/div[1]/div[1]/div[2]')->item(0);

          // Remove 'Info' and remove unnecessary spaces
          $banFullMsg = str_replace('Info', '', $banInfo->textContent);
          $banFullMsg = trim(preg_replace('/\s+/', ' ', $banFullMsg));

          // Get days on ban in seperate var
          $banDays = (int) filter_var($banFullMsg, FILTER_SANITIZE_NUMBER_INT);
        }
        else{
          // Vac info element not found
          $banFullMsg = 0;
          $banDays = 0;
        }

        return array(
          'banFullMsg' => $banFullMsg,
          'banDays' => $banDays,
          'locationImg' => $locationImg,
          'backgroundImg' => $backgroundImg
        );
      }

      return array('err' => 'error getting specific info');
    }
  }
