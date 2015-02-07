<?php namespace Human;

class Validate
{
    public static function Validate()
    {
        global $_SERVER;

        if ($_SERVER['HTTP_USER_AGENT'] && $_SERVER['HTTP_ACCEPT'] && $_SERVER['HTTP_CONNECTION'] == 'keep-alive' &&
            $_SERVER['REMOTE_ADDR'] && $_SERVER['REMOTE_ADDR'] == \Ip\Get::Getip()
        ) return true; else return false;

    }
}

class Ajax
{
    public static function  isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }
}


