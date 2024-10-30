<?php
/**
 * @package  LoggfyMonitoring
 */

namespace LoggfyMonitoring\Base\Callbacks;

use LoggfyMonitoring\Base\BaseController as BaseController;

class Callbacks extends BaseController
{
    public function dashboard()
    {
        try {
            $setting = get_option('loggfy_settings');
            $loggfy_api_key = $setting['loggfy_api_key'];
        } catch (Exception $e) {
            return require_once "$this->plugin_path/templates/error.php";
        }

        $api_url = 'https://app.loggfy.com/api/v1/reports/wordpress';
        $context = stream_context_create(array(
            'http' => array(
                'header' => [
                    "Content-Type: application/json",
                    "Accept: application/json",
                    "Authorization: Bearer ". $loggfy_api_key,
                ],
            ),
        ));

        $result = @file_get_contents($api_url, false, $context);
        $data = [];

        if ($result) {
            $data = \json_decode($result);
        }else{
            return require_once "$this->plugin_path/templates/error.php";   
        }
        return require_once "$this->plugin_path/templates/dashboard.php";
    }
}
