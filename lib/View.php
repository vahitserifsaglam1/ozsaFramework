<?php 
 

   class View{
   	  public static function render($path,$allInclude = false)
   	  {
   	  	 $path = "Views/".$path.".php";
   	  	  if(file_exists($path))
   	  	  {
              if($allInclude)
              {
                  include "Views/header.php";
                  include $path;
                  include "Views/footer.php";
              }else{
                  include $path;
              }

   	  	  }else{
   	  	  	error::newError("$path View Dosyası bulunamadı");
   	  	  }
   	  }
   }

?>