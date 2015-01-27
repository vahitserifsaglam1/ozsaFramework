<?php


class App
{
    public static function IncludeSystemFiles()
    {
        global $PublicFiles;
        extract($PublicFiles);
        require $appPath."Configs/SystemFiles.php";

        foreach($SystemFiles as $key)
        {
            require $key;
        }
    }
}


?>