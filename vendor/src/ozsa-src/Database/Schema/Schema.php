<?php

 namespace Database;

 class Schema
 {

     public static function create( $tableName, $callAble )
     {
         $table = \Database\Schema\Blueprint::boot( $tableName );

         if( is_callable( $callAble) )
         {
             return $callAble($table);
         }
         else{

          throw new   \Exceptions\VariableExceptions\incorrentValueTypeException($callAble.' Bir çağrılabilir fonksiyon değil ');

         }

     }

     public static function rename(  $oldname, $newname  )
     {

         $finder= Finder\databaseFinder::boot( \Desing\Single::make('\Database\Connector\Connector'));

         $finder->returnDatabases();

         return $finder->changeName( $oldname,$newname );

     }




 }