<?php

 return [

     'URL' => 'http://localhost/framework/',


     /**
      *
      *  Session Ayarları
      *
      *
      *   Desteklenen tipler 'ozsa','php' ,'json'
      *
      */

      'Session' =>

      [

          'type' => 'ozsa',

            'SessionFolder' => APP_PATH.'Stroge/Session'

     ],

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
      [

        'type' => 'file',

           'CacheFolder' => APP_PATH.'Stroge/Cache'

      ],


     /**
      *
      *  Error bildirme ayarları
      *
      *   Dokunmamanız tavsiye edilir
      *
      */


     'Error' =>


            [
             'Reporting' => 0,

             'logFilePath' => APP_PATH.'Logs/error.log',

              'writeLog' => true

            ]

     /**
      *   Doğrulama ayarları i
      *
      *   autovalidate açık olursa modal larda otomatik doğrulama yapabilirsinşz
      */


     ,'Validate' =>


        [

           'autoValidate' => true,
            'validateFolder' => __DIR__."/Validate"
        ]

];



?>