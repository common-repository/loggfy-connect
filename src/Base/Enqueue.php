<?php 
/**
 * @package  LoggfyMonitoring
 */
namespace LoggfyMonitoring\Base;

use LoggfyMonitoring\Base\BaseController;

class Enqueue extends BaseController
{
	public function register() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
 	}
 
	function enqueue() {
		// enqueue all our scripts
		wp_enqueue_script( 'media-upload' );
		wp_enqueue_media();

		wp_enqueue_style( 'loggfy_monitoring_bootstrap_css', $this->plugin_url . 'assets/css/bootstrap.min.css' );
		wp_enqueue_style( 'loggfy_monitoring_pluginstyle', $this->plugin_url . 'assets/css/Chart.min.css' );
 
		wp_enqueue_style( 'loggfy_monitoring_jquery-ui.min_style', $this->plugin_url . 'assets/css/jquery-ui.min.css' );
		wp_enqueue_style( 'loggfy_monitoring_jquery-ui.structure.min_style', $this->plugin_url . 'assets/css/jquery-ui.structure.min.css' );
	
		wp_enqueue_script( 'loggfy_monitoring_bootstrap__scripts', $this->plugin_url . 'assets/js/bootstrap.bundle.js' );		
		wp_enqueue_script( 'loggfy_monitoring_vendor_scripts', $this->plugin_url . 'assets/js/scripts.js' );
		wp_enqueue_script( 'loggfy_monitoring_jquery-ui.min_scripts', $this->plugin_url . 'assets/js/jquery-ui.min.js' );

		wp_enqueue_script( 'global', $this->plugin_url . 'assets/js/global.js');

		wp_localize_script(
			'global',
			'global',
			array(
				'ajax' => admin_url( 'admin-ajax.php' ),
			)
		);	
	}
}