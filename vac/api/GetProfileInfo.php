<?php
  namespace Api;

  use DOMDocument;
  use DOMXpath;

  class GetProfileInfo{
    public function data(){
      $this->extactData('https://steamcommunity.com/id/idontknowplshelp/');
    }

    private function extactData($url){
      // Get data not provided in xml copy
      $extractScreen = $this->extractScreen($url);

      $extractXml = $this->extractXml($url);
    }

    private function extractXml($url){
      // Get xml data
      $url = "$url?xml=1";
      $xml = simplexml_load_file($url);
      // print_r($xml);
    }

    private function extractScreen($url){
      // Get site data
      $html = file_get_contents($url);

      // Hide bad html errors
      libxml_use_internal_errors(true);

      $doc = new DOMDocument;
      $doc->loadHTML($html);
      $xpath = new DOMXpath($doc);

      // Get specific elements value from xpath
      if(isset($xpath)){
        $banInfo = $xpath->query('/html/body/div[1]/div[7]/div[3]/div[1]/div[2]/div/div[1]/div[1]/div[2]')->item(0);
        $banFullMsg = str_replace('Info', '', $banInfo->textContent);
        $banDays = (int) filter_var($banFullMsg, FILTER_SANITIZE_NUMBER_INT);

        return array('ban' => array('fullMsg' => $banFullMsg, 'time' => $banDays));
      }

      return array('err' => 'error getting specific info');
    }
  }
