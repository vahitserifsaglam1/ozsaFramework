<?php
    define('OZSA_START',microtime(true));

    define('APP_PATH',dirname(__DIR__));
   
    $dbConfigs = require_once $pathOptions['appPath']."Configs/Configs.php";

    require_once APP_PATH."/".$pathOptions['appPath']."Error/errorException.php";

    require_once APP_PATH."/".$pathOptions['appPath']."Lib/Functions.php";

    require_once __DIR__."/autoload.php";


?>