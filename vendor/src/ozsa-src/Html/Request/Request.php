<?php

/**
 * Class Request
 * @packpage HttpRequest
 */
class Request
{
    /**
     * @var $r
     */
    public static $r;

    /**
     * @param $url
     * @param $method
     * @return HttpRequest
     */
    public static function  init($url,$method)
    {
        $r =  new HttpRequest($url, $method);
        self::$r = $r;
        return $r;
    }

    /**
     * @param $url
     * @param $fields
     * @param array $files
     * @param array $options
     * @return bool|string
     */

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

    /**
     * @param $url
     * @param bool $query
     * @param bool $options
     * @return Exception|HttpException|string
     */

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

    /**
     * @return bool
     *
     *  Gelen isteğin ajax olup olmadığı kontrolu
     */

    public static function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest' ;
    }

    /**
     * @param $name
     * @param $param
     * @return mixed
     *
     *   Sınıfta olmayan fonksiyonlarım php tarafından oluşturulan Http_Request sınıfında çalıştırılması;
     *
     */
    public static function  __callString($name,$param)
    {
        return call_user_func_array(array('HttpRequest',$name),$param);
    }
}

?>