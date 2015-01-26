<?php

   set::variable("_php_version",PHP_VERSION);
   set::variable("_php_os",PHP_OS);
   set::variable("_host", $_SERVER['HTTP_HOST']);
   set::variable("_useragent", $_SERVER['HTTP_USER_AGENT']);
   if(class_exists('ipBlock')) set::variable("_ip",ipBlock::getIp());
   set::variable("_frameworkVersion",$frameWorkVersion);
   set::variable("_frameworkPath",dirname("../index.php"));

