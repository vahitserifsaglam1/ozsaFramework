<?php
  namespace Lib\ipBlock;
  class ipBlock {
       public  static function setIp($ip)
       {
           $insert = $db->query("INSERT INTO IpBlock SET ipAdress = '$ip' ");
           return ($insert) ? true:false;
       }  
      public static function ipBlocker($status = false)
      {
           global $db;
           $ip =self::getIp();
          if($status){
              $kontrol = $pdo->query("SELECT ipAdress From IpBlock where ipAdress= '$ip' ")->rowCount();
              if($kontrol){
                  error::newError("Ip Adresiniz engellenmiştir");
                  die();
              }
          }

      }
      public static function getIp(){
          if(getenv("HTTP_CLIENT_IP")) {
              $ip = getenv("HTTP_CLIENT_IP");
          } elseif(getenv("HTTP_X_FORWARDED_FOR")) {
              $ip = getenv("HTTP_X_FORWARDED_FOR");
              if (strstr($ip, ',')) {
                  $tmp = explode (',', $ip);
                  $ip = trim($tmp[0]);
              }
          } else {
              $ip = getenv("REMOTE_ADDR");
          }
          return $ip;
      }
      public static function Install()
      {
        
      }
  }