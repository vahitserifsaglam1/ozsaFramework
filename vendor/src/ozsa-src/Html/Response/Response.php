<?php

/**
 * Class Response
 *
 * @packpage Ozsaframework
 * @author vahit şerif sağlam
 * @see ozsabilisim.org
 *
 *  ******************************
 *
 *    Bu sınıf Vahit şerif sağlam tarafından ozsaframework için hazırlanmıştır
 *
 *
 *  ********************************
 *
 */
 class Response
 {
     /**
      * @var array
      */
     public $codes = array(
         100 => 'Continue',
         101 => 'Switching Protocols',
         200 => 'OK',
         201 => 'Created',
         202 => 'Accepted',
         203 => 'Non-Authoritative Information',
         204 => 'No Content',
         205 => 'Reset Content',
         206 => 'Partial Content',
         300 => 'Multiple Choices',
         301 => 'Moved Permanently',
         302 => 'Found', // HTTP 1.1
         303 => 'See Other',
         304 => 'Not Modified',
         305 => 'Use Proxy',
         307 => 'Temporary Redirect',
         400 => 'Bad Request',
         401 => 'Unauthorized',
         402 => 'Payment Required',
         403 => 'Forbidden',
         404 => 'Not Found',
         405 => 'Method Not Allowed',
         406 => 'Not Acceptable',
         407 => 'Proxy Authentication Required',
         408 => 'Request Timeout',
         409 => 'Conflict',
         410 => 'Gone',
         411 => 'Length Required',
         412 => 'Precondition Failed',
         413 => 'Request Entity Too Large',
         414 => 'Request-URI Too Long',
         415 => 'Unsupported Media Type',
         416 => 'Requested Range Not Satisfiable',
         417 => 'Expectation Failed',
         500 => 'Internal Server Error',
         501 => 'Not Implemented',
         502 => 'Bad Gateway',
         503 => 'Service Unavailable',
         504 => 'Gateway Timeout',
         505 => 'HTTP Version Not Supported',
         509 => 'Bandwidth Limit Exceeded',

     );
     /**
      * @var string
      */
     public $pages;
     /**
      * @var bool
      */
     public $body;
     /**
      * @var bool
      */
     public $message;
     /**
      * @var bool
      */
     public $code = false;
     /**
      * @var string
      */
     public $create;
     /**
      * @var bool
      */
     public $headerReflesh = false;
     /**
      * @var string
      */
     public $headerUrl;
     /**
      * @var integer
      */
     public $headerCode;
     /**
      * @var string
      */
     public $httpVersion = 'HTTP/1.0';

     /**
      * @param bool $code
      * @param bool $message
      * @param bool $body
      * @return mixed $this
      */

     public function __construct($code = false,$message = false,$body = false,$page = '')
     {
          $this->body = $body;
          $this->message = $message;
          $this->code = $code;
          $this->pages = $page;
         return $this;
     }

     /**
      * @param bool $code
      * @return $this
      */

     public function setCode($code = false)
     {
         if(!isset($this->code)) $this->code = $code;
         return $this;
     }

     /**
      * @param bool $message
      * @return $this
      */

     public function setMessage($message = false )
     {
         if(!isset($this->message)) $this->message = $message;
         return $this;
     }

     /**
      * @param $code
      * @return null
      */

     public function setResponceCode($code)
     {
         http_response_code($code);
         return null;
     }

     /**
      * @param $error
      * @param string $message
      * @return $this
      */

     public function addCode($error,$message = '')
     {
         if(!isset($this->codes[$error]))
         {
             $this->codes[$error] = $message;
         }
         else{
             $this->setErrorMessage($error,$message);
         }
         return $this;
     }

     /**
      * @param bool $body
      * @return $this
      */
     public function setBody($body = false)
     {
         if(!isset($this->body)) $this->body = $body;
         return $this;
     }

     /**
      * @param string $code
      * @param string $message
      * @return $this
      */

     public function setErrorMessage($code = '',$message = '')
     {
          if(isset($this->codes[$code]))
          {
              $this->codes[$code] = $message;
          }
         return $this;
     }

     /**
      * @param $url
      * @param int $time
      * @return $this
      */

     public function reflesh($url,$time = 0)
     {
       if( $time !== 0)
       {
           $this->headerReflesh = $time;
       }
         $this->headerUrl = $url;

         return $this;
     }

     /**
      * @param $type
      * @param $message
      * @return $this
      */

     public function setHeaderContent($type,$message)
     {
         header($type.':'.$message);
         return $this;
     }

     /**
      * @return string
      */

     public function refreshCreator()
     {
         $msg = 'header(';
         $url = $this->headerUrl;
         $time = $this->headerReflesh;

         if(isset($time) &&  is_numeric($time) )
         {
              $msg .= 'Refresh:'.$url.', url:'.$url;
         }else{
             $msg .= 'Location:'.$url;
         }
         $msg .= ')';
         $this->headerCode = $msg;
         return $msg;

     }

     /**
      * @param $version
      * @return $this
      */

     public function setHttpVersion($version)
     {
         $this->httpVersion = $version;
         return $this;
     }

     /**
      * @param $path
      * @return $this
      * @throws Exception
      */

     public function setMessageToHtml($path)
     {
         if(file_exists($path))
         {
             $this->message = file_get_contents($path);
         }else{
             throw new Exception($path.' yolundaki içerik bulunamadı ');
         }
         return $this;

     }

     /**
      * @param $error
      * @param $message
      */

     public function headerCreator(
         $error,
     $message
     ){
         header($this->httpVersion.' '.$error.' '.$message.' ');
     }

     /**
      * @param $code
      * @return mixed
      */

     public function returnErrorMessage($code)
     {
         if(isset($this->codes[$code])) return $this->codes[$code];
     }

     /**
      * @return $this
      */

     public function execute( ){



         if(isset($this->headerUrl))
         {
             $header = $this->refreshCreator();
         }
         $error = $this->code;



         $message = $this->returnErrorMessage($error);

         $this->setResponceCode($error);

         $this->headerCreator($error,$message);


         if(isset($this->pages))
         {
             if(is_array( $this->pages ))

             {
                 foreach($this->pages as $page )
                 {
                     $this->headerPage($page);
                 }
             }

         }

         echo $this->body;

         echo "<title>".$this->message."</title>";

         return $this;

         die();


     }

     /**
      * @param $page
      * @return mixed $this
      */

     public function setPage($page,$time)
     {
         if(!isset($this->pages[$page])) $this->pages[$page] = $time;
         return $this;
     }

     /**
      * @param $page
      * @return $this
      */

     public function headerPage($page)
     {
         header('Refresh:'.$this->pages[$page].', url='.$page);
     }


 }

?>