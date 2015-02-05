<?php

  namespace Exceptions;


  class undefinedVariableExcepiton

  {

       public function __construct( $call,  $callSprintf = '' ){

           new \MyException($call);

           if(is_callable($callSprintf))
           {
               echo $callSprintf();
           }



       }

  }

