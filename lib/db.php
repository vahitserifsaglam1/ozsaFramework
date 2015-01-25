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

     public function select($select,$table,$where,$order = "")
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

     public function update($table,$values = array(),$where = array())
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

     public function insert($table,$values)
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

     public function delete($table,$where)
     {
         $where = $this->render($where);

         $query = "DELETE FROM $table WHERE $where";

         return (parent::query($query)) ? true:false;
     }

     /**
      * @param $table
      * @param array $where
      * @return int
      */

     public function rowCount($table,$where = array())
     {
         if(is_array($where))
         {
             $where = $this->render($where," AND ");
         }

         $query = "SELECT * WHERE TABLE FROM $table WHERE $where";
         return parent::query($query)->rowCount();
     }

     /**
      * @param array $values
      * @param string $end
      */

     public function  render($values = array(),$end = ",")
     {
         $d = "";
         foreach ($values as $key => $value)
         {
             $d .= "$key=$values".$end;
         }
         $d = rtrim($d,$end);
     }
 }