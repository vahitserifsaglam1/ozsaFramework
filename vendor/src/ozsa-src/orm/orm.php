<?php


 class ORM
 {

     protected $tableNames;
     protected $columns;
     protected $queryHistory;
     protected $dbDatabase;
     protected $mixed;
     protected $set;
     protected $get;
     protected $limit;
     protected $where;
     protected $selectedTable;
     protected $like;
     protected $join;
     protected $string;

     public function __construct($table = '')
     {
         $options = require APP_PATH.'Configs/Configs.php';
         $options = $options['db'];
         extract($options);

         if(class_exists('PDO')){
             try{
                 $this->dbDatabase = new PDO("mysql:host=$host;dbname=$dbname;",$username,$password);
             }catch(PDOException $e)
             {
                 throw new Exception($e->getMessage());
             }

         }
         else {
             throw new Exception('PDO sınıfınız bulunamadı');
         }

          $this->selectedTable = $table;

         return  $this->returnTables();
     }


     public function returnTables()
     {
           $tableQuery = $this->dbDatabase->query("SHOW TABLES");

           while($tableFetch = $tableQuery->fetch(PDO::FETCH_BOTH))
           {
              $tableName[$tableFetch[0]] = array();
               $this->tableNames[] = $tableFetch[0];

               $qur = $this->dbDatabase->query("describe $tableFetch[0]");
               while($columns = $qur->fetch(PDO::FETCH_ASSOC))
               {

                  $tableName[$tableFetch[0]][]= $columns['Field'];
                   $this->columns[]= $columns['Field'];
               }
           }
         return $this->mixed = $tableName;

     }
     public function addSet($set,$value)
     {

        $this->set[$this->selectedTable][] = array($value => $set);
         return $this;

     }
    public function AddSelect($select)
    {
        foreach ($select as $selectedKey)
        {
            $this->get[$this->selectedTable] = $selectedKey;
        }
    }
     public function addGet($value)
     {
         $this->get[$this->selectedTable][] = $value;
         return $this;
     }
     public function AddLimit($veriler = array())
     {
         $this->limit[$this->selectedTable] = $veriler;
         return $this;
     }
     public function AddWhere($veriler = array())
     {
       
       if(in_array('like', $veriler)) $this->like[$this->selectedTable] = $veriler['like'];
        $this->where[$this->selectedTable] = $veriler;
         return $this;
     }
     public function __call($name,$params)
     {

         $ac = substr($name,0,3);


         if($ac == 'Get') { $this->addGet(str_replace("Get","",$name));}
         elseif($ac == 'Set') { $this->addSet($params[0],str_replace("Set","",$name));}
         return $this;

     }
     public function returnTableNames()
     {
         return $this->tableNames;
     }
     public function returnColumns(){
         return $this->columns;
     }
     public function returnMixed()
     {
         return $this->mixed;
     }
     public function mixer(array $array,$end)
     {
         $s = "";

       foreach($array as $k )
       {

           foreach($k as $key => $value)
           {
               $s .= $key.'='. "'$value'".$end;
           }

       }
         return rtrim($s,$end);


     }

     public function wherer($array)
     {
         $s = "";
         foreach ( $array as $whereKey => $whereValue)
         {
              $s .= $whereKey.'='."'$whereValue' AND";
         }
         return rtrim($s," AND");
     }
     public function liker(array $array)
     {

             foreach (  $array as $likeKey => $likeValue)
             {
                 $like = $likeKey.' LIKE '.$likeValue.' ';
             }
             return $like;

     }
     public function joiner($join)
     {
         foreach($join as $joinKey => $joinVal)
         {
             $val = $joinKey.' '.$joinVal[0].' ON '.$joinVal[0].'.'.$joinVal[1].' = '.$this->selectedTable.'.'.$joinVal[2];
         }

         return $val;
     }
     public function limiter($limit)
     {
         $limitbaslangic = $limit[0];
         $limitson = $limit[1];

         return $limitbaslangic.','.$limitson.' ';
     }
     public function selecter(array $select)
     {

          $s = '';
          foreach ( $select as $selectKey)
          {
              $s .= $selectKey.',';
          }
         return rtrim($s,',');
     }
     public function save()
     {
          $table = $this->selectedTable;

         $msg = ' INSERT INTO '.$this->selectedTable.' SET '.$this->wherer($this->set[$table]);

         return $this->query($msg);

     }
     public function update()
     {
         $table = $this->selectedTable;
         $where = $this->where[$table];

          $msg = ' UPDATE '.$table.' SET '.$this->mixer($this->set[$table],', ').' WHERE '.$this->wherer($where);
          return $this->query($msg);
     }
     public function delete()
     {
         $table = $this->selectedTable;
         $where = $this->where[$table];
         $msg = 'DELETE FROM '.$table.' WHERE '.$this->wherer($where);
         return $this->query($msg);
     }
     public function select()
     {
         $table = $this->selectedTable;
         $where = $this->where[$table];
         $like  = $this->like[$table];
         $join  = $this->join[$table];
         $limit = $this->limit[$table];

         //where baslangic

          if(is_array($where))
          {
              $where = $this->wherer($where);
          }
         // where son

         // like baslangic
         if(is_array($like))
         {
           $like =   $this->liker($like);
         }
         // like son

         //join baslangic

         if(is_array($join))
         {
             $join = $this->joiner($join);
         }

         //join son

         //select baslangic

            $select = $this->selecter($this->get[$table]);

         //select son

         //limit başlangıç

            $limit =  $this->limiter($limit);

         //limit son

         $msg = 'SELECT '.$this->selecter($this->get[$table]).' FROM '.$this->selectedTable.' ';

         if ( isset($join) && is_string($join) )
         {
            $msg .= $join;
         }

         if ( isset ($where) && is_string($where) )
         {
              $msg .= ' WHERE '.$where;
         }

         if( isset($like) && is_string($like) )
         {
             if( isset( $where ) && is_string( $where )) $msg .= ' AND '.$like;
             else $msg .= ' WHERE '.$like;
         }

         if ( isset($limit ) && is_string($limit) )
         {
             $msg .= ' LIMIT '.$limit;
         }

         $this->query($msg);

        return $this;

     }
     public function query($msg)
     {

          if(is_string($msg))
          {
              $return =  $this->dbDatabase->query($msg);
          }
          if($return) {$this->string = $return;}else{$this->string = false;}
          return $return;
     }
     public function fetch($type = PDO::FETCH_OBJ)
     {

               return $this->string->fetch($type);

     }
     public function fetchAll()
     {
              return   $this->string->fetchAll();
     }
     public function AddJoin($join)
     {
        $this->join[$this->selectedTable] = $join;
         return $this;
     }
     public function flush()
     {
         $this->set = array();
         $this->get = array();
         $this->mixed = array();
         $this->columns = array();
         $this->tableNames = array();
         $this->where = array();
         $this->join = array();
         $this->limit = array();
         $this->like = array();

     }
     public function setSelected($selected)
     {
       $this->selectedTable = $selected;
         $this->flush();
         return $this;
     }
 }


