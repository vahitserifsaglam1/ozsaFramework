<?php


class Cookie
{
    private $_cookie;


    private $_cookieBase = array(
        'ozsa' => true, 'json' => true, 'php' => false,
    );

    public function __construct($return = false)
    {
        $this->boot();
        if ($return) {
            return $this->_cookie;
        }
    }

    public function boot()
    {
        $configs = require APP_PATH . 'Configs/cookieConfigs.php';


        $type = $configs['type'];


        if (isset($this->_cookieBase[$type])) {


            $className = $type . 'Cookie';

            $this->_cookie = $className;


        } else {
            throw new Exception($type . 'Bu sınıf desteklenmemektedir');
        }
    }

    public function __call($name, $params)
    {

        return call_user_func_array(array($this->_cookie, $name), $params);

    }

    public static function __callStatic($name, $params)
    {
        $s = new static(true);

        return call_user_func_array(array($s, $name), $params);

    }

}