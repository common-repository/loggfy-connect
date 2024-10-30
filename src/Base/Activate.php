<?php
/**
 * @package  LoggfyMonitoring
 */

namespace LoggfyMonitoring\Base;

class Activate
{
    public static function activate()
    {
         
        flush_rewrite_rules();
    }

 

}