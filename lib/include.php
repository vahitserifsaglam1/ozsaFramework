<?php
 function __autoload($classname)
 {
 	 if(!class_exists($classname))
 	 {
 	 	 $include = "lib/{$classname}.php";
     if (file_exists($include))
        {
             include_once($include);
	    }
 	 }
    
}
 include "error/error.php";
 set_error_handler("myErrorHandler");
 include "lib/db-config.php";
 include "lib/controller.php";
 include "lib/functions.php";
 include "lib/hook.php";
 include "sessionCookie.php";
 include "lib/ob.php";
 include "lib/set.php";
 include "lib/get.php";
 include "plugins/default.php";
 include "lib/security.php";
 include "lib/form.php";
 include "lib/View.php";
 $bootstrap = new bootstrap();
 


