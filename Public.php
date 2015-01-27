<?php
$PublicFiles = array(
    'appPath' => 'app/',
    'SystemPath' => 'System/',
    'base' =>  dirname("../../index.php")
);
$PublicFiles['ViewsPath'] = $PublicFiles['appPath'].'Views/';
$PublicFiles['ModalsPath'] = $PublicFiles['appPath'].'Modals/';
extract($PublicFiles);
?>

