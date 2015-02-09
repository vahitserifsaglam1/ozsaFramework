<?php

  class MainController extends Database {
      public $_modal;
      public $db;
      public $_assets;
      public $_view;
      public function __construct()
      {
         $this->db =  parent::__construct();
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
          if(method_exists($this->db,$name)) return call_user_func_array(array($this->db,$name),$params);

          elseif(method_exists($this->_modal,$name)) return call_user_func_array(array($this->_modal,$name),$params);

          elseif( method_exists($this->_assets,$name)) return call_user_func_array(array($this->_assets,$name),$params);
      }


  }