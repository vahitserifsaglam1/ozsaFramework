<?php

  class file{
      public static function createFolder($path)
      {
           if(file_exists($path))
           {
                error::newError("$path Bu İsimde bir dosya zaten var");
               return false;
           }
          else
          {
              mkdir($path);
              return true;
          }
      }
      public static function deleteFolder($path)
      {
           if(file_exists($path))
           {
               $sil = rmdir($path);
               if($sil) {
                   return true;
               }
               else{
                   error::newError("Dosya silinirken bir hatayla karşılaşıldı");
                   return false;
               }
           }else{
               error::newError("$path Böyle bir dosya bulunamadı");
               return false;
           }
      }
      public static function modFolder($path,$folder)
      {
           if(file_exists($path)) {
               chmod($path, $folder);
               return true;
           }else{
               error::newError("$path Böyle bir dosya yok");
               return false;
           }
      }
      public static function createFile($path)
      {
          if(file_exists($path))
          {
              error::newError("$path Bu isimde bir dosya zaten var");
              return false;
          }else{
              touch($path);
              return true;
          }
      }
      public static function  deleteFile($path)
      {
           if(file_exists($path))
           {
               unlink($path);
               return true;
           }else{
               error::newError("$path Böyle bir dosya bulunmadı");
           }
      }
      public static function readFile($path)
      {
          if(file_exists($path))
          {
               $ac = fopen($path,"r");
               $oku = fgets($ac);
               fclose($ac);
              return $oku;
          }else{
              error::newError("$path Böyle bir dosya bulunamadı");
          }
      }
      public  static function writeFile($path,$write)
      {
          if(file_exists($path)){
              $ac = fopen($path,"w");
              $yaz = fwrite($ac,$write);
              fclose($ac);
          }else{
              error::newError("$path Böyle bir dosya bulunamadı");
          }

      }
      public  static function checkFile($path)
      {
          if(file_exists($path))
          {
              return true;
          }else{
              return false;
          }
      }
      public static function checkDir($path)
      {
         if(file_exists($path))
           {
             if(is_dir($path))
             {
               return true;
             }else{
              return false;
             }
           }else{
            error::newError("$path dosyası bulunamadı");
            return false;
           }
      }
      public static  function includeFile($path){
          if(self::checkFile($path))
          {
               include $path;
              return true;
          }else{
              return false;
          }
      }
  }
