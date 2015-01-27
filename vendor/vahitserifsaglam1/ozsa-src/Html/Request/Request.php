<?php 
   namespace Html\Request;
    class Request 
    {
        public static $r;

        public static function  init($url,$method)
      {
          $r =  new HttpRequest($url, $method);
          self::$r = $r;
          return $r;
      }
    	public static function post($url,$fields,$files = array(),$options = array())
    	{
            $r = self::init($url, HttpRequest::METH_POST);
            $r->setOptions(array('cookies' => array('lang' => 'tr')));
            $r->addPostFields($fields);
            try {
                return $r->send()->getBody();
            } catch (HttpException $ex) {
                error::newError(" Static ( Request ) Sınıfından =>  $ex hatası döndü");
                return false;
            }
    	}
    	public static function get($url,$query = false,$options = false)
    	{
            $r = self::init($url, HttpRequest::METH_GET);
            if($options) $r->setOptions($options);
            if($query) $r->addQueryData($query);
            try {
                $r->send();
                if ($r->getResponseCode() == 200) {
                    return  $r->getResponseBody();
                }
            } catch (HttpException $ex) {
                error::newError(" Static (Request) Sınıfından $ex hatası döndü");
                return  $ex;
            }
    	}
        public static function ajax()
        {
            return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest' ;
        }
        public static function  __callString($name,$param)
       {
          return call_user_func_array(array('Http_Request',$name),$param);
       }
    }      
  
 ?>