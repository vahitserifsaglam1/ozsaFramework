<?php


 class String
 {


      protected $string;

      protected $director;

      protected $assets;

     protected $length;

      public function __construct( $string = null )
      {

          if( function_exists('mb_substr') )
          {
              if( null !== $string)
              {
                  $this->string = $string;
              }
          }else{
              throw new Exception(' bu sınıf mbstring eklentisi gerektirir');
          }

      }

     public function append ( String $string = '' )
     {
          $this->string .= $string;
         return $this;
     }

      public function prepend ( String $substring = '' )
      {
          $this->string = $substring.$this->string;
          return $this;
      }

      public function length()
      {
          $this->length = strlen($this->string);
          return $this;
      }

      public function sub( $baslangic = 0, $son = 10)
      {
         $metin =  substr($this->string,$baslangic,$son);
          $this->string = $metin;
          return $this;

      }

     public function replace( $aranan , $degiscek )
     {
        $metin = str_replace($aranan,$degiscek,$this->string);

          $this->string = $metin;

           return $this;
     }
     public function  repeat( $metin , $sayi )
     {
          $metin = str_repeat( $metin , $sayi );

            $this->string = $metin;

             return $this;
     }

     public function matchAll( $pattern )
     {
        $bulunan =  preg_match_all( $pattern, $this->string );

          return $bulunan;
     }

      public function match( $pattern ) {
          $bulunan =  preg_match( $pattern, $this->string );

          return $bulunan;
      }
     public function type()
     {
         return gettype($this->string);
     }

     public function setString( $string )
     {
         $this->string = $string;
         $this->length($string);
     }

     public  function setType( $type )
     {
         return $type($this->string);
     }
     public function setArray()
     {
          $array = array();

          $array[] = $this->string;

         return  $array;
     }
 }