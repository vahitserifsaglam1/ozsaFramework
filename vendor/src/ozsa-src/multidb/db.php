<?php

Class DB {

    public $dbType;

    public $db;

    public $dbError;

    public function __construct($options)

    {
        extract($options);
        $this->dbType = $type;
        if($type == 'PDO') $exception = 'PDOException';else 'Exception';

        switch($this->dbType)
        {
            case 'PDO':
                try{
                    $this->db = new PDO("mysql:host=$host;dbname=$dbname;",$username,$password);
                }catch (PDOException $e)
                {
                    $this->dbError = $e->getMessage();
                }

                break;
            case 'mysql':

                $this->db = new \mysql($host,$dbname,$username,$password);

                break;
            case 'sqlite':
                $this->db = new \sqlite($dbname);
        }

    }

    public function __call($name,$param)
    {
        if(method_exists($this->db,$param))return call_user_func_array(array($this->db,$name),$param);
        else error::newError(" $type veritabanında $name adında bir fonksiyon yok");return false;
    }


}