<?php

 namespace Myfc;
 
 use Myfc\App\Poster;
 use Myfc\App\Getter;
 use Myfc\App\Binder;
 use Myfc\App\Animater;
 use Myfc\App\Submiter;
 use Myfc\App\Clicker;
 use Closure;
 
 class JqueryApp
 
 {
     
     
     public $selectedDiv;
     
     public $content;
     
     public $the;
     
     public $makro;
     
     
     public function __construct($div = '')
     {
         $this->selectedDiv = $div;
         $this->the = clone $this;
        
         
         
     }
     
     
     public function clean()
     {
         
         $this->content = "";
         
     }
     
     /**
      * Ýçeriði almakda kullanýlýr
      * @return string
      */
     
     public function getContent($clean = false)
     {
         if($clean)
         {
             
             $this->clean();
             
         }
         return $this->content;
         
     }
     
     /**
      * Seçilen divi döndürür
      * @return string
      */
     
     public function getSelectedDiv()
     {
         
         return $this->selectedDiv;
         
     }
     
     /**
      * Seçili divi deðiþtirir
      * @param string $div
      * @return \Myfc\JqueryApp
      */
     
     public function setDiv($div = '')
     {
         
         $this->selectedDiv = $div;
         return $this;
         
     }
     
     /**
      * Sýnýfa yeni fonksiyon atamasý yapar
      * @param unknown $name
      * @param callable $call
      */
     
     public function makro($name,callable $call)
     {
         
         if(!isset($this->makro[$name]))
         {
             
             $this->makro[$name] = Closure::bind($call,null, get_class());
             
         }
         
     }
     
     /**
      * @see http://api.jquery.com/text/
      * @param string $text
      * @return \Myfc\Jquery
      */
     
     public function text($text = '')
     {
     
         $this->content .= "$('$this->selectedDiv').text('$text'); \n";
         return $this;
     
     }
     
     /**
      * @see http://api.jquery.com/load/
      * @param string $uri
      * @return \Myfc\Jquery
      */
     
     public function load($uri = '')
     {
     
         $this->content .= "$('$this->selectedDiv').load('$uri'); \n";
         return $this;
     
     }
     

     /**
      * @see http://api.jquery.com/css/
      * @param unknown $css
      * @param unknown $properity
      * @return \Myfc\Jquery
      */
     
     public function css($css,$properity)
     {
     
         $this->content .= "$('$this->selectedDiv').css('$css','$properity'); \n";
         return $this;
     
     }
     
     /**
      * @see http://api.jquery.com/add/
      * @param string $element
      * @return \Myfc\Jquery
      */
     
     public function add($element = '')
     {
     
         $this->content .= "$('$this->selectedDiv').add('$element'); \n";
         return $this;
     
     }
     
     /**
      * @see http://api.jquery.com/addClass/
      * @param string $class
      * @return \Myfc\Jquery
      */
     public function addClass($class = '')
     {
     
         $this->content .= "$('$this->selectedDiv').addClass('$class'); \n";
         return $this;
     }
     
     /**
      * @see http://api.jquery.com/remove/
      * @param string $element
      * @return \Myfc\Jquery
      */
     
     public function remove($element = '')
     {
     
         $this->content .= "$('$this->selectedDiv').remove('$element'); \n";
         return $this;
     }
     
     /**
      * @see http://api.jquery.com/removeClass/
      * @param string $class
      * @return \Myfc\Jquery
      */
     
     public function removeClass($class = '')
     {
     
         $this->content = "$('$this->selectedDiv').removeClass('$class'); \n";
         return $this;
     }
     
     /**
      * @see http://api.jquery.com/clone/
      * @param string $appentTo
      * @return \Myfc\Jquery
      */
     
     public function cloneElement($appentTo = '')
     {
     
         $this->content .= "$('$this->selectedDiv').clone().appendTo('$appentTo'); \n";
         return $this;
     
     }
     
     /**
      * @see http://api.jquery.com/data/
      * @param string $dataName
      * @param string $dataValue
      * @return \Myfc\Jquery
      */
     
     public function data($dataName = '', $dataValue = '')
     {
     
         $this->content = "$('$this->selectedDiv').data('$dataName','$dataValue'); \n";
         return $this;
     
     }
     
     /**
      * @see http://api.jquery.com/toggleClass/
      * @param string $class
      * @return \Myfc\Jquery
      */
     
     public function toggleClass($class='')
     {
     
     
         $this->content .= "$('$this->selectedDiv').toggleClass('$class'); \n";
         return $this;
     }
     
     /**
      * @see http://api.jquery.com/after/
      * @param string $after
      * @return \Myfc\JqueryApp
      */
     public function after($after ='' )
     {
         
         $this->content .= "$('$this->selectedDiv').after('$after'); \n";
         return $this;
         
     }
     
     
     public function before($before = '')
     {
         
         $this->content .= "$('$this->selectedDiv').before('$before'); \n";
         return $this;
         
     }
     

     /**
      * @see http://api.jquery.com/append/
      * @param string $append
      * @return \Myfc\JqueryApp
      */
     
     public function append($append = '')
     {

          $this->content .= "$('$this->selectedDiv').append('$append'); \n";
          return $this;
         
     }
     
     /**
      * @see http://api.jquery.com/append/
      * @param string $appendTo
      * @return \Myfc\JqueryApp
      */
     
     public function appendTo($appendTo = '' )
     {
         
         $this->content .= "$('$this->selectedDiv').appendTo('$appendTo'); \n";
         return $this;
         
     }
     
     /**
      * @see http://api.jquery.com/attr/
      * @param unknown $name
      * @param unknown $value
      * @return \Myfc\JqueryApp
      */
     
     public function attr($name,$value)
     {
         
         $this->content .= "$('$this->selectedDiv').attr('$name','$value'); \n";
         
         return $this;
         
     }
     
     /**
      * @see http://api.jquery.com/prop/
      * @param unknown $name
      * @param unknown $value
      */
     
     public function prop($name,$value)
     {
         
         $this->content .= "$('$this->selectedDiv').prop('$name','$value'); \n";
         return $this;
         
     }
     

     /**
      * @see http://api.jquery.com/bind/
      * @param unknown $event
      * @param string $callable
      * @return \Myfc\JqueryApp
      */
     
    public function bind($event, $callable = null)
    {
     
      $bind = new Binder($this->the);
      
      $content = $bind->bind($this->selectedDiv, $event, $callable)->getContent();
      
      $this->content .= $content;
      
      return $this;
         
    }
    
    /**
     * @see http://api.jquery.com/live/
     * @param unknown $event
     * @param string $callable
     * @return \Myfc\JqueryApp
     */
     
    public function live($event, $callable = null)
    {
         
        $bind = new Liver($this->the);
    
        $content = $bind->live($this->selectedDiv, $event, $callable)->getContent();
    
        $this->content .= $content;
    
        return $this;
         
    }
    
    /**
     * @see http://api.jquery.com/click/
     * @param callable $callable
     * @return \Myfc\JqueryApp
     */
    
    public function click(callable $callable)
    {
        
        $click = new Clicker($this);
        
        $content = $click->click($this->selectedDiv, $callable)->getContent();
        
        $this->content .= $content;
        
        return $this;
        
    }
    
    /**
     * @see http://api.jquery.com/submit/
     * @param callable $callable
     * @return \Myfc\JqueryApp
     */
    
    public function submit(callable $callable)
    {
        
      $submit = new Submiter($this);
      
      $content = $submit->submit($this->getSelectedDiv(), $callable)->getContent();
      
      $this->content .= $content;
      
      return $this;
        
    }
    /**
     *  Veriyi post eder
     *
     * @see http://api.jquery.com/jquery.post/
     * @param unknown $veriler
     * @param unknown $callable
     * @return \Myfc\Jquery
     */
     
    public function post($veriler, $callable)
    {
        
       
        
        $poster = new Poster($this);
        
        
        $div = $this->selectedDiv;
        
        $content =  $poster->post($div, $veriler, $callable);
        
        $this->content .= $content;
    
        return $this;
    }
    
     
 
     
     /**
      * Veriyi get ile gönderir
      * @see http://api.jquery.com/jquery.get/
      * @param unknown $veriler
      * @param unknown $callable
      * @return \Myfc\Jquery
      */
     public function get($veriler, $callable)
     {
          
        $get = new Getter($app);
        
        $content = $get->get($this->selectedDiv, $veriler, $callable);
        
        $this->content .= $content;
     
         return  $this;
          
     }
     
     /**
      * @see http://api.jquery.com/animate/
      * @param unknown $array
      * @param number $ms
      * @param unknown $callable
      */
     
     public function animate($array,$ms = 2000, $callable)
     {
       
        $animate = new Animater($this);
        
        $content =  $animate->animate($this->getSelectedDiv(), $array, $ms, $callable)->getContent();
        
        $this->content .= $content;
        
        return $this;
          
     }
     
     /**
      * Girilen veriyi jquery nin  anlayacaðý formata döndürür
      * @param array $encoder
      * @return string
      */
     
     public function encoder( array $encoder = array() )
     {
     
         $s = "{";
     
         foreach ( $encoder as $key => $value ){
             
             if(strstr($key, "-"))
             {
                 
                 $keyexp = explode("-",$key);
                 
                 $ends = end($keyexp);
                 
                 $end = mb_convert_case($ends, MB_CASE_TITLE);
                 
                 unset($keyexp[1]);
                 
                 $keyexp[] = $end;
                 
                 $key = implode("", $keyexp );
                 
             }
     
             if( !is_numeric($value)) $value = "'$value'";
     
             $s .= "$key: $value,";
     
         }
     
         $s = rtrim($s,",")."}";
     
         return $s;
     
     }
     
     public function functionEncoder( array $encode = array () )
     {
         
         $app = $this;
         
         $s = "{";
         
         foreach($encoder as $key => $value ){
             
             $s .= "$key: function(){ \n";
             
             $s .= $value($app)->getContent();
             
             $s .= "},";
             
         }
         
         $s = rtrim($s,",")."}";
         
         return $s;
         
     }
     
     public function __call($name, $params)
     {
         
         return call_user_func_array(array($this->makro,$name), $params);
         
     }
     
 }
 