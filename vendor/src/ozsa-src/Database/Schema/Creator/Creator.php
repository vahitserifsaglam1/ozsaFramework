<?php

  namespace Database\Schema;


  use Composer\Autoload\ClassLoader as Composer;
  use Filesystem;

  class Creator{

      protected $ormPath;

      protected $path;

      protected $fileSystem;

      protected $ormName = "orm.json";

      protected $ormInc;

      protected $classNames = null;

       public function __construct( $ormPath )
       {
           $this->fileSytem = Filesystem::boot('Local');

           $ormName = $this->ormName;

           $this->ormPath = $ormPath;



           if( !$this->fileSystem->exists($this->ormPath) )
           {
             throw new \Exception( sprintf(" %s yolunda %s bulunamadı",$ormPath,$ormName));
           }



           $this->ormInc = include $this->ormPath;

       }

      protected function createClassNames()
      {

          $inc = $this->ormInc;

          $decode = json_decode($inc,true);

           foreach($decode as $key => $value )
           {

                $this->classNames[] = $key;

           }

      }

      protected function createClassFiles(){

          foreach ($this->classNames as $key)
          {

              $class = "<?php \n
                class $key extends Database  \n { \n ".'$table_name='.$key." \n public function __construct(){ \n parent::__construct(); \n } \n }";
                $file = 'vendor/src/ozsa-src/Database/Schema/Creator/Created/'.$key.'.php';

                if( $this->fileSystem->exists($file))
                {
                    $this->fileSystem->Create($file);
                }
             Composer::$loader->addClassMap(
                 array(
                    $key => 'src/ozsa-src/Database/Schema/Creator/Created/'.$key.'.php'
                 )
             );
          }

      }

  }