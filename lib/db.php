<?php
 class DB
 {
     public static $db;
     public static function init(){
      global $db;
      self::$db = $db;
     }
     public static function select($table,$where,$order = "")
     {
         if(is_array($where))
           {
            $where = self::render($where," AND ");
           }
         $query = "SELECT * FROM $table WHERE $where";
         if($order != "")
         {
              $query .= "ORDER BY $order";
         }
      
         $sorgu = self::$db->query($query)->fetch(PDO::FETCH_OBJ);

         return ($sorgu) ? $sorgu:false;
     }
     public static  function update($table,$values = array(),$where = array())
     {
          $values = self::render($values,",");
          $where =  self::render($where," AND ");

         $query = "UPDATE $table SET $values WHERE $where";

         return (self::$db->query($query)) ? true:false;
     }
     public static function insert($table,$values)
     {
         $values = self::render($values);
         $query = "INSERT $table SET $values";
           return (self::$db->query($query)) ? true:false;
     }

     public static function delete($table,$where)
     {
         $where = self::render($where);
         $query = "DELETE FROM $table WHERE $where";
         return (self::$db->query($query)) ? true:false;
     } 
    
     public static function render($values = array(),$end = ",")
     {
         $d = "";
         foreach ($values as $key => $value)
         {
             $d .= "$key='$value'".$end;
         }
         $d = rtrim($d,$end);
         return $d;
     }
     public static function __callStatic($name,$params)
     {
          return call_user_func_array(array(self::$db,$name),$params);
     }
 }