<?php

class bootstrap {
       public  function __construct(){
          @$url = $_GET['url'];
          $url = explode("/",$url);
          set::variable('url',$url);
          @$controller = $url[0];
          @$modal = $url[1];
          @$arg = $url[2];
          if(count($url) == 1 && $url[0] == "")
          {
              include "Controller/index.php";
              new index();
              include "Modals/index_Modal.php";
              new index_Modal();          
          }else{
          if(isset($controller))
          { 
              include "Controller/$controller.php";
              new $controller();

              if(isset($arg))
              {
                 $modalname = $modal."_Modal";
                 include "Modals/$modalname.php";
                 new  $modalname($arg);
               }else{
                 $modalname = $modal."_Modal";
                include "Modals/$modalname.php";
                new $modalname();
              }
          }
       }
    }
}
