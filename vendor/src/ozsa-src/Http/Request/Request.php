<?php

 namespace Http;

  class Request
  {
      private static $_singleton;
      protected $client;
      protected $responseGet;
      protected $responsePost;
      protected $_uri  =  null;

      public function __construct()
      {
           $this->client = \Desing\Single::make('\GuzzleHttp\Client');

      }
      public static function this()
      {
          if (self::$_singleton === null) {
              self::$_singleton = false;
              self::$_singleton = new self;
          }

          return self::$_singleton;
      }

      public function getUri()
      {
          if ($this->_uri === null) {
              $_requestUri = filter_var(self::getVar('REQUEST_URI', '/'), FILTER_SANITIZE_URL);
              if ($_requestUri === $_SERVER['SCRIPT_NAME']) {
                  $_uri = '/';
              } else {

                  $_uri = (mb_strpos($_requestUri, $_SERVER['SCRIPT_NAME']) === 0)
                      ? substr_replace($_requestUri, '', 0, mb_strlen($_SERVER['SCRIPT_NAME']))
                      : $_requestUri;


              }

              if (($_queryString = $this->getQueryString()) !== false) {
                  $this->_uri = trim(str_replace('?' . $_queryString, '', $_uri), '/');
              } else {
                  $this->_uri = trim(rtrim($_uri, '?'), '/');
              }

          }

          return (is_string($this->_uri) === false || mb_strlen($this->_uri) === 0) ? '/' : $this->_uri;
      }


      public static function getVar($key, $default = null)
      {
          return (array_key_exists($key, $_SERVER)) ? $_SERVER[$key] : $default;
      }
      public function get($url,$params = array())
      {
          $req = $this->client->createRequest('GET', $url, $params);
          $cek = $this->client->send($req);
              return  $this;

      }
      public function post($url,$params = array() )
      {
          $req = $this->client->createRequest('POST', $url, $params);
          $cek = $this->client->send($req);
          return $this;
      }

      public function __call($name,$params)
      {
          return call_user_func_array(array($this->client,$name),$params);
      }

  }