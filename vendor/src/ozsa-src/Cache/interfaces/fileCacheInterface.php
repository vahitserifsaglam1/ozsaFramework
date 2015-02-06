<?php

interface fileCacheInterface
{
    public static function get($name);

    public static function set($name, $value, $time = 3600);

    public static function delete($name);

    public static function check($name);

    public static function flush();
}