 <?php

      class mainController extends pdo
      {

          public function __construct(){
              global $database;
              parent::__construct("mysql:host=".$database['host'].";dbname=".$database['dbname'],$database['username'],$database['password']);
              parent::query("SET NAMES UTF8");
          }


 }

     ?>