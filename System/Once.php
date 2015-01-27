<?php
class Once
{
    public static function  __callStatic($name,$params = array())
    {
        $file = "app/".$name."/".$params[0];
        if(!strstr($params[0],"."))
        {
            $file .= ".php";
        }
        return include $file;
    }
}