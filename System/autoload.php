 <?php
/**
 *  ***********************************
 *
 *   Composer Autoload Sınıfının yüklenmesi
 *
 *  **********************************
 */
   require_once 'vendor/autoload.php';



/**
 *   ************************************
 *
 *    Uygulamayı çağıran sınıfın yüklenmesi
 *
 *  ***************************************
 */



   $app = new \App\App($pathOptions,$dbConfigs);













?>