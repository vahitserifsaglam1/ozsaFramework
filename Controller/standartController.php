<?php 
 
  class standartController{
  	public function __construct($controller)
  	{
  		global $standartControllerError;
        
  		 if($standartControllerError == true)
  		 {
  		 	error::newError("$controller Controller dosyanız bulunamamıştır bu yüzden standart controller dosyanız çağrıldı".PHP_EOL.'Bu hatayı almak istemiyorsanız config.php de $standartControllerError u değiştirmeniz gerekir');
  		 }
  	}
  }

 ?>