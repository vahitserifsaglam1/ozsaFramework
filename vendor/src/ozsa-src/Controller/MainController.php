<?php

  class MainController extends DB {
      public $_modal;
      public $dbA;
      public $_assets;
      public $_view;
      public function __construct()
      {
         $this->dbA =  parent::__construct();
         $this->_assets = Desing\Single::make('\App\Assets');
          $this->_view =  Desing\Single::make('\View\Loader');
      }
      public function _modal($name)
      {
          $modalPath = APP_PATH.'Modals/'.$name.'.php';
          $modalName = $name."_modal.php";

          if(file_exists($modalPath)){
              if(class_exists($modalName))
              {
                  include $modalPath;
                  $this->_modal = new $modalName();
              }
          }

      }



      /**
       * @param $name
       * @param $params
       * @return mixed
       *
       *   Controllerda çalıştırılan ifade db>modol>asset sıralaması ile çağırılır
       */
      public function __call($name,$params)
      {
          if(method_exists($this->dbA,$name)) return call_user_func_array(array($this->dbA,$name),$params);

          elseif(method_exists($this->_modal,$name)) return call_user_func_array(array($this->_modal,$name),$params);

          elseif( method_exists($this->_assets,$name)) return call_user_func_array(array($this->_assets,$name),$params);
      }


  }