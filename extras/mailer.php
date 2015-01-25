<?php
 include "class.phpmailer.php";

/**
 * Class mailer
 */
  class mailer extends PHPMailer
  {
      /**
       * @return $this;
       */
    public function __construct(){
        parent::__construct();
        $this->IsSMTP();
        $this->Host = "stmp.gmail.com";
        $this->Port = 587;
        $this->SMTPSecure = 'tls';
        $this->CharSet = 'UTF-8';
        return $this;
    }

      /**
       * @param $host
       * @return $this
       */
       public function setHost($host){
           $this->Host = $host;
           return $this;
       }
      public function setPort($port)
      {
          $this->Port = $port;
          return $this;
      }
      public function setUser($username,$password)
      {
          $this->Username = $username;
          $this->Password= $password;
      }
      public function setFrom($name){
          $this->SetFrom($this->Username,$name);
          return $this;
      }
       public function addAddress($url,$name)
       {
           $this->AddAddress($url,$name);
           return $this;
       }
       public function setSubject($konu)
       {
           $this->Subject = $konu;
           return $this;
       }
      public function addMsg($msg)
      {
           $this->MsgHTML($msg);
          return $this;
      }
       public function send()
       {
            if($this->Send()){
               return true;
            }else{
                return  $this->ErrorInfo;
            }
       }
  }