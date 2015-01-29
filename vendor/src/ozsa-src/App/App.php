<?php namespace Ozsa;

    class App
    {
        protected $settings = false;
        private $db = false;
        private $request;
        private $data = null;
        public $validator;

        public function __construct($pathOptions,$configs)
        {
            $this->settings = array('path' => $pathOptions,
            'configs'=> $configs);
            $this->cookieStart();
            $this->sessionStart();
            $this->getRequest();
            $this->installValidator();
            #$this->databaseInstaller();
        }
        public function  installValidator()
        {
             $options = $this->settings['configs']['Validate'];
             $validator = new \Validator($options);
            if($options['autoValidate']){

                $assets = new \App\Assets();
                $params =  $assets->returnRequest();
                $validator->validatorOzsa($params);
            }

        }
        public function databaseInstaller()
        {
            new \DB($this->settings['configs']['db']);
            \DB::init($this->settings['configs']['db']);

        }
       public function setErrorReporting()
       {
           error_reporting($this->setting['Error']['Reporting']);
           return null;
       }
        public function sessionStart()
        {
            $session_name = session_name();
            if (session_start()) {
                setcookie($session_name, session_id(), null, '/', null, null, true);
            }
            \Session::init($this->settings['configs']['Session']);
            return null;
        }
        public function cookieStart()
        {

            \Cookie::init($this->settings['configs']['Cookie']);
            return null;
        }
        public function getRequest()
        {


              $configs = $this->settings['path'];
              $appPath =  rtrim(APP_PATH,"/");

              $systemPath =  rtrim(SYSTEM_PATH,'/');

              if(!isset($_GET['url'])) $_GET['url'] = "index";
              if(!strstr($_GET['url'],'/')) $_GET['url'] .= "/";
              @list($view,$function,$params) = explode("/",$_GET['url']);
              $render = new \Router();

              if( $view != $appPath && $view != $systemPath && $_SERVER['REQUEST_URI'] != 'public.php')
              {

                  $path  =  $appPath."/Controller/$view.php";
                  include $path;
                  $class = new $view();
                  call_user_func(array($class,$function),$params);

                  $render->render($appPath."/Views/".$view.".php",$configs);

              }else{

                  $render->error('502');
                  die();
              }
        }

    }


