<?php

/**
 * Class CST_Ad_Vendor_Handler
 *
 * Basic centralized handler to generate and return the
 * markup for third party ad vendors
 */
class CST_Ad_Vendor_Handler {

	public $header = array();
	public $footer = array();

	private static $instance;

	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new CST_Ad_Vendor_Handler();
		}

		return self::$instance;
	}

	/**
	 * @param string $filename uri to script
	 * @param string $name of vendor
	 *
	 */
	public function add_vendor( $name, $filename ) {

		// Process adding script / params to header
		wp_enqueue_script( esc_attr( $name . '-script' ), esc_url( get_stylesheet_directory_uri() . '/assets/js/vendor/' . $filename ), array( 'jquery' ), null, true );
		// Process adding script / params to footer
		// Process adding script / params to content
	}

}

