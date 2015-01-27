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
      public static function InitSystemClasses()
      {
        include "app/Configs/SystemInits.php";
          foreach($SystemInits as $key)
          {
              if(class_exists($key))$key::init();
          }
      }
  }


?>