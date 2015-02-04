<?php

  interface SessionInterface
  {
      public function __construct();
      public function boot();
      public static function __callStatic($name,$params);
  }