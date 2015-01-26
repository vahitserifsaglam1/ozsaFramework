<?php

  class Curl
  {
      public static $options;
      public static $ch;
      public static function init()
      {
          self::$ch = curl_init();
          self::$options = array (

              CURLOPT_REFERER => 'http://www.ozsabilisim.org',
              CURLOPT_USERAGENT =>  $_SERVER['HTTP_USER_AGENT'],
              CURLOPT_RETURNTRANSFER => 1,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_TIMEOUT => 50

          );
      }

      public static function get($url)
      {
       if(!self::$ch) Curl::init();

          self::setUrl($url);

          curl_setopt_array(self::$ch, self::$options);

          return curl_exec(self::$ch);

      }

      public static function post($url, $params = array() )
      {
          $ch = self::$ch;
          $fields = "";

          if(!$ch) Curl::init();

          self::setUrl($url);

          self::$options[CURLOPT_POST] = count($params);

          foreach($params  as $key => $value) { $fields .= $key.'='.$value.'&'; } $fields = rtrim($fields, '&');

          self::$options[CURLOPT_POSTFIELDS] = $fields;

          curl_setopt_array($ch,self::$options);

          return curl_exec(self::$ch);

      }

      public static function download($url,$path = "downloads")
      {
          if(!self::$ch) Curl::init();

         $file = fopen($path,"w+");

          $ch = self::$ch;

          self::setUrl($url);

          self::$options[CURLOPT_FILE] = $file;

          curl_setopt_array($ch,self::$options);

          return curl_exec($ch);
      }
      public static function addPost($params)
      {
          $fields = "";
          self::$options[CURLOPT_POST] = count($params);

          foreach($params  as $key => $value) { $fields .= $key.'='.$value.'&'; } $fields = rtrim($fields, '&');

          self::$options[CURLOPT_POSTFIELDS] = $fields;
      }
      public static function setUrl($url)
      {
          self::$options[CURLOPT_URL] = str_replace(" ","%20",$url);
      }
      public static function close()
      {
          curl_close(self::$ch);
      }


  }

?>