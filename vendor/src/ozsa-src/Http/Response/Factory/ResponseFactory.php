<?php

   namespace Http\Response\Factory;


   class ResponseFactory{

        protected $response;

        protected $view;

       public function __construct( $response, $view )
       {

           $this->response = $response;

           $this->view = $view;

       }

       public  function make($content = '', $status = 200, array $headers = array())
       {

           return $this->response->create($content, $status, $headers);
       }

       public function view($view, $data = array(), $status = 200, array $headers = array())
       {
           return static::make($this->view->load($view,false,$data), $status, $headers);
       }


       public function __call($name,$params)
       {

           return call_user_func_array(array($this->response,$name),$params);

       }


   }