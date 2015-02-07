<?php
  namespace App;
  /**
   * Class Assets
   * @package App
   */
  Class Assets
  {
      /**
       * @var $post
       * @var $get
       * @var $files
       */
      public $post;
      public $get;
      public $files;
      public $configs;
      public static $getS;
      public static $postS;

      /**
       * @param bool $validate
       */
      public function __construct($validate = false)
      {
          if($_FILES)
          {
              $this->files = $_FILES;

          }
          if($_GET)
          {
              $this->get = $_GET;
              if($validate) $this->setPost( GUMP::xss_clean(Validator::validateOzsa($this->get)));
          }
          if($_POST)
          {
              $this->post = $_POST;
              if($validate) $this->setPost( GUMP::xss_clean(\Validator::validateOzsa($this->post)));
          }

          if($_GET['url'] == 'public.php') unset($_GET['url']);
      }

      /**
       * @return mixed
       */

      public function setConfigs( array  $configs = array() )
      {
           $this->configs = $configs;
      }
      public function returnPost(){
          return $this->post;
      }

      /**
       * @return mixed
       */
      public function returnGet()
      {
          return $this->get;
      }

       public static function returnGetStatic()
       {
           return static::$getS;
       }

       public static function returnPostStatic()
       {

           return static::$postS;

       }

      /**
       * @param $name
       * @param $types
       * @return bool
       */
      public function returnFiles($name,$types)
      {
         if($this->files[$name]['type'])
         {
             foreach($types as $key)
             {
                 if($this->files[$name]['type'] == $types)
                 {$return[$name] = $types;}
                 if($return) return $this->files[$name];else return false;
             }
         }
      }

      /**
       * @param $post
       * @return $this
       */
      public function setPost($post)
      {
          $_POST = array();
          $_POST[] = $post;
          $this->post = $post;
          static::$postS = $post;
          return $this;
      }

      /**
       * @param $get
       * @return $this
       */
      public function setGet($get)
      {
          $_GET = array();
          $_GET[] = $get;
          $this->get = $get;
          static::$getS = $get;
          return $this;
      }
      public function getName()
      {
          return __CLASS__;
      }

      public function boot()
      {

          return new static( true );
      }

      /**
       * @return mixed
       */
      public function returnRequest()
      {
          if($this->post) $returns['POST'] = $this->post;
          if($this->get) $returns['GET'] = $this->get;
          return $returns;
      }
  }