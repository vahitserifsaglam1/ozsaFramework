<?php
Class DB {

    public $dbType;

    public $db;

    public $dbError;

    public static $dbStatic;

    public static $dbErrors;

    public static $typeStatic;
    public function __construct($options)

    {

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
                }

                break;
            case 'mysql':

                $dbConf = new \mysql($host,$dbname,$username,$password);

                break;
            case 'sqlite':
                $dbConf = new \sqlite($dbname);
        }
        self::$typeStatic = $type;
        $this->dbConf = $dbConf;
        self::$dbStatic  = $dbConf;
        return $this->dbConf;
    }

    public function __call($name,$param)
    {
        if(method_exists($this->dbConf,$param))return call_user_func_array(array($this->dbConf,$name),$param);
        else error::newError(" $type veritabanında $name adında bir fonksiyon yok");return false;
    }
    public static function __callStatic($name,$param)
    {

        if(method_exists(self::$typeStatic,$name)) return call_user_func_array(array(self::$dbStatic,$name),$param);
        else error::newError(" $name fonksiyonu bulunamadı"); return false;
    }




}