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
		add_action( 'admin_menu', array( $this, 'btn_admin_menu' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'action_wp_enqueue_scripts' ) );
		add_action( 'init', array( $this, 'btn_add_oembed_provider' ) );
	}

	public function btn_add_oembed_provider( $atts ) {
		wp_oembed_add_provider( 'https://publicgood.com/*', 'https://api.pgs.io/oembed', false );
	}

	function action_wp_enqueue_scripts() {
		wp_enqueue_script( 'takeactionjs', 'https://assets.pgs.io/button/v2/dpg.js', array(), '', true );
	}

	public function btn_short_code( $atts ) {

		// Set default values for source, location, and cause. All can be overridden.
		$opt_val_source   = get_option( self::$opt_name_source );
		$opt_val_location = get_option( self::$opt_name_location );
		$opt_val_cause    = '';
		$opt_val_size     = get_option( self::$opt_name_size );;
		$opt_val_creative = '';

		// If there was no source provided in the database, use the server name as a default.
		if ( empty( $opt_val_source ) ) {
			$opt_val_source = $_SERVER['SERVER_NAME'];
		}

		// Allow shortcode attributes to override defaults.
		$a = shortcode_atts( array(
			'source'     => $opt_val_source,
			'cause'      => $opt_val_cause,
			'location'   => $opt_val_location,
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

	function btn_admin_menu() {
		add_options_page( 'Public Good Options', 'Public Good', 'manage_options', 'public-good-admin', array( $this, 'public_good_options' ) );
	}

	function public_good_options() {

		$user_msg = '';

		// Make sure we have an admin here.
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}

		if ( isset( $_POST['submitted'] ) && sanitize_text_field( $_POST['submitted'] ) == 'Y' ) {

			// Clean and validate input
			$opt_val_source   = sanitize_text_field( $_POST ['source'] );
			$opt_val_location = sanitize_text_field( $_POST ['location'] );
			$opt_val_size     = sanitize_text_field( $_POST ['size'] );

			// Save the posted value in the database
			update_option( self::$opt_name_source, $opt_val_source );
			update_option( self::$opt_name_location, $opt_val_location );
			update_option( self::$opt_name_size, $opt_val_size );

			// Put a "settings saved" message on the screen
			$user_msg = 'Thanks! Your changes have been saved.';

		} else {

			// If the form was not submitted, retrieve existing values
			$opt_val_source   = get_option( self::$opt_name_source );
			$opt_val_location = get_option( self::$opt_name_location );
			$opt_val_size     = get_option( self::$opt_name_size );
		}

		?>
		<?php if ( ! empty( $user_msg ) ) { ?>
			<div class="updated"><p><?php print $user_msg; ?></p></div>
		<?php } ?>
		<h1>Public Good</h1>
		<h2> Take Action Button</h2>
		<div class="wrap">
			<p>Thanks for using the Take Action Button (TAB) plugin. You can create Take Action Buttons using the shortcode:</p>
			<div class="code">&nbsp;&nbsp;&nbsp;[takeaction]</div>
			<p>Optionally, you can point to a specific cause and/or location using a shortcode like this:</p>
			<div class="code">&nbsp;&nbsp;&nbsp;[takeaction keywords="clean water" location="Chicago, IL"]</div>
			<form name="public-good-tab-admin" action="" method="post">
				<input type="hidden" name="submitted" value="Y"/>
				<p>Please enter your Public Good source identifier to enable TAB tracking.</p>
				<p>Source: <input type="text" length=20 name="source" value="<?php print esc_attr( $opt_val_source ); ?>"/></p>
				<p>If you'd like, you can add a default location where your readers tend to come from (e.g. "Chicago, IL"). </p>
				<p>Location: <input type="text" length=20 name="location" value="<?php print esc_attr( $opt_val_location ); ?>"/></p>
				<p>Default button size: <select name='size'>
						<option value='0' <?php selected( '0' === $opt_val_size ); ?>>Default</option>
						<option value='1' <?php selected( '1' === $opt_val_size ); ?>>Small Button</option>
					</select></p>
				<p class="submit"><input type="submit" name="Submit" class="button-primary" value="Save Changes"/></p>
			</form>
			<p>The source is the part of your Public Good url which follows "publicgood.com/org/". For example, if your Public Good profile is at https://publicgood.com/org/my-organization, use "my-organization".</p>
			<p>If you have questions or need a hand getting set up, don't hesitate to drop a line to Public Good Support at <a
						href="https://publicgood.zendesk.com/hc/en-us/requests/new">https://publicgood.zendesk.com/hc/en-us/requests/new</a>.</p>
		</div>

		<?php

	}
}

global $public_good_class;
$public_good_class = new Public_Good_Class;

?>
