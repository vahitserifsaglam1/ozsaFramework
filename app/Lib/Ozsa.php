<?php

Class Ozsa
{
    public static function encode($array)
    {
        $ozsa = "#";
        if(is_array($array))
        {
            foreach ($array as $key => $value) {
                $ozsa .= $key."/";
                if(is_array($value))
                {
                    $ozsa .=self::export_array($value);
                }else{
                    $ozsa .= $value;
                }
                $ozsa .= "#";
            }
            $ozsa = rtrim($ozsa,"#");
            return $ozsa;
        }
    }
    public static function export_array($array)
    {

        $ozsa = "#";
        if(is_array($array))
        {
            foreach($array as $key => $value)
            {
                $ozsa .= "$key/";
                if(is_array($value))
                {
                    $ozsa .= self::export_array($value);
                }else{
                    $ozsa .= $value;
                }
                $ozsa .= "#";
            }
            $ozsa =  rtrim($ozsa,"#");
        }
        return $ozsa;
    }
    public static function decode($value)
    {
        $value = ltrim($value,"#");
        $ilkAyir = explode("#",$value);
        $return = array();
        foreach ($ilkAyir as $key) {
            $ikinciAyir  = explode("/", $key);
            $return[] = $ikinciAyir;
        }
        return $return;
    }
}
?>