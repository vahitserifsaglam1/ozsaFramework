<?php
    define('OZSA_START',microtime(true));

    define('APP_PATH',$pathOptions['appPath']);

    define('SYSTEM_PATH',$pathOptions['SystemPath']);

    define('INDEX',$pathOptions['HomePage']);

    $dbConfigs = require_once APP_PATH."Configs/Configs.php";

    require_once APP_PATH."Error/errorException.php";

    require_once APP_PATH."Lib/Functions.php";

    require_once __DIR__."/autoload.php";


?>