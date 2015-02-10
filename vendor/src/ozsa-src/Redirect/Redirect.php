<?php


 use Http\Request;

  use Redirect\Genarator\UrlGenarator;

  class Redirect extends  Request
  {

    protected $generator;

    protected $request;

    protected static $static;


     public function  __construct()
     {

         if(!$this->request)
         {

             $this->request = Request::this();


         }

       if(!$this->generator)
       {


          $this->generator = UrlGenarator::boot($this->getUri());

       }

     }

    public static function boot(){

      self::$static =  new static;

      return self::$static;

    }

    public static function  intended( $url )
    {

       if( !static::$static )
       {

         static::boot();

       }

        if(self::$static->generator->generator( $url ))
        {

            self::$static->generator->requestCheck(static::$static->request,$url);

        }


    }


  }