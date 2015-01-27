<?php
 namespace Cookie;
 include $appPath."Configs/Interfaces/CookieInterface.php";
class Cookie implements CookieInterface
{

    public static function get($name)
    {

        return (isset($_COOKIE[$name])) ? $_COOKIE[$name]:false;

    }

    public static  function set($name,$value,$time = 3600)
    {
        if(is_array($value))
        {
            foreach ($value as $names => $key) {
                setcookie("$name[$names]",$key,time()+$time);
            }
        }
        else{
            setcookie($name,$value,time()+$time);
        }

    }

    /**
     * @param $name
     */

    public static  function delete($name)
    {

        (isset($_COOKIE[$name]))  ? setcookie($name,"",time()-60*60*60*60*60) : null;

    }

    public static function flush()
    {

        foreach ($_COOKIE as $key => $value) {
            setcookie($key,"",time()-60*60*60*60*60);
        }

    }

}
