<?php

/**
 * Class Validator
 * ********************************************************
 * OzsaFramework validator sınıfı
 * gump validator sınıfı kullanılır;
 * @author Ozsaframework
 * *******************************************************
 */
class Validator
{
    public $gump;
    public $autoValidate;
    public static $options;
    public static $functions;

    public function __construct($options)
    {

        $this->set = $options;
        self::$options = $options;
        $this->gump = new GUMP;
        if ($this->autoValidate) {
            $appFolder = $options['validateFolder'];

            $files = glob($appFolder . "/*", GLOB_NOSORT);

            foreach ($files as $key) {
                $types[str_replace(".php", "", end(explode('/', $key)))] = require $key;
            }
            $this->validateParams = $types;


        }

    }

    public static function make($veri, array $filters = array(), array $rules = array())
    {
        $thi = new static(self::$options);
        $s = $veri->gump->filter($veri, $filters);

        $validate = $thi->gump->validate(
            $veri, $rules
        );

        if ($validate) return true; else return $validate;
    }

    public static function makro($name, Callable $call)
    {
        $validate = new static(self::$options);
        $validate = $validate->gump;
        if (is_callable($call)) {
            static::$functions[$name] = Closure::bind($call, null, get_class());
        }

    }

    /**
     * @param $veri
     * @param $param
     * @return bool
     * @throws Exception
     */
    public function validate($veri, $param)
    {
        $files = $this->validateParams;

        $veri = $this->gump->filter($veri, $this->validateParams[$param]['filters']);

        $validated = $this->gump->validate(
            $veri, $this->validateParams[$param]['rules']
        );

        if ($validated) {
            return true;
        } else {
            print_r($validated);
            return false;
        }

    }

    /**
     * @param $validate
     * @return mixed
     */
    public function validatorOzsa($validate)
    {
        if (is_array($validate)) {
            foreach ($validate as $key => $value) {

                if (is_array($value)) {
                    $this->validatorOzsa($value);
                } else {

                    $return = filter_var(str_replace(array('<script>', "'", '"', '</script>', '<?', '?>', ' = ', '=', "or", "select"), '', htmlentities(htmlspecialchars(strip_tags($value)))), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);

                }
            }
        } else {
            $return = filter_var(str_replace(array('<script>', "'", '"', '</script>', '<?', '?>', ' = ', '=', "or", "select"), '', htmlentities(htmlspecialchars(strip_tags($validate)))), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
        }
        return $return;
    }

    /**
     * @param $validate
     * @return mixed
     */
    public static function validateOzsa($validate)
    {
        if (is_array($validate)) {
            foreach ($validate as $key => $value) {

                if (is_array($value)) {
                    self::validatorOzsa($value);
                } else {

                    $return = filter_var(str_replace(array('<script>', "'", '"', '</script>', '<?', '?>', ' = ', '=', "or", "select"), '', htmlentities(htmlspecialchars(strip_tags($value)))), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);

                }
            }
        } else {
            $return = filter_var(str_replace(array('<script>', "'", '"', '</script>', '<?', '?>', ' = ', '=', "or", "select"), '', htmlentities(htmlspecialchars(strip_tags($validate)))), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
        }
        return $return;
    }

    public static function __callStatic($name, $params)
    {
        if (isset(static::$functions[$name])) {
            return call_user_func_array(static::$functions[$name], $params);
        }
    }
}