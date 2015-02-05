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

    protected  $type;


    public function __construct($host,$dbname,$username,$password,$type = '')
    {
        $this->con = mysql_connect($host,$username,$password);
        if(!$this->con) $this->errorMessage = mysqli_connect_error();
        mysql_select_db($dbname);
        $this->type = $type;
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
     * @param $aranan
     * @param $degiscek
     * @param string $metin
     * @return mixed
     */
    public function ret($aranan,$degiscek,$metin = '')
    {
         if($metin ==  '') $metin = $this->queryString;
         $validate = Validator::validateOzsa($degiscek);
         $yeni = str_replace($aranan,$degiscek,$metin);
         return $yeni;
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
    public function fetch( $type = '' )
    {
         if($type === '')
         {
              $type = $this->type;
         }
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
    public function bind($string = '',$href = '')
    {
           $metin = $this->ret($string,$href);

           $this->queryString = $metin;

           return $this;
    }
    public function __destruct()
    {
        mysql_close($this->con);
    }

}

?>