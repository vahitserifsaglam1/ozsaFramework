<?php

        class View
        {
            public static function render($path,$allInclude = false)
            {
                $path = VIEW_PATH.$path.".php";

                if(file_exists($path))
                {
                    if($allInclude)
                    {
                        include VIEW_PATH."header.php";
                        include $path;
                        include VIEW_PATH."footer.php";
                    }else{
                        include $path;
                    }
                }else{
                    \error::newError("$path View Dosyası bulunamadı");
                }
            }
        }
  
      


 ?>