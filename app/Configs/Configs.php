<?php

 return [

     'URL' => 'http://localhost/ses/',



     /**
      *   Doğrulama ayarları i
      *
      *   autovalidate açık olursa modal larda otomatik doğrulama yapabilirsinşz
      */


     'Validate' =>


        [

           'autoValidate' => true,
            'validateFolder' => __DIR__."/Validate"
        ],

     'alias' =>

     [

         'test' => 'vendor/src/ozsa-src/Support/Facede/test.php'

     ]

];



?>