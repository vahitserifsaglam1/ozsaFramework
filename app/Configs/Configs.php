<?php

 return array (
     /*******************************************************
      *   Standart Ayarlar
      * *****************************************************
      */
       'db' =>
       array(
         'host' => 'localhost',
           'dbname' => 'CMV',
            'username' => 'root',
              'password' => '',
                'type' => 'mysql'
       ),
      'Session' => array
      (
          'type' => 'Ozsa',
            'SessionFolder' => $pathOptions['appPath'].'Stroge/Session'
      ),
      'Cookie' => array(
            'type'=>'Php',
              'CookieFolder' => $pathOptions['appPath'].'Stroge/Session'
      ),
     'Error' => array
     (
         'Reporting' => 0,
          'logFilePath' => $pathOptions['appPath'].'Error/error.log',
           'writeLog' => true
     )
     ,'Validate' =>
       array(
           'autoValidate' => true,
            'validateFolder' => __DIR__."/Validate"
       )

 );



?>