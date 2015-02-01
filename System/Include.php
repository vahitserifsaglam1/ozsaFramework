<?php

    /**
    *********************************************************
    *  Gerekli sabitlerin tanımlanması ve gerekli dosyaların yüklenmezi
    *******************************************************
    *
    * Sunucunun Yüklenme Zamanı
    */
    define('OZSA_START',microtime(true));

     /**
     *  Sınfılarda Kullanılacak app/ konumunun sabiti
     */

    define('APP_PATH',$pathOptions['appPath']);
    
    /**
    *  Sınıflarda Kullanılacak olan System klasörünün sabiti
    */

    define('SYSTEM_PATH',$pathOptions['SystemPath']);

    /**
    *  Sınıflarda kullanılacak anasayfa nın tanımlanması
    */

    define('INDEX',$pathOptions['HomePage']);
/**
 *  Public dosyasının ayarlanması
 */
    define('_PUBLIC',$pathOptions['PublicFiles']);
/**
 *
 * View Dosyasının ayarlanması
 *
 */
    define('VIEW_PATH',APP_PATH.'Views/');
    
    /**
    *  Ayar Dosyaları
    */
    $dbConfigs = require_once APP_PATH."Configs/Configs.php";
     /**
     * Hata Sınıfı
     */
    require_once APP_PATH."Error/errorException.php";
    /**
    * Fonksion dosyaları
    */
    require_once APP_PATH."Lib/Functions.php";
    /**
    * Yükle dosyasınn çağrılması
    */
    require_once __DIR__."/autoload.php";


?>