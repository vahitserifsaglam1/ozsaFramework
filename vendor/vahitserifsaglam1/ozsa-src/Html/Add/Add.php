<?php
  namespace Html\Add;
  class Add
  {
      /**
       * @param $name
       * @param $params
       * @return string
       */

       public static function __callStatic($name,$params)
       {
           $msg = "";
           $styles = $params[0];
           $content = $params[1];
           if( is_array($styles) )
           {
               $styles = render($styles, " ");
           }
           if($name != "li" || $name !="option")
           {


           $msg .= "<$name $styles >".PHP_EOL;
              $msg .= $content.PHP_EOL;
           $msg .= "</div>".PHP_EOL;


           }else{
              switch($name){
                  case 'li':
                       $msg .= "<li $styles>$content</li>".PHP_EOL;
                      break;
                  case 'option':
                      $msg  .= "<option value='$styles'>$content</option>".PHP_EOL;
                      break;
              }
           }
           return $msg;
       }

  }
 ?>