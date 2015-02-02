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
                  'charset' => 'utf-8',
           'sqlite' => array(
               'database' => 'dbname'
           )
       ),

      'Session' => array
      (
          'type' => 'Ozsa',
            'SessionFolder' => APP_PATH.'Stroge/Session'
      ),

     'Error' => array
     (
         'Reporting' => 0,
          'logFilePath' => APP_PATH.'Logs/error.log',
           'writeLog' => true
     )
     ,'Validate' =>
       array(
           'autoValidate' => true,
            'validateFolder' => __DIR__."/Validate"
       )

 );



?>