<?php
  class index extends MainController
  {
       public function __construct()
       {
          parent::__construct();
          Router::render(VIEW_PATH.'index.php',array(),array(
              'css' => array('index.css'),
              'js' => array('index.js'),
              'files' => array('index.php')

          ));
           Router::setTemplateArrays(array('message'=>'asdaas'),'index.html');
       }
      public function oku()
      {


      }

  }

?>