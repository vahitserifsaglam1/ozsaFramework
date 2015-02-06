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
 *   ***********************************
 *
 *   Sayfa açılış süresinin ve hafıza kullanımının test edilmesi
 *
 *   ***********************************
 */

   use Ozsa\Benchmark as Benchmark;

   $Benchmark = new Benchmark();

   $Benchmark->memory('Baslangic')->micro('Baslangic');

/**
 *   ************************************
 *
 *    Uygulamayı çağıran sınıfın yüklenmesi
 *
 *  ***************************************
 */

   new \Ozsa\App($pathOptions,$dbConfigs);

/**
 *
 *   Benchmark herşey çalıştırdan sonraki son verileri topluyor
 *
 *
 */
   $Benchmark->memory('Son')->micro('Son');








?>