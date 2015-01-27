<?php
/*
* @author OzsaFrameWork
*/
class Hook{
    private $hooks;
    function __construct()
    {
        $this->hooks=array();
    }
    function add_action($where,$callback,$priority=50)
    {
        if(!isset($this->hooks[$where]))
        {
            $this->hooks[$where]=array();
        }
        $this->hooks[$where][$callback]=$priority;
    }
    function remove_action($where,$callback)
    {
        if(isset($this->hooks[$where][$callback]))
            unset($this->hooks[$where][$callback]);
    }
    function execute($where,$args=array())
    {
        if(isset($this->hooks[$where])&&is_array($this->hooks[$where]))
        {
            arsort($this->hooks[$where]);
            foreach($this->hooks[$where] as $callback=>$priority)
            {
                call_user_func_array($callback,$args);
            }
        }
    }
};
$hooking_daemon=new hooking;
function add_action($where,$callback,$priority=50)
{
    global $hooking_daemon;
    if(isset($hooking_daemon))
        $hooking_daemon->add_action($where,$callback,$priority);
}
function remove_action($where,$callback)
{
    global $hooking_daemon;
    if(isset($hooking_daemon))
    $hooking_daemon->remove_action($where,$callback);
}
function execute_action($where,$args=array())
{
    global $hooking_daemon;
    if(isset($hooking_daemon))
    $hooking_daemon->execute($where,$args);
}
?>