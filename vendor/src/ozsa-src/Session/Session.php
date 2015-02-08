<?php
class Session implements SessionInterface
{
    /**
     * @var string
     */
    private  $_session;

    /**
     * @var array,
     */

    private  $_sessionBase = array(
        'ozsa' => true,'php' => true,'json' => false,
    );

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->boot();

    }

    /**
     * @throws Exception
     */
    public function boot()
    {
         $configs = require APP_PATH.'Configs/Configs.php';

         $configs = $configs['Session'];

         $type = $configs['type'];

        if(isset($this->_sessionBase[$type]))
        {

             $this->_session = $type.'Session';

        }else{

            throw new Exception(" $type Session tipi desteklenmemektedir ");

        }
    }

    /**
     * @param $name
     * @param $params
     * @return mixed
     */

    public static function __callStatic($name,$params)
    {
        $s = new static();

        return call_user_func_array(array($s->_session,$name),$params);
    }



}