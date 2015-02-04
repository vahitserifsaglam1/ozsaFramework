<?php
/**
 *
 *   ****************************
 *
 *     Ozsa framework standart ayar sayfası
 *
 *
 *    **********************
 *
 */
 return array (

     /**
      *
      *   Mysql Veritabanı ayarları
      *
      */

       'db' =>
       array(
         'host' => 'localhost',
           'dbname' => 'framework',
            'username' => 'root',
              'password' => '',
                'type' => 'PDO',
                  'charset' => 'utf-8',
           /**
            *
            *
            *  Sqlite veri tabanı ayarları
            *
            *
            */
           'sqlite' => array(
               'database' => 'dbname'
           )
       ),
     /**
      *
      *
      *
      *  Session Ayarları
      *
      *
      *   Desteklenen tipler 'ozsa','php' ,'json'
      *
      *
      */
      'Session' => array
      (
          'type' => 'ozsa',
            'SessionFolder' => APP_PATH.'Stroge/Session'
      ),

     /**
      *
      *  Önbellekleme Ayarları
      *
      *  **********
      *
      *   Desteklenen Tipler :  'memcache','apc' ,'file'
      *
      */

      'Cache' =>
      array(
        'type' => 'file',
           'CacheFolder' => APP_PATH.'Stroge/Cache'
      ),
     /**
      *
      *  Error bildirme ayarları
      *
      *   Dokunmamanız tavsiye edilir
      *
      */
     'Error' => array
     (
         'Reporting' => 0,
          'logFilePath' => APP_PATH.'Logs/error.log',
           'writeLog' => true
     )

     /**
      *   Doğrulama ayarları i
      *
      *   autovalidate açık olursa modal larda otomatik doğrulama yapabilirsinşz
      */
     ,'Validate' =>
       array(
           'autoValidate' => true,
            'validateFolder' => __DIR__."/Validate"
       )

 );



?>