<?php

 Class Router

 {
      public static $js = array();
      public static $css = array();
      public static $template = array();
      public static $files = array();
      protected static $templateInstalled = false;
      public static $templateArray;

      public function __construct()
      {

      }
     public static function setTemplateArrays($array,$file)
     {
         self::$templateArray[$file] = $array;
         self::templateInstall();

     }
     public static function templateInstall()
     {
         if(!self::$templateInstalled)
         {
             Ozsa\Template\Engine::Installer();
             self::$templateInstalled = true;
         }
         foreach(self::$templateArray as $key => $value)
         {


                  self::templateLoader(array(),$key,$value);


         }

     }
     public static function render($path,array $params = array(),$rendefiles = '', array $templateArray = array())
     {

         if(isset($params) && !empty($params))
         {
             $params = $params;
         }
         if(is_array($rendefiles))
         {
             $rende = self::renderFiles($rendefiles);


         }else{
             $rende = array();
         }
         $extra = array_merge($params,$rende);

         extract($extra);

         ob_start();

         if( isset($files) && is_string($files) )
         {
             file_put_contents($path,$files);
         }
         if(isset($rendefiles['templates'])) $templates = $rendefiles['templates'];

         if(isset($templates))
         {

             Ozsa\Template\Engine::Installer();
             self::$templateInstalled = true;
             if( is_array($templates) )
             {

                 foreach($templates as $tfiles)
                 {

                         Ozsa\Template\Engine::templateInstaller(array(),$templateArray,$tfiles);

                 }

             }
         }


         include $path;

         return null;
     }
     public static function templateLoader($options = array(),$file,$arrays)
     {
          Ozsa\Template\Engine::templateInstaller($options,$arrays,$file);
     }
     public static function renderFiles(array $filess = array())
     {
         $files = array(
             'css' => array(),
             'js' => array(),
             'files' => array()
         );

        foreach($filess as $key => $value)
        {

            foreach ( $value as $k )
            {

                $files[$key][] = $k;
            }
        }

         return self::createHead($files);
     }

     public static function createHead($files)
 {


       if(isset($files['css']))self::$css = self::createCss($files['css']);
       if(isset($files['js'])) self::$js = self::createJs($files['js']);
       if(isset($files['files']) )self::$files = self::createFiles($files['files']);

      $return =  array(
          'css' => self::$css,
          'js' => self::$js,
          'files' => self::$files
      );

     return $return;

 }
      public static function createFiles($files)
      {

          $s = '<?php ';

          foreach($files as $file)
          {
              $s .= 'include "'._PUBLIC."files/".$file.'";';
          }
          $s .= '?>';
          return $s;
      }
      public static function createCss($files)
      {
           $s = '';
           foreach($files as $key)
           {
               $s .= '<link type="text/css" href="'._PUBLIC.'css/'.$key.'"/>'."\n";
           }

          return $s;
      }
     public static function createJs($files)
     {
         $s = '';
         foreach($files as $key)
         {
             $s .= '<script type="text/javascript" href="'._PUBLIC.'js/'.$key.'" /></script>'."\n";
         }
         return $s;
     }
     public function error($error = '404',$message)
     {
         $err = $this->http_response_code($error);
         echo $message;
         header("HTTP/1.1 $error $err ");

     }
     public function http_response_code($code = NULL) {

         if ($code !== NULL) {

             switch ($code) {
                 case 100: $text = 'Continue'; break;
                 case 101: $text = 'Switching Protocols'; break;
                 case 200: $text = 'OK'; break;
                 case 201: $text = 'Created'; break;
                 case 202: $text = 'Accepted'; break;
                 case 203: $text = 'Non-Authoritative Information'; break;
                 case 204: $text = 'No Content'; break;
                 case 205: $text = 'Reset Content'; break;
                 case 206: $text = 'Partial Content'; break;
                 case 300: $text = 'Multiple Choices'; break;
                 case 301: $text = 'Moved Permanently'; break;
                 case 302: $text = 'Moved Temporarily'; break;
                 case 303: $text = 'See Other'; break;
                 case 304: $text = 'Not Modified'; break;
                 case 305: $text = 'Use Proxy'; break;
                 case 400: $text = 'Bad Request'; break;
                 case 401: $text = 'Unauthorized'; break;
                 case 402: $text = 'Payment Required'; break;
                 case 403: $text = 'Suncuu Cevap Vermiyor'; break;
                 case 404: $text = 'Not Found'; break;
                 case 405: $text = 'Method Not Allowed'; break;
                 case 406: $text = 'Not Acceptable'; break;
                 case 407: $text = 'Proxy Authentication Required'; break;
                 case 408: $text = 'Request Time-out'; break;
                 case 409: $text = 'Conflict'; break;
                 case 410: $text = 'Gone'; break;
                 case 411: $text = 'Length Required'; break;
                 case 412: $text = 'Precondition Failed'; break;
                 case 413: $text = 'Request Entity Too Large'; break;
                 case 414: $text = 'Request-URI Too Large'; break;
                 case 415: $text = 'Unsupported Media Type'; break;
                 case 500: $text = 'Internal Server Error'; break;
                 case 501: $text = 'Not Implemented'; break;
                 case 502: $text = 'Erişim Engellendi'; break;
                 case 503: $text = 'Service Unavailable'; break;
                 case 504: $text = 'Gateway Time-out'; break;
                 case 505: $text = 'HTTP Version not supported'; break;
                 default:
                     exit('Unknown http status code "' . htmlentities($code) . '"');
                     break;
             }

             $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');

             header($protocol . ' ' . $code . ' ' . $text);

             $GLOBALS['http_response_code'] = $code;

         } else {

             $code = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);

         }

         return $code;

     }
     public static function __callStatic($name,$params)
     {

         return call_user_func_array(array('Router',$name),$params);
     }
 }