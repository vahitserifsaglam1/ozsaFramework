<?php 
 
  Once::extras('Jquery.php');

  Jquery::post(
    'gonder.php',
      '#form',
        Jquery::func(
             '',
               '',
                 Jquery::html(
                 	'.sonuc',
                 	 '<p>ASDADS</p>',
                 	   true
                 	 ),true
        	),false
  	);
  Jquery::extract();

?>