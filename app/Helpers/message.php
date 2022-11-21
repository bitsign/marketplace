<?php

if (!function_exists('alert'))
{
    /**
     * @param string $type
     * @param string $message
     * @return void
     */
    function alert($type,$message)
    {
        $system_messages = [];
        $system_messages = session('system_messages');
        if (empty($system_messages))
            $system_messages = [];

        if (!isset($system_messages[$type]))
            $system_messages[$type] = [];

        $system_messages[$type][] = $message;
        session()->put('system_messages',$system_messages);
    }
}


if (!function_exists('clear_system_messages'))
{
    function clear_system_messages()
    {
        session()->put('system_messages',[]);
    }
}

if (!function_exists('get_system_messages'))
{
    function get_system_messages()
    {
        return !empty(session('system_messages')) ? session('system_messages') : array();
    }
}
