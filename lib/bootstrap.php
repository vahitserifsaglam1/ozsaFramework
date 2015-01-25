<?php

  class bootstrap {
       public  function __construct(){
           @$url = $_GET['url'];
           $url = explode("/",$url);
           global $set;
            set::variable("url",$url);
           if(isset($url[0]))
           {
                global $security;
                $url[0] = security::render($url[0]);
                
                
                if(isset($url[1]))
                {
                    $url[1] = security::render($url[1]);
                    $db = new mainController();
                    $controllerfile = "Controller/".$url[0].".php";
                    if(file_exists($controllerfile)){
                        include $controllerfile;
                        if(class_exists($url[0]))
                        {
                          $controller = new $url[0];
                        }else{
                          include "standartController.php";
                          $controller = new standartController($url[0]);
                        }
                        
                    }else{
                        error::newError("HATA : $controllerfile bulunamadı");
                    }
                    $modalurl = "Modals/".$url[0]."_modal.php";
                    $modalname = $url[0]."_modal";

                    if(file_exists($modalurl))
                    {
                        include $modalurl;
                        
                        if(isset($url[2]))
                        {
                            $url[2] = security::render($url[2]);
                            $c = new $modalname();
                            if(method_exists($c,$url[1])){
                                $c->$url[1]($url[2]);
                            }else{
                                $c = new $modalname($url[1],$url[2]);
                            }


                        }else{

                            $c = new $modalname();
                           if(method_exists($c, $url[1]))
                           {
                            $c->$url[1]();
                           }else{
                            $c = new $modalname($url[1]);
                           }
                        }
                    }else{
                        if(method_exists($controller,$url[1])){
                            $controller->$url[1]($url[2]);
                        }else{
                            $controller = new $url[0]($url[1]);
                        }
                    }

                }else{
                  
                      $controllerfile = "Controller/".$url[0].".php";
                    if(file_exists($controllerfile)){
                        include $controllerfile;
                        if(class_exists($url[0]))
                        {
                          $controller = new $url[0];
                        }else{
                          include "standartController.php";
                          $controller = new standartController($url[0]);
                        }
                }
              }
           }else{
               include "Modals/index_modal.php";
               $c = new index_modal();
               $url[0] = "index";
           }

       }
  }