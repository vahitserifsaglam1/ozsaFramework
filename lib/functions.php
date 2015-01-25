<?php

  function security_render($val){
     return  security::render($val);
  }
 function  render($values = array(),$end = ",")
{
    $d = "";
    foreach ($values as $key => $value)
    {
        $d .= "$key=$values".$end;
    }
    $d = rtrim($d,$end);
    return $d;
}

?>