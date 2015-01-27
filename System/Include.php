<?php
error_reporting(E_ALL);
if($HomePage != "index.php") include $HomePage;
include $appPath.'Error/Error.php';
require $SystemPath."App.php";
require $appPath."Configs/Configs.php";
App::IncludeSystemFiles();
$db = new Multidb();
new bootstrap();



