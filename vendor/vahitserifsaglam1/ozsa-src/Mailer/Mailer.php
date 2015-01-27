<?php

  namespace Mailer;
   class Mail
   {
   	  public static $username;
   	  public static $password;
   	  public static $host = "stmp.gmail.com";
   	  public static $post = 587;
   	  public static $charset = 'UTF-8';
      public static $mailer; 

   	  public static function init($username,$password,$host,$port)
   	     {
   	     	 self::$username = $username;
   	     	 self::$passsword = $password;
   	     	 self::$host = $host;
   	     	 self::$port = $port;
                
                 include $PublicFiles['app']."extras/class/class.phpmailer.php";
             self::$mailer = new PHPMailer();
           
   	     }

   	     public static function send($adress,$name,$subject,$html)
   	     {
   	     	self::$mailer->Host = self::$host;
   	     	self::$mailer->Port = self::$port;
   	     	self::$mailer->SMTPSecure = self::$secure;
   	     	self::$mailer->CharSet = 'UTF-8';
   	     	self::$mailer->addAddress($adress,$name);
   	     	self::$mailer->Subject = $subject;
   	     	self::$mailer->MsgHTML = $html;
          
            if($self::$mailer->Send()) return true;else return false;
   	     }
   	     public static function __callStatic($name,$param)
   	     {
   	     	 $kontrol = method_exists(self::$mailer, $name);
               
               if($kontrol)
               {
               	 return call_user_func_array(array('PHPMailer',$name),$param);
               }else{
               	 $pname = $param[0];
               	 $pvalue = $param[1];
               	 self::$mailer->$pname = $pvalue;
               }

   	     }
   }
  ?>