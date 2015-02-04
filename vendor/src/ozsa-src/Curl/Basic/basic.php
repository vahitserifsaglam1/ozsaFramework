<?php

 namespace Curl\Basic;
 /**
  * Class Curl
  * @package Curl\Basic
  *
  *  *********************************
  *
  *  Ozsaframework basit curl sınıfı, static ;
  *
  *
  *  ///////////////////////////////
  *
  *   Curl::init();
  *
  *   Curl::setOpt(OPT_NAME,OPT_VALUE);
  *
  *  Curl::get('http://www.google.com');
  */
 class Curl implements \curlBasicInterface
 {
     public static $options;
     public static $ch;
     public static function init()
     {
         self::$ch = curl_init();
         self::$options = array (

             CURLOPT_REFERER => 'http://www.twitter.com',
             CURLOPT_USERAGENT =>  $_SERVER['HTTP_USER_AGENT'],
             CURLOPT_RETURNTRANSFER => 1,
             CURLOPT_FOLLOWLOCATION => true,
             CURLOPT_TIMEOUT => 50

         );
     }

     public static function get($url)
     {
         $class = get_class();
         if(!self::$ch) $class::init();

         self::setUrl($url);

         curl_setopt_array(self::$ch, self::$options);

         return curl_exec(self::$ch);

     }

     public static function post($url, $params = array() )
     {
         $fields = "";
         $class = get_class();
         if(!self::$ch) $class::init();

         self::setUrl($url);

         self::$options[CURLOPT_POST] = count($params);

         foreach($params  as $key => $value) { $fields .= $key.'='.$value.'&'; } $fields = rtrim($fields, '&');

         self::$options[CURLOPT_POSTFIELDS] = $fields;

         curl_setopt_array(self::$ch,self::$options);

         $ex =  curl_exec(self::$ch);

         return $ex;

     }

     public static function download($url,$path = "downloads")
     {
         if(!self::$ch) Curl::init();

         $file = fopen($path,"w+");

         self::setUrl($url);

         self::$options[CURLOPT_FILE] = $file;

         curl_setopt_array(self::$ch,self::$options);

         return curl_exec(self::$ch);
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

     public static function __callString($name,$params)
     {
         if($name=="setOpt")
         {
             self::$options[$params[0]] = $params[1];
         }
     }



 }