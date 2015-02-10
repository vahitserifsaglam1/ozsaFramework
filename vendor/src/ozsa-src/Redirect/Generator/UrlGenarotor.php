<?php

 namespace Redirect\Genarator;


 class UrlGenarator
 {

  public $baseurl;

  private $url;

     private $base;

  protected $filesystem;

  public function __construct( $baseurl = '')
  {

    $this->baseurl = $baseurl;

    $this->filesystem = \Filesystem::boot('Local');

      $base = require APP_PATH.'Configs/Configs.php';

      $this->base = $base['URL'];



  }

  public static function boot( $baseurl = '')
  {

    return new static($baseurl);

  }

  public function generator( $url )
  {

       $this->url = $url;

       return $this->urlCheck( $url );

  }

  private function urlCheck( $url )
  {

      if($this->controllerCheck( $url )){

          return true;

      }

  }

  private function controllerCheck( $name )
  {

    $controller = array_slice(\App\App::urlParse(),0,1);

    $kontrol = array_get($controller,0);


    $name = $kontrol.'.php';

     if( $this->filesystem->exists(APP_PATH.'Controller/'.$name))
     {

          $return = true;

         if(isset($controller[2]) && method_exists($kontrol,$controller[1]))
         {

            $return = true;

         }else{

             $return = true;

         }

     }else{

         $return = false;

     }

      return $return;



  }

     public function requestCheck( $request, $url )
     {


         $get = $request->get( $this->base.$url);

         if( $get->getStatusCode() === 200 )
         {

             return true;

         }else{

             return false;
         }




     }





 }