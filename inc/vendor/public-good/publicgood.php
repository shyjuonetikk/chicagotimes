<?php
/**
 * @package Public_Good
 * @version 1.4.1
 */
/*
Plugin Name: Public Good
Plugin URI: http://wordpress.org/plugins/public-good/
Description: This is a bundle of amazingness that lets you access Public Good from Wordpress.
Author: Public Good
Version: 1.4.1
Author URI: https://publicgood.com/
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class Public_Good_Class {

	static $opt_name_source = 'public_good_source';
	static $opt_name_location = 'public_good_location';
	static $opt_name_size = 'public_good_size';

	public function __construct() {
		add_shortcode( 'takeaction', array( $this, 'btn_short_code' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'action_wp_enqueue_scripts' ) );
		add_action( 'init', array( $this, 'btn_add_oembed_provider' ) );
	}

	public function btn_add_oembed_provider( $atts ) {
		wp_oembed_add_provider( 'https://publicgood.com/*', 'https://api.pgs.io/oembed', false );
	}

	function action_wp_enqueue_scripts() {
		if ( is_singular( 'cst_article' ) ) {
			wp_enqueue_script( 'takeactionjs', 'https://assets.pgs.io/button/v2/dpg.js', array(), '', true );
		}
	}

	public function btn_short_code( $atts ) {

		// Set default values for source, location, and cause. All can be overridden.
		$opt_val_cause    = '';
		$opt_val_size     = '';

		// Allow shortcode attributes to override defaults.
		$a = shortcode_atts( array(
			'source'     => 'chicago-sun-times',
			'cause'      => $opt_val_cause,
			'location'   => '',
			'variant'    => $opt_val_size,
			'targettype' => '',
			'targetid'   => '',
			'keywords'   => '',
		), $atts );

		// allow for legacy "cause" attr
		if ( ! empty( $a['cause'] ) ) {
			$a['targettype'] = 'campaign';
			$a['targetid']   = $a['cause'];
		}

		// Return HTML for the button.
		return '<div class="pgs-dpg-btn'
			   . '" data-pgs-partner-id="'
			   . esc_attr( $a['source'] )
			   . '" data-pgs-keywords="'
			   . esc_attr( $a['keywords'] )
			   . '" data-pgs-target-type="'
			   . esc_attr( $a['targettype'] )
			   . '" data-pgs-target-id="'
			   . esc_attr( $a['targetid'] )
			   . '" data-pgs-location="'
			   . esc_attr( $a['location'] )
			   . '" data-pgs-variant="'
			   . esc_attr( $a['variant'] )
			   . '" ></div>';
	}
}

global $public_good_class;
$public_good_class = new Public_Good_Class;
