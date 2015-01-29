<?php
   set_error_handler('MyErrorHandler',E_ALL);

   function MyErrorHandler($errstr, $errno, $errline, $errfile)
   {
       global $errorConfigs;
       error::newError(array($errstr, $errno, $errline, $errfile));
   }

   function error_logOzsa($errstr, $errno = false , $errline = false , $errfile = false)
     {
         $config = require APP_PATH."Configs/Configs.php";
         $errorConfigs = $config['Error'];
         $time = date('H:i');
         $date = date('d.m.Y');
        if(!$errno) $content = ">>User Error :: $errstr [ Time : $time | Date : $date ]".PHP_EOL;
         else $content = ">>System Error :: Message => $errstr | ErrorNo => $errno | ErrorFile => $errfile | ErrorLine  => $errline |  [ Time : $time | Date : $date ] ".PHP_EOL;
         $path = $errorConfigs['logFilePath'];
           if($errorConfigs['writeLog'])
           {
             $ac = fopen($path,"a");
               $yaz = fwrite($ac,$content);
                fclose($ac);
           }
     }