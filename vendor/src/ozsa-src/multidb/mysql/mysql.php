<?php

/**
 * Class mysql
 */
class mysql
{

    const FETCH_ASSOC = 'assoc';
    const FETCH_ROW = 'row';
    const FETCH_ARRAY = 'array';
    const FETCH_OBJ = 'object';
    const FETCH_FIELD = 'field';
    /**
     * @var resource
     *
     */
    private $con;
    /**
     * @var string
     */
    public $queryString;
    /**
     * @var string
     */
    private $errorMessage;

    /**
     * @param $host
     * @param $dbname
     * @param $username
     * @param $password
     */
    public function __construct($host,$dbname,$username,$password)
    {
        $this->con = mysql_connect($host,$username,$password);
        if(!$this->con) $this->errorMessage = mysqli_connect_error();
        mysql_select_db($dbname);
        return $this->con;
    }

    /**
     * @param $query
     * @return $this
     */
    public function query($query)
    {

        $this->queryString = $query;
        return $this;
    }

    /**
     * @return string
     */
    public function errorInfo()
    {
        return $this->errorMessage;
    }

    /**
     * @param $query
     * @return $this
     */
    public  function prepare($query)
    {
        $this->queryString = $query;
        return $this;
    }

    /**
     * @param array $exec
     * @return bool|mysql
     */
    public function execute($exec = array())
    {
        $query = $this->queryString;
        preg_match_all("/[?@#$%^]/", $query, $dondu);
        if( is_array($exec) )
        {
            $exec =  array_map('tirnak',$exec);
            $yeni =  str_replace($dondu[0], $exec, $query);
            $query = mysql_query($yeni);
            if(!$query) $this->$errorMessage = mysql_error();
            $this->queryString = $yeni;
            return ($query) ? $this:false;
        }else{
            error::newError("Doğru bir veri girilmemiş");
        }
    }

    /**
     * @param $type
     * @return bool
     */
    public function fetch($type = DB::FETCH_ASSOC)
    {
         $funcName = "mysql_fetch_".$type;
         $return =  $funcName(mysql_query($this->queryString));
        if($return) return $return;else $this->errorMessage = mysql_error();return false;
    }

    /**
     * @return bool|int
     */
    public function rowCount()
    {
        $cek =  mysql_num_rows($this->queryString);
        if($cek && $cek>0) return $cek;else return false;
    }

    public function __destruct()
    {
        mysql_close($this->con);
    }

}

?>