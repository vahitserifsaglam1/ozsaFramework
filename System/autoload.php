 <?php

   require_once 'vendor/autoload.php';

   use Ozsa\Benchmark as Benchmark;

   $Benchmark = new Benchmark();

   $Benchmark->memory('Baslangic')->micro('Baslangic');

   new \Ozsa\App($pathOptions,$dbConfigs);


   $Benchmark->memory('Son')->micro('Son');

?>                                                                                                                                                                        