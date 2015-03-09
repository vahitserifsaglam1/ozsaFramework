<?php

   namespace Http\Client\Adapter;

   use Curl\Full;


  class Curl extends Full
  {

      public function __construct()
      { parent::__construct(false); }

      public function getName()
      {
          return "Curl";
      }

      public function boot()
      {

      }
  }