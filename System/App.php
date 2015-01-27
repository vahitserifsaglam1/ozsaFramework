<?php
         


        require $appPath."Configs/SystemFiles.php";

        foreach($SystemFiles as $key )
        {
                require $key;
        }

         use Lib\set\set as set;
         use Lib\get\get as get;
         use Session\Session as Session;
         use Lib\Security\Security as security;
         use Cookie\Cookie as Cookie;
         use Html\Request\Request as Request;
         use Multidb\Multidb as Multidb;
         use Multidb\mysql;
         $db = new Multidb;
    ?>n