<?php

/**
 * Class ORM
 *
 *   *******************************************
 *
 *    Ozsaframe Work basit ama hızlı bir orm sınıfı
 *
 *
 *   *****************************************
 *
 * @packpage Ozsaframework
 * @version 1.1
 *
 *
 */

 class ORM
 {
     /**
      * @var $tableNames
      * @var $columns
      * @var $queryHistory
      * @var $dbDatabase
      * @var $mixed
      * @var $set
      * @var $get
      * @var $limit
      * @var $where
      * @var $selectedTable
      * @var $like
      * @var $join
      * @var $string
      * @access protected
      */
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
     protected $setLog = false;

     /**
      * @param string $table
      * @throws Exception
      * @return mixed
      */
     public function __construct($table = '',$setlog = false)
     {
         $this->setLog = $setlog;
         $options = require APP_PATH.'Configs/databaseConfigs.php';
         $options = $options['Connections']['mysql'];
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

     /**
      * @return mixed
      */
     public function returnTables()
     {
           $tableQuery = $this->dbDatabase->query("SHOW TABLES");

             $tableName = '';
           while($tableFetch = $tableQuery->fetch(PDO::FETCH_BOTH))
           {
              $tableName[$tableFetch[0]] = array();
               $this->tableNames[] = $tableFetch[0];


               $qur = $this->dbDatabase->query("describe $tableFetch[0]");
               while($columns = $qur->fetch(PDO::FETCH_ASSOC))
               {

                  $tableName[$tableFetch[0]][]= $columns;
                   $this->columns[]= $columns;
               }
           }
        $this->mixed = $tableName;

         $this->createJson();
         return $this->mixed;


     }

     public function createJson()
     {
         $path = APP_PATH.'Configs/orm.json';

         $json = json_encode($this->mixed);

         if(!file_exists($path)) touch($path);
         file_put_contents($path,$json);
     }

     /**
      * @param $set
      * @param $value
      * @return $this
      */
     public function addSet($set,$value)
     {

        $this->set[$this->selectedTable][] = array($value => $set);
         return $this;

     }

     /**
      * @param $select
      */
    public function AddSelect($select)
    {
        foreach ($select as $selectedKey)
        {
            $this->get[$this->selectedTable] = $selectedKey;
        }
    }

     /**
      * @param $value
      * @return $this
      */
     public function addGet($value)
     {
         $this->get[$this->selectedTable][] = $value;
         return $this;
     }

     /**
      * @param array $veriler
      * @return $this
      */
     public function AddLimit($veriler = array())
     {
         $this->limit[$this->selectedTable] = $veriler;
         return $this;
     }

     /**
      * @param array $veriler
      * @return $this
      */
     public function AddWhere($veriler = array())
     {
       
       if(in_array('like', $veriler)) $this->like[$this->selectedTable] = $veriler['like'];
        $this->where[$this->selectedTable] = $veriler;
         return $this;
     }

     /**
      * @param $name
      * @param $params
      * @return $this
      */
     public function __call($name,$params)
     {

         $ac = substr($name,0,3);


         if($ac == 'Get') { $this->addGet(str_replace("Get","",$name));}
         elseif($ac == 'Set') { $this->addSet($params[0],str_replace("Set","",$name));}
         return $this;

     }

     /**
      * @return mixed
      */
     public function returnTableNames()
     {
         return $this->tableNames;
     }

     /**
      * @return mixed
      */
     public function returnColumns(){
         return $this->columns;
     }

     /**
      * @return mixed
      */
     public function returnMixed()
     {
         return $this->mixed;
     }

     /**
      * @param array $array
      * @param $end
      * @return string
      */
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

     /**
      * @param $array
      * @return string
      */
     public function wherer($array)
     {
         $s = "";
         foreach ( $array as $whereKey => $whereValue)
         {
              $s .= $whereKey.'='."'$whereValue' AND";
         }
         return rtrim($s," AND");
     }

     /**
      * @param array $array
      * @return string
      */
     public function liker(array $array)
     {

             foreach (  $array as $likeKey => $likeValue)
             {
                 $like = $likeKey.' LIKE '.$likeValue.' ';
             }
             return $like;

     }

     /**
      * @param $join
      * @return string
      */
     public function joiner($join)
     {
         foreach($join as $joinKey => $joinVal)
         {
             $val = $joinKey.' '.$joinVal[0].' ON '.$joinVal[0].'.'.$joinVal[1].' = '.$this->selectedTable.'.'.$joinVal[2];
         }

         return $val;
     }

     /**
      * @param $limit
      * @return string
      */
     public function limiter($limit)
     {
         $limitbaslangic = $limit[0];
         $limitson = $limit[1];

         return $limitbaslangic.','.$limitson.' ';
     }

     /**
      * @param array $select
      * @return string
      */
     public function selecter(array $select)
     {

          $s = '';
          foreach ( $select as $selectKey)
          {
              $s .= $selectKey.',';
          }
         return rtrim($s,',');
     }

     /**
      * @return PDOStatement
      */
     public function create()
     {
          $table = $this->selectedTable;

         $msg = ' INSERT INTO '.$this->selectedTable.' SET '.$this->wherer($this->set[$table]);

         return $this->query($msg);

     }

     /**
      * @return PDOStatement
      */
     public function update()
     {
         $table = $this->selectedTable;
         $where = $this->where[$table];

          $msg = ' UPDATE '.$table.' SET '.$this->mixer($this->set[$table],', ').' WHERE '.$this->wherer($where);
          return $this->query($msg);
     }

     /**
      * @return PDOStatement
      */
     public function delete()
     {
         $table = $this->selectedTable;
         $where = $this->where[$table];
         $msg = 'DELETE FROM '.$table.' WHERE '.$this->wherer($where);
         return $this->query($msg);
     }

     /**
      * @return $this
      */
     public function read()
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

     /**
      * @param $msg
      * @return PDOStatement
      */
     public function query($msg)
     {

          if(is_string($msg))
          {
              $return =  $this->dbDatabase->query($msg);
          }
         if($this->setLog)
         {
             $this->setHistoryLog($msg);
         }
          if($return) {$this->string = $return;}else{$this->string = false;}
          return $return;
     }

     /**
      * @param int $type
      * @return mixed
      */
     public function fetch($type = PDO::FETCH_OBJ)
     {

               return $this->string->fetch($type);

     }

     /**
      * @return mixed
      */
     public function fetchAll()
     {
              return   $this->string->fetchAll();
     }

     /**
      * @param $join
      * @return $this
      */
     public function AddJoin($join)
     {
        $this->join[$this->selectedTable] = $join;
         return $this;
     }

     /**
      * @param $log
      * @return null
      */
     protected function setHistoryLog($log)
     {
         if($this->setLog)
         {
             $time = date("H:i");
             $date = date("d.m.Y");
             $msg = 'Query History >> [ time : '.$time.' ; date : '.$date. ' ] >'.$log." \n";
             $path = APP_PATH.'Logs/ormlog.log';

             $ac = fopen($path,"a");
             $yaz  = fwrite($ac,$msg);
             fclose($ac);
         }
         return null;

     }

     /**
      *  @return null
      */
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
         return null;
     }

     /**
      * @param $selected
      * @return $this
      */

     public function setSelected($selected)
     {
       $this->selectedTable = $selected;
         $this->flush();
         return $this;
     }
 }


