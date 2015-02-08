<?php

 namespace Database\Exceptions\TableExceptions;

    class undefinedTableException
    {

           public function __construct( $message  )

           {
               if( is_string($message) )

               {
                   echo $message;

               }
               elseif ( is_callable( $message ))
               {

                   return $message();

               }


           }
    }