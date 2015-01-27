<?php
 namespace Html\Pagination;
    function include_pagination_css_file()
    {
       echo "<link type='text/css' src='".pagination::$file."'>";
    }
  class Pagination
  {
      private static $paginationClass;
      private static $pClass;
      private static $max;
      private static  $min;
      private static $recods;
      private static $activePage;
      private static $url;
      public static $file;
      private static $init  = false;

      public static  function init($paginationClass = "pagination",$pagiClass = "pagi")
      {
           self::$file = "app/Views/css/pagination.css";
           self::$init = true;
           self::$url = get::variable("url");
           self::$paginationClass = $paginationClass;
           self::$pClass = $pagiClass;
           add_action("include_style","include_pagination_css_file");
           if(self::$url[0] == "")
           {
               self::$url = array(
                   'index'
                   ,1
               );
           }else{

           }

           if(count(self::$url) > 2)
           {
             $page = self::$url[2];
           }elseif(count(self::$url) == 2){
            $page = self::$url[1];
           }else{
            $page = 1;
           }
          self::$activePage = $page;
      }

      public static  function setRecods($int = 1)
      {
           self::$recods = $int;

      }
      public static  function page($page)
      {
          self::$activePage = $page;
      
      }
      public static function setMax($max)
      {
           self::$max = $max;

      }
      public static function setMin($min)
      {
          self::$min = $min;
      }
      public static function execute($return = false)
      {

          if(!self::$init) self::init();
         $url =   self::$url;
        $paginationClass =   self::$paginationClass;
        $pClass=   self::$pClass;
        $page =   self::$activePage;
        $sorgu=  "<div class='$paginationClass'>".PHP_EOL;
        $recods = self::$recods;
        if( self::$max)
        {
          $max = self::$min;
        }else{
          $max = 100;
        }
        if(  self::$min)
        {
           $min = self::$min;
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
                     $query =  "<div class='$pClass' style='float:left;'><a href='$link'>".$i."</a></div>";
                   if($page == $i)
                   {
                   $query = "<div class='$pClass active' style='float:left' ><a href='$link'>".$i."</a></div>";
                   }
                  $sorgu .= $query;
                                      
              }

           }

                $sorgu .= "</div>";
          if($return)
          {
              return $sorgu;
          }else{
              echo $sorgu;
          }

      }
  }
