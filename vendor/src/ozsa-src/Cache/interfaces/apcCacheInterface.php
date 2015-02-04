<?php

 interface apcCacheInterface
 {
     public function get($name);
     public function set($name,$value,$time = 0);
     public  function delete($name);
     public function flush();
 }