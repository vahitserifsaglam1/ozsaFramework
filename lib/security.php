<?php 

 class security {
      public static function render($veri,$md5 = false)
      {
          $return = htmlspecialchars(htmlentities(strip_tags(str_replace(array("<", ">", "<script>", "</script>"), "", $veri))));
          if (!$md5) {
              return $return;
          } else {
              return md5($return);
          }
      }
     public  static  function loginCheck()
     {
         global $db;
         if(Sessions::get("login")){
              $username = Session::get("login")['username'];
             if($username){
                  $kontrol = $db->query("SELECT username FROM username = '$username'")->rowCount();
                  return ($kontrol) ? true:false;
             }
         }else{
             return false;
         }
     }
 } ?>