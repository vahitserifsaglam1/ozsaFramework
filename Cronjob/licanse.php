<?php 

   /**
   * @version 1.0
   * @author OZSAFRAMEWORK
   * version check
   */

    $Type = $curl->get($authorWebSite."/framework/version.json");

    $decodeType = json_decode($json);

    if($decodeType->Type =! "free") {
    	if(!file_exists("licanse.json")) touch("licanse.json");

          $openType = fopen("licanse.json", "w");
          $writeType = fwrite($openType, json_encode(array('licanse' => "not free")));
          $closeType = fclose($openType);
    }

?> 