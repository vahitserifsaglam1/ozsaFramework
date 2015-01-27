<?php
namespace Multidb;
Class Multidb
{
    public $db;
    public $type;
    public $querySring;
    public static $dbStatic;
    public static $typeStatic;
    public function __construct()
    {
        global $host,$dbname,$username,$password,$dataType,$charset,$appPath;
        $this->type = $dataType;

        switch ($dataType)
        {
            case 'PDO':
                $db = new \PDO("mysql:host=$host;dbname=$dbname",$username,$password);
                break;
            case 'sqlite':
                    include $appPath."extras/class/mysql/sqlite.php";
                $db = new \sqlite($dbname,0666,true);
                break;
            case 'mysqli':
                $db = new \mysqli($host,$username,$password);
                break;
            case 'mysql':
                include $appPath."extras/class/mysql/mysql.php";
                $db = new \mysql($host,$dbname,$username,$password);
                break;
        }
        $this->db = $db;
        self::$dbStatic = $db;
        $this->db->query("SET NAMES $charset");
        self::$typeStatic = $dataType;
    }
    public function __call($name,$params)
    {
        $type = $this->type;

        if($type != 'Sqlite' )
        {
            if( method_exists($type,$name))
            {
                return call_user_func_array( array($this->db,$name),$params);
            }else{
                error::newError(" $name adlı bir method $type tipinde bulunamadı");
            }
        }else{

        }
    }
    public static function __callStatic($name,$params)
    {
        $type = self::$typeStatic;

        if($type != 'Sqlite' )
        {
            if( method_exists($type,$name))
            {
                return call_user_func_array( array(self::$dbStatic,$name),$params);
            }else{
                error::newError(" $name adlı bir method $type tipinde bulunamadı");
            }
        }else{

        }
    }
}

?>