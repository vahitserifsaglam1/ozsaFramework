<?php


    class Auth extends DB
    {

        public  $userTable;

        public static $booted;

        public static $key;

        public function __construct( $userTable )
        {
            $this->userTable = $userTable;

        }

        public function setTable($table)
        {
           $this->userTable = $table;
        }

        public static function boot( $userTable = 'user' )
        {
          return new static($userTable);

        }

        private static function creator($array)
        {
             $msg = '';
             $value = array();
          foreach ( $array as list($key,$values)){
              $msg .= $key.'= ? AND ';
              $value[] = $values;
          }
            return array(
                'key' => rtrim($msg," AND "),
                'value' => $value
            );
        }

        public static function Http_Auth( $metin = "OzsaFramework")

        {

            if (!isset($_SERVER['PHP_AUTH_USER'])) {
                header('WWW-Authenticate: Basic realm="'.$metin.'"');
                header('HTTP/1.0 401 Unauthorized');
                echo 'Doğrulamayı Pas geçtiniz';
                exit;
            } else {
                if( static::attempt(['email' => $_SERVER['PHP_AUTH_USER'],
                'passoword' => $_SERVER['PHP_AUTH_PW']]))
                {
                  #echo "giriş doğru";
                }else{
                   # echo "giriş yanlış";
                }

            }
        }

        public static function attempt ( Array $array = array(), $remember = false)
        {

            $creator = static::creator($array);

              $key = $creator['key'];

              $values = $creator['value'];

              $query = parent::query($key);

              $src =  $query->execute($values);

               if( $src )
               {

                   if ( $src->rowCount() )
                   {

                       if($remember)
                       {
                           Session::set('login', $key[0]);
                           $time =  \Carbon\Carbon::now()->addHour(5);
                           Cookie::set('login',$key[0], $time);

                       }

                       return true;

                   }  else{

                       return false;

                   }
               }else{

                   return false;
               }

            static::$key = $values[0];

        }

        public static function check()
        {
            $get = Session::get('login');

            if( $get )
            {
                 if( isset($get) )
                 {

                       if($get == static::$key )

                       {

                            return true;

                       }


                 }else{
                     return false;
                 }
            }else{
                return false;
            }

        }

    }

?>