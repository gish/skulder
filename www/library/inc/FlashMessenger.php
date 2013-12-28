<?php

class FlashMessenger
{
    public static function add($message)
    {
        if (!is_array($_SESSION['flashmessages']))
        {
            $_SESSION['flashmessages'] = array();
        }
        $_SESSION['flashmessages'][] = $message;
    }
    
    public static function getAll()
    {
        $messages = array();
        foreach($_SESSION['flashmessages'] as $message)
        {
            $messages[] = $message;
        }
        return $messages;
    }
    
    public static function flush()
    {
        $_SESSION['flashmessages'] = array();
    }
}