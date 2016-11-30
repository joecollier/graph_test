<?php
namespace Editor\Controllers;

class MessageHandler
{
    public function __construct()
    {

    }

    public static function output($msg)
    {
        echo $msg . "\n";
    }

    public static function outputError($msg)
    {
        $msg = "[ERROR] " . $msg;

        self::output($msg);
    }
}
