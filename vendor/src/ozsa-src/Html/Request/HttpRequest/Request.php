<?php

 namespace Http;

  class Request
  {
      protected $client;
      protected $responseGet;
      protected $responsePost;

      public function __construct()
      {
           $this->client = new \GuzzleHttp\Client();


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