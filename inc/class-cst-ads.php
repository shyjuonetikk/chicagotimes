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
	private $default_vars = array(
		'logic' => array(),
		'header' => false,
		'footer' => false,
		'header-remote' => false,
		'footer-remote' => false,
		'params' => array(
			'argument' => false,
			'value' => false,
		),
	);


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
		$parameters = wp_parse_args( $vendor_properties, $this->default_vars );

		// Add the vendor to our registered list
		$this->add_vendor( $vendor_name, $parameters );
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

	/**
	 * @return WP_Error
	 * Logic around checking if we can enqueue the script(s) related to an ad vendor
	 */
	public function scripts() {

		foreach ( $this->registered_vendors as $vendor_name => $registered_vendor ) {
			if ( ! array_key_exists( $vendor_name, $this->registered_vendors ) ) {
				return new \WP_Error( -1, 'Ad Vendor not found' );
			}
			if ( ! empty( $registered_vendor['logic'] ) ) {
				foreach ( $registered_vendor['logic'] as $func => $display_logic_function ) {
					$permission_to_enqueue = false;
					if ( is_array( $display_logic_function ) ) {
						if ( 'obj' === $display_logic_function[0] ) {
							$obj = \CST\Objects\Post::get_by_post_id( get_queried_object_id() );
							if ( false !== $obj && $obj->get_post_type() === 'cst_article' ) {
								$permission_to_enqueue = is_callable( array( $obj, $display_logic_function[1] ) ) && call_user_func( array( $obj, $display_logic_function[1] ) );
							}
						}
					} else {
						if ( has_filter( $display_logic_function ) ) {
							$permission_to_enqueue = apply_filters( $display_logic_function, $permission_to_enqueue );
						} else {
							$permission_to_enqueue = is_callable( $display_logic_function ) && call_user_func( $display_logic_function );
						}
					}
				}
				if ( $permission_to_enqueue ) {
					if ( $registered_vendor['header'] ) {
						$path = $registered_vendor['header-remote'] ? $registered_vendor['header'] : get_stylesheet_directory_uri() . '/assets/js/vendor/' . $registered_vendor['header'];
						wp_enqueue_script( esc_attr( $registered_vendor['header'] . '-script' ), esc_url( $path ), array( 'jquery' ), null, false );
						$this->localize_vendor( $registered_vendor, $vendor_name, 'header' );
					}
					if ( $registered_vendor['footer'] ) {
						$path = $registered_vendor['footer-remote'] ? $registered_vendor['footer'] : get_stylesheet_directory_uri() . '/assets/js/vendor/' . $registered_vendor['footer'];
						wp_enqueue_script( esc_attr( $registered_vendor['footer'] . '-script' ), esc_url( $path ), array( 'jquery' ), null, true );
						$this->localize_vendor( $registered_vendor, $vendor_name, 'footer' );
					}
				}
			}
		}
	}

	private function localize_vendor( $registered_vendor, $vendor_name, $position ) {
		if ( $registered_vendor['params']['argument'] ) {
			wp_localize_script( esc_attr( $registered_vendor[ $position ] . '-script' ), esc_attr( $vendor_name ), array(
				$registered_vendor['params']['argument'] => wp_json_encode( $registered_vendor['params']['value'] ),
			) );
		}
	}
}

