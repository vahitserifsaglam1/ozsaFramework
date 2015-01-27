<?php
 
  class ozsaException extends Exception
{
    public function __construct($message, $code = 0,
                                Exception $previous = null) {
        parent::__construct($message, $code, $previous);
        $line = parent::getLine();
        $file = parent::getFile();
        error::setLog($message,$code,$line,$file);
        return null;
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    public function exportClass() {
       $classname = __CLASS__;
       $class = new $classname;
       return $class;
    }
}

?>