<?php
 include "error/Error.php";
 set_error_handler("myErrorHandler");
 include "db-config.php";
 include "System/controller.php";
 $db = new mainController();
 include "plugins/functions.php";
 include "plugins/hook.php";
 include "Lib/ipBlock.php";
 include "Lib/sessionCookie.php";
 include "Lib/ob.php";
 include "Lib/file.php";
 include "Lib/db.php";
 include "System/New.php";
   DB::init();
 include "Lib/set.php";
 include "Lib/get.php";
 include "plugins/default.php";
 include "Lib/security.php";
 include "Lib/form.php";
 include "Lib/View.php";
 include "System/Core.php";

 new bootstrap();



