<?php
  namespace App;
  Class Assets
  {
      public function __construct()
      {
          if($_FILES)
          {
              $this->files = $_FILES;
          }
          if($_GET)
          {
              $this->get = $_GET;
          }
          if($_POST)
          {
              $this->post = $_POST;
          }
      }
      public function returnPost(){
          return $this->post;
      }
      public function returnGet()
      {
          return $this->get;
      }
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
      public function setPost($post)
      {
          $_POST = array();
          $_POST[] = $post;
          $this->post = $post;
      }
      public function setGet($get)
      {
          $_GET = array();
          $_GET[] = $get;
          $this->get = $get;
      }
      public function returnRequest()
      {
          if($this->post) $returns['POST'] = $this->post;
          if($this->get) $returns['GET'] = $this->get;
          return $returns;
      }
  }