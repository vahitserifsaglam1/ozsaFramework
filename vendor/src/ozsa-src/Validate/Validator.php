<?php

  class Validator
  {
      public  $gump;
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
      public function validatorOzsa($validate)
      {
          return str_replace(array('<script>',"'",'"','</script>','<?','?>'),'',$validate);
      }
  }