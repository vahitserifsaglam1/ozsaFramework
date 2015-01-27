<?php

Class Multidb
{
    public $db;
    public $type;
    public $querySring;
    public function __construct()
    {

        $variable =  get::variable('database');
        extract($variable);
        $this->type = $dataType;

        switch ($dataType)
        {
            case 'PDO':

                $db = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);

                break;
            case 'sqlite':
                include "app/extras/class/sqlite.php";
                $db = sqlite($dbname,0666,$sqliteerror);

                break;
            case 'mysqli':
                $db = new mysqli($host,$username,$password);
                break;
            case 'mysql':
                include "app/extras/class/mysql.php";
                $db = new mysql($host,$dbname,$username,$password);
                break;
        }
        $this->db = $db;
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
}

?>