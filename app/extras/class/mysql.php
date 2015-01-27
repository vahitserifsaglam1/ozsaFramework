<?php
function tirnak($param)
{
    return "'".security_render($param)."'";
}
class mysql
{
    private $con;
    public $queryString;
    public function __construct($host,$dbname,$username,$password)
    {
        $this->con = mysql_connect($host,$username,$password);
        mysql_select_db($dbname);
        return $this->con;
    }

    public function query($query)
    {

        $this->queryString = $query;
        return $this;
    }
    public  function prepare($query)
    {
        $this->queryString = $query;
        return $this;
    }
    public function execute($exec = array())
    {
        $query = $this->queryString;
        preg_match_all("/[?@#$%^]/", $query, $dondu);
        if( is_array($exec) )
        {
            $exec =  array_map('tirnak',$exec);
            $yeni =  str_replace($dondu[0], $exec, $query);
            $query = mysql_query($yeni);
            $this->queryString = $yeni;
            return ($query) ? $this:false;
        }else{
            error::newError("Doğru bir veri girilmemiş");
        }
    }
    public function rowCount()
    {
        $cek =  mysql_num_rows($this->queryString);
        if($cek && $cek>0) return $cek;else return false;
    }

}

?>