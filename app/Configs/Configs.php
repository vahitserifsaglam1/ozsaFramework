<?php
$GLOBALS['frameWorkOptions'] = array(
    'authorWebSite' => "http://www.ozsabilisim.org",
    'frameWorkVersion' => '1.1.1',
    'standartControllerError' => true
);
$GLOBALS['database'] =  array(
    'host' => "localhost",
    'dbname' => 'cmv',
    'username' => 'root',
    'password' => "",
    'dataType' => 'PDO', # Desteklenen 'PDO','mysqli','mysql'
    'charset' => 'utf-8'
);
 extract($GLOBALS['database']);