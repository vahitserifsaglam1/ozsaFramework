<?php
error_reporting(E_ALL);
include "vendor/autoload.php";
if($HomePage != "index.php") include $HomePage;
require $appPath."Configs/Configs.php";
require $SystemPath."App.php";
new bootstrap();



