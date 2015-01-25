<?php
    function include_pagination_css_file()
    {
       echo "<link type='text/css' src='".pagination::$file."'>";
    }
  class Pagination
  {
      /**
       * @var string
       */
      private static $paginationClass;
      /**
       * @var string
       */
      private static $pClass;
      /**
       * @var string
       */
      private static $max;
      /**
       * @var string
       */
      private static  $min;

      /**
       * @var int
       */
       private static $recods;
      /**
       * @param string $paginationClass
       * @param string $pagiClass
       * @return $this;
       */
      private static $url;

      public static $file = "themes/pagination.css";

      public function init($paginationClass = "pagination",$pagiClass = "pagi")
      {
          global $get;
          self::$url = $get->variable("url");

            self::$paginationClass = $paginationClass;
           self::$pClass = $pagiClass;
           add_action("include_style","include_pagination_css_file");
           return $this;

      }

      /**
       * @param int $int
       * @return $this
       */
      public function setRecods($int = 1)
      {
           self::$recods = $int;

      }
      public function page($page)
      {
          self::$activePage = $page;
      
      }
      /**
       * @param $max
       * @return $this
       */
      public function setMax($max)
      {
           self::#max = $max;

      }

      public function setMin($min)
      {

          self::$min = $min;
    

      }

      public static function execute()
      {
         $url =   self::$url;
        $paginationClass =   self::$paginationClass;
        $pClass=   self::$pClass;
        $page =   self::$activePage;
        echo  "<div class='$paginationClass'>".PHP_EOL;
        $recods = $this->recods;
        if( self::$max)
        {
          $max = $this->max;
        }else{
          $max = 100;
        }
        if(  self::$min)
        {

           $min = $this->min;
        }
        else{$min = 15; }
        if( $max && $min )

           {
              $minpage = ($page-$min);
                 
             $minpage =   ($minpage<1)? 1:$minpage;
              $maxpage = ($minpage+$max);
               $maxpage =  ($maxpage>$recods) ? $recods:$maxpage;
                  $m = $url[0];
                  if(isset($url[2]))

                {
                    
                    if(is_string($url[1]))
                      {
                         
                              $m .= "/".$url[1]."/";

                            
                      }
                     
                }

                 else 
                 {

                      if( isset($url[1]) )

                      {
                       
                         $m .= "/";
                      }

                 }
              for($i = $minpage;$i<=$maxpage;$i++)
              {
                    
                    $link = $m.$i;
                     $query =  "<div class='$pClass'><a href='$link'>".$i."</a></div>";
                   if($page == $i)
                   {
                   $query = "<div class='$pClass active'><a href='$link'>".$i."</a></div>";
                   }
                  echo $query;
                                      
              }

           }

         
        /* if(isset($url[2]))

                {
                    
                    if(is_string($url[1]))
                      {
                         
                              $m .= "/".$url[1]."/".$i."<br/>";

                            
                      }
                     
                }

                 else 
                 {

                      if( isset($url[1]) )

                      {
                       
                         $m .= "/".$i;
                      }

                 }*/
               
                echo "</div>";

      }
  }
