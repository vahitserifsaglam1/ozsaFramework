<?php
         /** ********************************************
               *      Standart Dosyaların Ayarlanması
        **********************************************/

$PublicFiles = array(
    'appPath' => 'app/',
    'SystemPath' => 'System/',
    'base' =>  __DIR__,
    'HomePage' => 'index.php',
);
$PublicFiles['ViewsPath'] = $PublicFiles['appPath'].'Views/';
$PublicFiles['ModalsPath'] = $PublicFiles['appPath'].'Modals/';
extract($PublicFiles);
   include $SystemPath."/Include.php";
?>

