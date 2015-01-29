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
                'type' => 'PDO',
                  'charset' => 'utf-8'
       ),
      'Session' => array
      (
          'type' => 'Ozsa',
            'SessionFolder' => APP_PATH.'Stroge/Session'
      ),
      'Cookie' => array(
            'type'=>'Php',
              'CookieFolder' => APP_PATH.'Stroge/Session'
      ),
     'Error' => array
     (
         'Reporting' => 0,
          'logFilePath' => APP_PATH.'Error/error.log',
           'writeLog' => true
     )
     ,'Validate' =>
       array(
           'autoValidate' => true,
            'validateFolder' => __DIR__."/Validate"
       )

 );



?>