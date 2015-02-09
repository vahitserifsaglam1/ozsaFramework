<?php


     namespace Http;

     use Http\Response\Factory\ResponseFactory as Factory;

     use Symfony\Component\HttpFoundation\Response as Res;

     class Response
     {

         public $factory;

          public function __construct($content = '', $status = 200, array $headers = array())
          {

               $this->factory = new Factory( new Res(),new \View());

              if($content !== '')
              {

                  $this->factory->make($content, $status , $headers );

              }

          }
         public function __call($name,$params)
         {

           return call_user_func_array(array($this->factory,$name),$params);

         }

         public static function __callStatic($name,$params)
         {

             $s = new static();

             return call_user_func_array(array($s->factory,$name),$params);

         }

     }
