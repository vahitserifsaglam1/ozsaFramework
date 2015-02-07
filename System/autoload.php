 <?php
/**
 *  ***********************************
 *
 *   Composer Autoload Sınıfının yüklenmesi
 *
 *  **********************************
 */
require_once '../vendor/autoload.php';

/**
 *   ***********************************
 *
 *   Sayfa açılış süresinin ve hafıza kullanımının test edilmesi
 *
 *   ***********************************
 */


$Benchmark = Desing\Single::make('Ozsa\Benchmark');

$Benchmark->memory('Baslangic')->micro('Baslangic');

/**
 *   ************************************
 *
 *    Uygulamayı çağıran sınıfın yüklenmesi
 *
 *  ***************************************
 */


new \App\App($pathOptions, $dbConfigs);

/**
 *
 *   Benchmark herşey çalıştırdan sonraki son verileri topluyor
 *
 *
 */
$Benchmark->memory('Son')->micro('Son');











?>