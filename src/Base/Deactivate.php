<?php
/**
 * @package  LoggfyMonitoring
 */
namespace LoggfyMonitoring\Base;

class Deactivate
{
	public static function deactivate() {
		flush_rewrite_rules();
	}
}