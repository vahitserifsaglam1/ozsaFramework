<?php
/**
 *  *************************************************
 *
 *   Ozsaframework başlangıç sayfası
 *
 *   Gerekli dosyaların yolları burada ayarlanır
 *
 *  ************************************************
 */
 $pathOptions = [

     /**
      *  ***************************
      *
      *    Frameworkun kurulduğu dosya
      *
      *  ****************************
      */
          'base' => dirname(__FILE__),

     /**
      *  *********************************
      *
      *   Anasayfa Dosyası
      *
      *  ********************************
      */

 	      'HomePage' => 'index.php',
     /**
      *  *********************************
      *
      *   App Dosyasının yolu ( değiştirilebilir )
      *
      *  ********************************
      */
 	      'appPath' => 'app/',
     /**
      *  *********************************
      *
      *   Sistem dosyasının yolu
      *
      *  ********************************
      */
 	      'SystemPath' => 'System/',

     /**
      *  ****************************
      *
      *   Public Dosyasının yolu
      *
      *  **********************
      */
         'PublicFiles' => 'Public/'

      ];
/**
 *  *********************************
 *
 *   System dosyasının içinceki include.php in çağrılması
 *
 *  ********************************
 */
   require_once $pathOptions['SystemPath']."Include.php";

?>