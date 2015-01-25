<?php

/**
 * Class db
 */
 class db extends mainController
 {
     /**
      * @param $select
      * @param $table
      * @param $where
      * @param string $order
      * @return bool|PDOStatement
      */

     public static function select($select,$table,$where,$order = "")
     {
         $query = "SELECT $select FROM $table WHERE $where";
         if($order != "")
         {
              $query .= "ORDER BY $order";
         }
         $sorgu = parent::query($query);
         return ($sorgu) ? $sorgu:false;
     }

     /**
      * @param $table
      * @param array $values
      * @param array $where
      * @return bool
      */

     public static  function update($table,$values = array(),$where = array())
     {
          $values = $this->render($values,",");
          $where =  $this->render($where," AND ");

         $query = "UPDATE $table SET $values WHERE $where";

         return (parent::query($query)) ? true:false;
     }

     /**
      * @param $table
      * @param $values
      * @return bool
      */

     public static function insert($table,$values)
     {
         $values = $this->render($values);
         $query = "INSERT $table SET $values";

           return (parent::query($query)) ? true:false;
     }

     /**
      * @param $table
      * @param $where
      * @return bool
      */

     public static function delete($table,$where)
     {
         $where = $this->render($where);

         $query = "DELETE FROM $table WHERE $where";

         return (parent::query($query)) ? true:false;
     }
     
     

     public function render($values = array(),$end = ",")
     {
         $d = "";
         foreach ($values as $key => $value)
         {
             $d .= "$key=$values".$end;
         }
         $d = rtrim($d,$end);
     }
 }