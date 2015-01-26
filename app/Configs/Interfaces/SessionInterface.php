<?php
interface SessionInterface
{
    public static function set($name,$value,$time);
    public static function get($name);
    public static function delete($name);
    public static function flush();
    public static function setSessionJson($name,$value,$time);
    public static function setSessionPhp($name,$value,$time);
    public static function setSessionOzsa($name,$value,$time);
    public static function getSessionJson($name);
    public static function getSessionOzsa($name);
    public static function getSessionPhp($name);
    public static function deleteSessionPhp($name);
    public static function deleteSessionJson($name);
    public static function deleteSessionOzsa($name);
}