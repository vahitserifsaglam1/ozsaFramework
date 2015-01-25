<?php 

  class form
 {
 	public static $formString;
    public static $formClass;
    public static $functions;

 	public static function open($name,$paramatres)
    {
        $rended = render($paramatres," ");
        $msg = "<form name='$name' ".$rended.">";
        echo $msg;
    }
      public static function submit($params)
      {
          if( is_array($params) )
          {
               $params = reder($params);
              return "<input type='submit' $params >";
          }else{
              return "<input type='submit' value='$params' />";
          }
      }
      public static function input($name,$params)
      {
          if(is_array($params))
          {
              return  "<input name='$name' $params >";
          }else{
              return "<input type='text' name='$name' value='$params' >";
          }
      }
      public static function text($name,$value)
      {
           return "<input type='text' name='$name' value='$value' />";
      }
      public static function textarea($name,$params,$value = "")
      {
          if(is_array($params))
          {
              echo "<textarea name = '$name' $params >$value</textarea>";
          }else{
              echo "<textarea name='$name'>$params</textarea>";
          }
      }
      public static function makro($name,$return)
      {
          if(is_callable($return))
          {
              self::$functions[$name] = Closure::bind($return, null, get_class());
          }else{
              error::newError("$name e atadığınız fonksiyon çağrılabilir bir fonksiyon değildir");
          }

      }
      public static function select($name,$params,$options)
      {
          $msg = "";
          if(is_array($params))
          {
              $params = render($params);
              $msg.= "<select name='$name' $params >";
          }
          else{
              $msg .= "<select name='$name' $params >";
          }

          if(is_array($options))
          {
              foreach($options as $key => $value)
              {
                  $msg .= "<options value='$key'>$value</options>";
              }
          }
          $msg .= "</select>";
          return $msg;
      }
      public static function close()
      {
          echo "</formm>";
      }
      public static function __callStatic($name,$parametres)
      {
          if(isset(self::$functions[$name]))
          {
              return call_user_func_array(self::$functions[$name],$parametres);
          }

      }
 }

?>