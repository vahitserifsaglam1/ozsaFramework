<?php

/**
 * Class Validator
 * ********************************************************
 * OzsaFramework validator sınıfı
 * gump validator sınıfı kullanılır;
 * @author Ozsaframework
 * *******************************************************
 */
  class Validator
  {
      public  $gump;
      public  $autoValidate;
      /**
       * @param $options
       */
      public function __construct($options)
      {

          $this->set = $options;
          $this->gump = new GUMP;
          if($this->autoValidate)
          {
              $appFolder = $options['validateFolder'];

               $files = glob($appFolder."/*",GLOB_NOSORT);

              foreach($files as $key)
              {
                  $types[str_replace(".php","",end(explode('/',$key)))] = require $key;
              }
            $this->validateParams = $types;


          }

      }

      /**
       * @param $veri
       * @param $param
       * @return bool
       * @throws Exception
       */
      public function validate($veri,$param)
      {
          $files = $this->validateParams;

          $veri = $this->gump->filter($veri, $this->validateParams[$param]['filters']);

          $validated = $this->gump->validate(
              $veri, $this->validateParams[$param]['rules']
          );

          if($validated)
          {
              return true;
          }else{
              print_r($validated);
              return false;
          }

      }

      /**
       * @param $validate
       * @return mixed
       */
      public function validatorOzsa($validate)
      {
          if(is_array($validate))
          {
              foreach($validate as $key => $value)
              {

                  if(is_array($value))
                  {
                      $this->validatorOzsa($value);
                  }else{

                      $return = filter_var(str_replace(array('<script>',"'",'"','</script>','<?','?>',' = ','=',"or","select"),'',htmlentities(htmlspecialchars(strip_tags($value)))),FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_LOW);

              }
          }
          }else{
              $return = filter_var(str_replace(array('<script>',"'",'"','</script>','<?','?>',' = ','=',"or","select"),'',htmlentities(htmlspecialchars(strip_tags($validate)))),FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_LOW);
          }
           return $return;
      }

      /**
       * @param $validate
       * @return mixed
       */
      public static function validateOzsa($validate)
      {
          if(is_array($validate))
          {
              foreach($validate as $key => $value)
              {

                  if(is_array($value))
                  {
                      self::validatorOzsa($value);
                  }else{

                      $return = filter_var(str_replace(array('<script>',"'",'"','</script>','<?','?>',' = ','=',"or","select"),'',htmlentities(htmlspecialchars(strip_tags($value)))),FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_LOW);

                  }
              }
          }else{
              $return = filter_var(str_replace(array('<script>',"'",'"','</script>','<?','?>',' = ','=',"or","select"),'',htmlentities(htmlspecialchars(strip_tags($validate)))),FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_LOW);
          }
          return $return;
      }
  }