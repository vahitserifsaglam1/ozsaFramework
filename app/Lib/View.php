<?php 
 

   class View{
   	  public static function render($path,$allInclude = false)
   	  {
         $ViewPath = "app/Views/";
   	  	 $path = $ViewPath.$path.".php";
   	  	  if(file_exists($path))
   	  	  {
              if($allInclude)
              {
                  include $ViewPath."header.php";
                  include $path;
                  include $ViewPath."footer.php";
              }else{
                  include $path;
              }

   	  	  }else{
   	  	  	error::newError("$path View Dosyası bulunamadı");
   	  	  }
   	  }
   }

?>