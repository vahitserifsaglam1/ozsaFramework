<?php
namespace Myfc\App;

/**
 *
 * @author vahitþerif
 *        
 */
class Animater
{

    protected $app;
    
    protected $content;
    
    public function __construct($app)
    {
        
        $this->app = clone $app;
        $this->app->content= "";
        
    }
    
    public function clear()
    {
        
        $this->content = '';
        
    }
    
    public function getContent()
    {
        
        return $this->content;
        
    }
    
    public function animate($div,$array,$ms,$callable)
    {
        
        
         $app = $this->app;
         
         $encoder = $app->encoder($array);
         
         $content = "";
         
         $content .= "$('$div').animate($encoder,$ms,function(){";
          
         $content .= $callable($app)->getContent();
          
         $content .= "}); \n";
          
         $this->content .= $content;
     
         return $this;
        
    }
}

?>