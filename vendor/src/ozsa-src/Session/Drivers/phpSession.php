<?php

  class phpSession implements \phpSessionInterface
  {
      public static function set($name,$value)
      {
          $_SESSION[$name] = $value;
      }
      public static function flush()
      {
          foreach($_SESSION as $key => $value)
          {
              unset($_SESSION[$key]);
          }
      }
      public static function get($name)
      {
          if(isset($_SESSION[$name])) return $_SESSION[$name];else return false;
      }
      public static function delete($name)
      {
          if(isset($_SESSION[$name])) unset($_SESSION[$name]);else error::newError(" $name diye bir session bulunamadı ");
      }

  }