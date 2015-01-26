<?php
  class error
  {
      public static $errorFile = "app/error/error.log";

      public static function newError($error)
      {

          if (is_array($error)) {

              $errstr = $error[0];
              $errno = $error[1];
              $errline = $error[2];
              $errfile = $error[3];
              if (!(error_reporting() & $errno)) {
                  // This error code is not included in error_reporting
                  return;
              }
              switch ($errno) {
                  case E_USER_ERROR:
                      echo "<br>Hata : </b> [$errno] $errstr<br />\n";
                      echo "  Ölümcül hatayla karşılaşıldı $errfile  dosyası $errline satırı";
                      echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
                      echo "Çıkılıyor.<br />\n";
                      exit(1);
                      break;

                  case E_USER_WARNING:
                      echo "<b>Uyarı : </b> [$errno] $errstr [On Line:[$errline] File:[$errfile]]<br />\n";
                      break;

                  case E_USER_NOTICE:
                      echo "<b>Bilgi : </b> [$errno] $errstr [On Line:[$errline] File:[$errfile]]<br />\n";
                      break;
                  default:
                      echo "Hata Mesaji: [$errno] $errstr    [On Line:[$errline] File:[$errfile]]<br />\n";
                      break;
              }
              self::setLog($errstr, $errno, $errline, $errfile);
          } else {
              echo "<br><b>HATA :</b> $error</br>";
              self::setLog($error);
          }
      }

      public static function setLog($errstr, $errno = false, $errline = "", $errfile = "")
      {
          $time = date('d.m.y H:i');
          $hata = ($errno) ? "[$time]>> $errstr : $errno : $errfile : $errline " . PHP_EOL : "[$time]>> $errstr " . PHP_EOL;
          $file = self::$errorFile;
          if (!file_exists($file)) {
              touch($file);
          }
          $ac = fopen($file, "a");
          $yaz = fwrite($ac, $hata);
          fclose($ac);
      }

      public static function useFiles($file = "app/error/error.log")
      {
          self::$errorFile = $file;
      }
  }
  function myErrorHandler($errno, $errstr, $errfile, $errline){
       error::newError(array($errstr,$errno,$errline,$errfile));
  }

