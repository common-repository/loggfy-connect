<?php
namespace LoggfyMonitoring\Controllers;

use LoggfyMonitoring\Base\BaseController;
use LoggfyMonitoring\Base\Callbacks\Callbacks;
use LoggfyMonitoring\Base\SettingsApi;

class LoggfyMonitoring_DashboardController extends BaseController
{
    public $settings;
    public $callbacks;
    public $callbacks_mngr;
    public $pages = array();
    public $subpages = array();

    public function register()
    {
        $this->settings = new SettingsApi();
        $this->callbacks = new Callbacks();
        $this->setPages();
        $this->settings->addPages($this->pages)->withSubPage('Dashboard')->register();
    }

    public function setPages()
    {
        $this->pages = array(
            array(
                'page_title' => 'Loggfy Monitoring',
                'menu_title' => 'Loggfy Monitoring',
                'capability' => 'manage_options',
                'menu_slug' => 'loggfy_monitoring',
                'callback' => array($this->callbacks, 'dashboard'),
                'icon_url' => 'dashicons-chart-line',
                'position' => 10,
                'show_at_menu' => true,
            ),
        );
    }
}
