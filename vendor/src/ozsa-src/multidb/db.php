<?php

Class DB
{

    public $dbType;

    public $db;

    public $dbError;

    public static $dbStatic;

    public static $dbErrors;

    public static $typeStatic;

    public function __construct()

    {
        $options = require APP_PATH . 'Configs/databaseConfigs.php';

        extract($options['Connections'][$options['default']]);


        $type = $driver;

        $fetch = $options['fetch'];

        $this->dbType = $type;


        switch ($this->dbType) {
            case 'pdo':

                try {
                    $dbConf = \Desing\Single::make('PDO', "$pdoType:host=$host;dbname=$dbname;", $username, $password);

                } catch (PDOException $e) {
                    $this->dbError = $e->getMessage();
                    throw new Exception($e->getMessage());
                }

                break;
            case 'mysql':

                $dbConf = \Desing\Single::make('mysql', $host, $dbname, $username, $password, $fetch);

                break;
            default:
                $dbConf = \Desing\Single::make('mutlidb\sqlite', $database);
                break;
        }
        static::$typeStatic = $type;
        $this->dbConf = $dbConf;
        static::$dbStatic = $dbConf;
        return $this->dbConf;
    }

    public function __call($name, $param)
    {
        return call_user_func_array(array($this->dbConf, $name), $param);
    }

    public static function __callStatic($name, $param)
    {

        if (method_exists(self::$typeStatic, $name)) return call_user_func_array(array(self::$dbStatic, $name), $param);
        else
            throw new Exception(" $name isminde bir method " . __CLASS__ . " içinde bulunamadı");
    }


}