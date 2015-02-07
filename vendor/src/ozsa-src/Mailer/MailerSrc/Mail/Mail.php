<?php

class Mailer
{
    public static function send($name = '', Callable $call)
    {
        $options = require APP_PATH . 'Configs/Mail/' . $name . '.php';

        $message = new Mail($options);


        return $call($message);
    }
}