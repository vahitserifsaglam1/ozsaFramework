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
              if($validate) $this->setPost(\Validator::validateOzsa($this->get));
          }
          if($_POST)
          {
              $this->post = $_POST;
              if($validate) $this->setPost(\Validator::validateOzsa($this->post));
          }

          if($_GET['url'] == 'public.php') unset($_GET['url']);
      }

      /**
       * @return mixed
       */
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
          return $this;
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