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
              $controllerFile =  "Controller/$controller.php";
              if(file_exists($controllerFile)){
                  if(class_exists($controller)) $controller = new $controller();
              }

              @$modalname = $modal."_Modal";
              @$modalFile = "Modals/$modalname.php";

              if(file_exists($modalFile))
              {
                  if(isset($arg))
                  {

                      if(class_exists($modalname)) new  $modalname($arg);

                  }else{

                      if(class_exists($modalname)) new  $modalname();

                  }
              }

              else{
                  if(isset($arg)) $controller->$modal($arg);
              }

          }
       }
    }
}
