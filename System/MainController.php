 <?php

      class mainController
      {

          public function __construct(){
          	global $db;
           
            $this->db = $db;
             
          }
      public function __call($name,$params)
      {
      	return call_user_func_array(array($this->db,$name), $params);
      }
      public static function __callStatic($name,$params)
      {
      	return call_user_func_array(array($this->db,$name), $params);
      }

 }

     ?>