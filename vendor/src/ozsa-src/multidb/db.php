<?php
Class DB {

    public $dbType;

    public $db;

    public $dbError;

    public static $dbStatic;

    public static $dbErrors;

    public static $typeStatic;
    public function __construct()

    {
        $options  = require APP_PATH.'Configs/Configs.php';
        extract($options['db']);

        $this->dbType = $type;
        if($type == 'PDO') $exception = 'PDOException';else 'Exception';

        switch($this->dbType)
        {
            case 'PDO':
                try{
                    $dbConf = new PDO("mysql:host=$host;dbname=$dbname;",$username,$password);

                }catch (PDOException $e)
                {
                    $this->dbError = $e->getMessage();
                    throw new Exception($e->getMessage());
                }

                break;
            case 'mysql':

                $dbConf = new \mysql($host,$dbname,$username,$password);

                break;
            case 'sqlite':
                $dbConf = new \sqlite($database);
        }
        self::$typeStatic = $type;
        $this->dbConf = $dbConf;
        self::$dbStatic  = $dbConf;
        return $this->dbConf;
    }

    public function __call($name,$param)
    {
        return call_user_func_array(array($this->dbConf,$name),$param);
    }
    public static function __callStatic($name,$param)
    {

        if(method_exists(self::$typeStatic,$name)) return call_user_func_array(array(self::$dbStatic,$name),$param);
        else error::newError(" $name fonksiyonu bulunamadı"); return false;
    }




}