 <?php

      class mainController extends pdo
      {

          public function __construct(){
              global $host,$dbname,$username,$password;
              parent::__construct("mysql:host=$host;dbname=$dbname",$username,$password);
              parent::query("SET NAMES UTF8");
          }


 }

     ?>