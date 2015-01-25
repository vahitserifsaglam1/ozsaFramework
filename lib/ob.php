<?php class ob{
    public  static function url($url,$refresh = true,$time = 2)
    {
        if($refresh)
        {

            header("Refresh:$time,url=$url");
        }
        else
        {
            header("Location:$url");
        }
    }
}
?>