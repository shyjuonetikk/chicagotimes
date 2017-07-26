<?php

class CST_Shortcode_Manager {

	private static $instance;

	private $shortcodes = array(
		'content',
		'scribblelive',
		'ndn-video',
		'ooyala',
		'cube',
		);

	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new CST_Shortcode_Manager;
			self::$instance->register_shortcodes();
		}
		return self::$instance;
	}

	/**
	 * Register all of the shortcodes
	 */
	private function register_shortcodes() {

		foreach ( $this->shortcodes as $shortcode ) {
			add_shortcode( 'cst-' . $shortcode, array( $this, str_replace( '-', '_', $shortcode ) ) );
		}

	}

	/**
	 * Our content should easily be embeddable
	 */
	public function content( $atts ) {

		if ( empty( $atts['id'] ) ) {
			return '';
		}

		$obj = \CST\Objects\Post::get_by_post_id( (int) $atts['id'] );
		if ( ! $obj || 'publish' !== $obj->get_status() ) {
			return '';
		}

		unset( $atts['id'] );
		$embed_args = $atts;
		return CST()->get_template_part( 'embed/' . $obj->get_type(), array( 'obj' => $obj, 'embed_args' => $embed_args ) );
	}

	/**
	 * Do the Scribblelive shortcode
	 */
	public function scribblelive( $atts ) {

		if ( empty( $atts['id'] ) ) {
			return '';
		}

		return '<div class="scrbbl-embed" data-src="' . esc_attr( '/event/' . (int) $atts['id'] ) . '"></div><script>(function(d, s, id) {var js,ijs=d.getElementsByTagName(s)[0];if(d.getElementById(id))return;js=d.createElement(s);js.id=id;js.src="//embed.scribblelive.com/widgets/embed.js";ijs.parentNode.insertBefore(js, ijs);}(document, "script", "scrbbl-js"));</script>';

	}

	/**
	 * Do the NDN video shortcode
	 */
	public function ndn_video( $atts ) {

		if ( empty( $atts['id'] ) ) {
			return '';
		}

		return '<div class="ndn_embed cst-responsive" data-config-widget-id="2" data-config-type="VideoPlayer/Single" data-config-tracking-group="58285" data-config-playlist-id="13434" data-config-video-id="' . (int) $atts['id'] . '" data-config-site-section="beaconnews_hom_non_fro"></div>';

	}

	/**
	 * Do the Ooyala video shortcode
	 */
	public function ooyala( $atts ) {

		if ( empty( $atts['id'] ) ) {
			return '';
		}

		return '<script type="text/javascript" src="//player.ooyala.com/v3/38f013a07e0458db1ee84d020e47cac"></script><div class="ooyalaplayer" id="ooyalaplayer-' . esc_attr( $atts['id'] ) . '"></div><script>OO.ready(function(){ OO.Player.create("ooyalaplayer-' . sanitize_text_field( $atts['id'] ) . '", "' . sanitize_text_field( $atts['id'] ) . '"); });</script><noscript><div>Please enable Javascript to watch this video</div></noscript>';

	}
	/**
	 * Do the Cube video shortcode
	 */
	public function cube( $atts ) {

		if ( empty( $atts['id'] ) ) {
			return '';
		}

		return '<iframe src="//thecube.com/embed/' . esc_attr( $atts['id'] )  . '" width="640" height="460" frameborder="0" scrolling="no" allowtransparency="true" allowfullscreen mozallowfullscreen webkitallowfullscreen></iframe><div><a style="font-size:11px" href="http://thecube.com">Share Events on The Cube</a></div>';

	}
}
