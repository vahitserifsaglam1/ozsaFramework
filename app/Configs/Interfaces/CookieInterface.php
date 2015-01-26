<?php

 interface CookieInterface
 {
    public static function set($name,$value,$time);
    public static function get($name);
    public static function delete($name);
    public static function flush();
 }