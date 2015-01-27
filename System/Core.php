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
              include "app/Controller/index.php";
              new index();
              include "app/Modals/index_Modal.php";
              new index_Modal();          
          }else{
          if(isset($controller))
          { 
              $controllerFile =  "app/Controller/$controller.php";
              if(file_exists($controllerFile)){
                  if(class_exists($controller)){
                      $modalfile = "app/Modals/$controller"."_modal.php";
                      $modalname = $controller."_modal";
                      if(method_exists($controller,$modal)){
                          if(isset($arg)){ $controller = new $controller(); $controller->$modal($arg);

                          if(file_exists($modalfile)){include $modalfile; new $modalname();} }
                          else{$controller = new $controller($arg);}
                      }else{
                          if(file_exists($modalfile)){include $modalfile;
                            if(isset($arg))
                            {
                                $modaln = new $modalname();
                                $modaln->$modal($arg);
                            }else{
                                $modaln = new $modalname($arg);
                            }
                          }
                      }
                  }
              }
          }
       }
    }
}
