<?php 
 
   /**
   * @author OZSAFRAMEWORK
   * @link http://www.ozsabilisim.org/framework/version.json
   */ 


   $json = $curl->get($authorWebSite."/framework/version.json");

   $decode = json_decode($json);

   $version = $decode->version;

   if($version != $frameWorkVersion){
        
        $array = array ( 'update' => true,'newVersion ' => $version);

        if(!file_exists("version.json")) touch("version.json");

        $open = fopen("version.json", "w");

        $write = fwrite($open, json_encode($array));

        fclose($open);

   } 

?>