<?php
class View{
     public static function render($path,$allInclude = false)
    {
      global $ViewsPath;
      $path = $ViewsPath.$path.".php";
      if(file_exists($path))
       {
          if($allInclude)
           {
             include $ViewsPath."header.php";
             include $path;
             include $ViewsPath."footer.php";
           }else{
            include $path;
           }
       }else{
        error::newError("$path View Dosyası bulunamadı");
       }
    }
}
