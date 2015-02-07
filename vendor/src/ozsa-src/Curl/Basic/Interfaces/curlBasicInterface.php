<?php

interface curlBasicInterface

{
    public static function get($url);

    public static function post($url, $params = array());

    public static function download($url, $path = "downloads");

    public static function addPost($params);

    public static function setUrl($url);

    public static function close();

    public static function __callString($name, $params);
}