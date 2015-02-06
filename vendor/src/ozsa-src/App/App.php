<?php namespace App;

class App
{
    protected $settings = false;
    private $db = false;
    private $request;
    private $data = null;
    public $validator;
    public $boots;
    protected $adapters;

    public function __construct($pathOptions, $configs)
    {
        $this->settings = ['path' => $pathOptions,
            'configs' => $configs];

        $this->validateAssets();
        $this->sessionStart();
        $this->getRequest();

    }

    public function validateAssets()
    {
        $assets = \Desing\Single::make('\App\Assets', true);
    }

    public function setErrorReporting()
    {
        $configs = require APP_PATH . 'Configs/Error.php';

        error_reporting($configs['Reporting']);
        return null;
    }

    public function sessionStart()
    {
        $session_name = session_name();
        if (session_start()) {
            setcookie($session_name, session_id(), null, '/', null, null, true);
        }
        return null;
    }

    public static function urlParse()
    {
        return explode("/", $_GET['url']);
    }

    public function requestControl()
    {

        if (!isset($_GET['url'])) $_GET['url'] = 'index';
        if (strstr($_GET['url'], '.php')) $_GET['url'] = str_replace('.php', '', $_GET['url']);

        if (!strstr($_GET['url'], '/')) $_GET['url'] .= "/";

        $ex = explode("/", $_GET['url']);

        define('URL', $_GET['url']);

        return $ex;
    }

    public function paramsCheck($ex)
    {
        if (isset($ex[1])) $function = $ex[1];
        if (isset($ex[2])) {
            unset($ex[0]);
            unset($ex[1]);
            $params = $ex;

        } else {
            $params = array();
        }

        return $params;
    }

    public function getRequest()
    {


        $configs = $this->settings['path'];

        $appPath = rtrim(APP_PATH, '/');

        $systemPath = rtrim(SYSTEM_PATH, '/');

        $ex = $this->requestControl();

        @$view = $ex[0];

        $params = $this->paramsCheck($ex);

        $render = new \App\Router();

        if ($view != $appPath && $view != $systemPath && !strstr($_SERVER['REQUEST_URI'], 'public.php')) {


            $path = $appPath . "/Controller/$view.php";
            include $path;
            $class = \Desing\Single::make($view);
            if (isset($function)) call_user_func_array(array($class, $function), $params);

            # $render->render($appPath."/Views/".$view.".php",$configs);

        } else {

            $response = \Desing\Single::make('Html\Response', 404, 'bu sayfaya erişim hakınız yok', 'Lütfen koşarak uzaklaşın');

            $response->reflesh("index.php")->execute();


        }
    }

    public function __destruct()
    {
        \Session::flush();
    }

}


