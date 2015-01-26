<?php
interface phpCacheInterface{

    public function get($name);

    public function set($name,$value,$time);

    public function delete($name);

    public function flush();

    public function check($name);

}