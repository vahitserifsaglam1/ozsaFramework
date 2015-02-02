<?php

  class MainController extends DB {
      public $_modal;
      public $dbA;
      public $_assets;
      public function __construct()
      {
         $this->dbA =  parent::__construct();
         $this->_assets = new App\Assets();
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
      public function __call($name,$params)
      {
          if(method_exists($this->dbA,$name)) return call_user_func_array(array($this->dbA,$name),$params);
          elseif(method_exists($this->_modal,$name)) return call_user_func_array(array($this->_modal),$name);
          elseif( method_exists($this->dbA,$name) &&  method_exists($this->_modal,$name)) error::newError(" $name fonksiyon
          hem dn hemde modal da bulunmakda lütfen modal olarak kullanırken _modal diye çağırınız");
          else return null;
      }
      public static function __callStatic($name,$params)
      {

      }

  }