<?php


 interface ozsAINTERFACE
 {
  public static function set($name,$value,$time);
  public static function get($name);
  public static function delete($name);
  public static function flush();
 }
  /**
  * Class ozsaSession
  */
  class Sessions implements ozsAINTERFACE
  {
  	 /**
  	 * @var $sessions
  	 */
     public static $sessions;

      
     public static function set($name,$value,$time = 0)
     {      

        	 $_SESSION[$name] = $value;
        	 self::$sessions = $value;
     }
     public static function get($name) {
     	      if(isset($this->sessions[$name]))
     	      {
     	      	return self::$sessions[$name];
     	      }elseif(isset($_SESSION[$name]))
     	      {
     	      	 return $_SESSION[$name];
     	      }else{
     	      	return false;
     	      }
     }
     /**
     * @param $name
     * @return bool
     */

     public static function remove($name)
     {

     	if(isset($_SESSION[$name]))
     	{

     		session_unset($name);
     		$_SESSION[$name] = "";

     	}

     	 if(isset(self::$sessions[$name]))

     	 {

     	 	unset(self::$sessions[$name]);

     	 }

     	 return true;

     }

     public static function flush()
     {

     	self::$sessions = array();

     	 foreach ($_SESSION as $key => $value) {

     	 unset($_SESSION[$key]);

     	 }

     }
     public static function delete($name)
     {
       if(isset(self::$sessions[$name]) && $_SESSION[$name])
       {
        unset(self::$sessions[$name]);unset($_SESSION[$name]);return true;
       }else{
        return false;
       }
     }

  }

  /**
  * Class ozsaCookie
  */ 

   class Cookie implements ozsAINTERFACE
   {

     public static function get($name)
     {

         return (isset($_COOKIE[$name])) ? $_COOKIE[$name]:false;

     }

     /**
     * @param $name
     * @param $value
     * @param int $time
    */
     
     public static  function set($name,$value,$time = 3600)
     {
       if(is_array($value))
       {
        foreach ($value as $names => $key) {
         setcookie("$name[$names]",$key,time()+$time);
        }
      }
       else{
         setcookie($name,$value,time()+$time);
       }
       
     }

    /**
    * @param $name
    */

     public static  function delete($name)
     {

        (isset($_COOKIE[$name]))  ? setcookie($name,"",time()-60*60*60*60*60) : null;

     }
     
     public static function flush()
     {

       foreach ($_COOKIE as $key => $value) {
        setcookie($key,"",time()-60*60*60*60*60);
       }

     }

   }

?>