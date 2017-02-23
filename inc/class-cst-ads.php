<?php

/**
 * Class CST_Ad_Vendor_Handler
 *
 * Basic centralized handler to generate and return the
 * markup for third party ad vendors
 */
class CST_Ad_Vendor_Handler {

	private $registered_vendors = array();
	private static $instance;

	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new CST_Ad_Vendor_Handler();
		}
		return self::$instance;
	}

	/**
	 * @param string $vendor_name Short name to refer to vendor and related vendor data
	 * @param array $vendor_properties all vendor data for scripts and other processing
	 * @return bool|WP_Error true if registration successful
	 */
	public function register_vendor( $vendor_name, $vendor_properties ) {

		if ( in_array( $vendor_name, $this->registered_vendors, true ) ) {
			return new \WP_Error( -1, 'Ad Vendor already registered' );
		}
		// Add the vendor to our registered list
		$this->add_vendor( $vendor_name, $vendor_properties );
		return true;
	}
	/**
	 * @param string $vendor_properties uri to script
	 * @param string $vendor_name of vendor
	 *
	 */
	public function add_vendor( $vendor_name, $vendor_properties ) {

		// Process adding script / params to content
		$this->registered_vendors[ sanitize_text_field( $vendor_name ) ] = $vendor_properties;
		$this->enqueue_vendor();
	}

	private function enqueue_vendor() {
		add_action( 'wp_enqueue_scripts', [ $this, 'scripts' ], 10, 2 );
	}

	public function scripts( $vendor_name ) {

		foreach ( $this->registered_vendors as $vendor_name => $registered_vendor ) {
			if ( ! array_key_exists( $vendor_name, $this->registered_vendors ) ) {
				return new \WP_Error( -1, 'Ad Vendor not found' );
			}

			if ( $registered_vendor['header'] ) {
				wp_enqueue_script( esc_attr( $registered_vendor['header'] . '-script' ), esc_url( get_stylesheet_directory_uri() . '/assets/js/vendor/' . $registered_vendor['header'] ), array( 'jquery' ), null, false );
			}
			if ( $registered_vendor['footer'] ) {
				wp_enqueue_script( esc_attr( $registered_vendor['footer'] . '-script' ), esc_url( get_stylesheet_directory_uri() . '/assets/js/vendor/' . $registered_vendor['footer'] ), array( 'jquery' ), null, true );
			}
		}
	}
}

