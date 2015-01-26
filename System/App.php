<?php


  class App
  {
       public static function IncludeSystemFiles()
       {
           include "app/Configs/SystemFiles.php";

           foreach($SystemFiles as $key)
           {
                if(file_exists($key))
                {
                     include $key;
                }
               else{
                   echo " Bir Sistem dosyası olan $key bulunamadı ";
               }
           }
       }
  }


?>