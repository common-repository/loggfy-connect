<?php
/*
 * Plugin Name: Loggfy Connect
 * Plugin URI: https://www.loggfy.com
 * Description: Website Monitoring Service, Test your website's availability, get alerted when your site is down. 
 * Author: loggfy.com
 * Version: 0.1
 * Author URI: https://loggfy.com
 * License: MIT
 * Text Domain: loggfy
 */

defined('ABSPATH') or die('Hey, what are you doing here? You silly human!');

// Require once the Composer Autoload
if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

/**
 * The code that runs during plugin activation
 */
function activate_loggfy_monitoring_connect()
{
    LoggfyMonitoring\Base\Activate::activate();
}
register_activation_hook(__FILE__, 'activate_loggfy_monitoring_connect');

/**
 * The code that runs during plugin deactivation
 */
function deactivate_loggfy_monitoring_connect()
{
    LoggfyMonitoring\Base\Deactivate::deactivate();
}

register_deactivation_hook(__FILE__, 'deactivate_loggfy_monitoring_connect');

if (class_exists('LoggfyMonitoring\LoggfyMonitoring')) {
    LoggfyMonitoring\LoggfyMonitoring::register_services();
}

add_action('admin_menu', 'loggfy_add_admin_menu');
add_action('admin_init', 'loggfy_settings_init');

function loggfy_add_admin_menu()
{
    add_options_page('loggfy', 'Loggfy', 'manage_options', 'loggfy', 'loggfy_options_page');
}

function loggfy_settings_init()
{

    register_setting('pluginPage', 'loggfy_settings');

    add_settings_section(
        'loggfy_pluginPage_section',
        __('', 'loggfy'),
        'loggfy_settings_section_callback',
        'pluginPage'
    );

    add_settings_field(
        'loggfy_api_key',
        __('API Key ', 'loggfy'),
        'loggfy_api_key_render',
        'pluginPage',
        'loggfy_pluginPage_section'
    );
}

add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'loggfy_add_plugin_page_settings_link');
function loggfy_add_plugin_page_settings_link( $links ) {
	$links[] = '<a href="' .
		admin_url( 'options-general.php?page=loggfy' ) .
		'">' . __('Settings') . '</a>';
	return $links;
}

function loggfy_api_key_render()
{
    $options = get_option('loggfy_settings');
    ?>
<input type='text' name='loggfy_settings[loggfy_api_key]' value='<?php echo $options['loggfy_api_key']; ?>'>
<?php

}

function loggfy_settings_section_callback()
{
    echo __('Enter your API key', 'loggfy');
}

function loggfy_options_page()
{
    if (!current_user_can('manage_options')) {
        wp_die('You do not have sufficient permissions to access this page.');
    }
    ?>
<div class="wrap">
<h1>Loggfy Settings</h1>
    <form action='options.php' method='post'>

    <table class="form-table">

        <?php
    settings_fields('pluginPage');
    do_settings_sections('pluginPage');
    submit_button();
    ?>
    </table>
    </form>

    <p><strong>How to add moniting to your wordpress: </strong></p>
    <ul>
        <li><p>Visit <a href="https://app.loggfy.com/register">Create a new account at Loggfy</a></p></li>
        <li><p>Add your wordpress site url to Services page</p></li>
        <li><p>We will create your account and send your API key to your email address</p></li>
        <li><p>You will monitor your wordpress and get notifications when your site is down</p></li>
    </ul>
</div>
<?php
}