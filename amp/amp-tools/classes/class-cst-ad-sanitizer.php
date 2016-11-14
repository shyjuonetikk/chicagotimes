<?php
class CST_AMP_Ad_Injection_Sanitizer extends AMP_Base_Sanitizer {

	private static $script_slug = 'amp-ad';
	private static $script_src = 'https://cdn.ampproject.org/v0/amp-ad-0.1.js';
	public $dfp_handler;

	public function __construct( $dom, $args = array() ) {
		parent::__construct( $dom, $args = array() );
		$this->dfp_handler = new CST_DFP_Handler;
	}

	public function get_scripts() {
		return array( self::$script_slug => self::$script_src );
	}
	public function sanitize() {
		$body = $this->get_body_node();

		$ad_node_mobile_leaderboard = AMP_DOM_Utils::create_node( $this->dom, 'amp-ad', array(
			// Taken from example at https://github.com/ampproject/amphtml/blob/master/builtins/amp-ad.md
			'width'     => 320,
			'height'    => 50,
			'type'      => 'doubleclick',
			'data-slot' => $this->dfp_handler->ad_header_settings( true ),
			'json'      => '{"targeting":{"pos":"mobile leaderboard"}}',
		) );
		$ad_node_cube = AMP_DOM_Utils::create_node( $this->dom, 'amp-ad', array(
			// Taken from example at https://github.com/ampproject/amphtml/blob/master/builtins/amp-ad.md
			'width'     => 300,
			'height'    => 250,
			'type'      => 'doubleclick',
			'data-slot' => $this->dfp_handler->ad_header_settings( true ),
			'json'      => '{"targeting":{"pos":"rr cube 1"}}',
		) );
		$ad_node_teads = AMP_DOM_Utils::create_node( $this->dom, 'amp-ad', array(
			// Taken from example at https://github.com/ampproject/amphtml/blob/master/ads/teads.md
			'width'            => 300,
			'height'           => 1,
			'type'             => 'teads',
			'layout'           => 'responsive',
			'data-pid'         => '58294',
		) );
		$ad_node_taboola = AMP_DOM_Utils::create_node( $this->dom, 'amp-embed', array(
			// Taken from example at https://github.com/ampproject/amphtml/blob/master/ads/taboola.md
			'width'            => 100,
			'height'           => 283,
			'type'             => 'taboola',
			'layout'           => 'responsive',
			'heights'          => '(min-width:1907px) 39%, (min-width:1200px) 46%, (min-width:780px) 64%, (min-width:480px) 98%, (min-width:460px) 167%, 196%',
			'data-mode'        => 'thumbnails-c',
			'data-placement'   => 'Below Article Thumbnails',
			'data-target_type' => 'mix',
			'data-article'     => 'auto',
			'data-publisher'   => 'chicagosuntimes-chicagosuntimes',
			'data-url'         => '',
		) );

		// Add a placeholder to show while loading
		$fallback_node = AMP_DOM_Utils::create_node( $this->dom, 'amp-img', array(
			'placeholder' => '',
			'layout' => 'fill',
			'src' => 'https://placehold.it/300x250?text=loading...',
		) );
		$ad_node_mobile_leaderboard->appendChild( AMP_DOM_Utils::create_node( $this->dom, 'amp-img', array(
			'placeholder' => '',
			'layout' => 'fill',
			'src' => 'https://placehold.it/320x50?text=Ad loading...',
		) ) );
		$ad_node_cube->appendChild( $fallback_node );

		// If we have a lot of paragraphs, insert before the 4th one.
		// Otherwise, add it to the end.
		$p_nodes = $body->getElementsByTagName( 'p' );

		// One leaderboard then multiple cubes based on paragraph count
		if ( $p_nodes->length > 1 ) {
			$p_nodes->item( 2 )->parentNode->insertBefore( $ad_node_mobile_leaderboard, $p_nodes->item( 2 ) );
			for ( $every_three_paragraphs = 4; $every_three_paragraphs < $p_nodes->length; $every_three_paragraphs += 2  ) {
				$p_nodes->item( $every_three_paragraphs )->parentNode->insertBefore( $ad_node_cube, $p_nodes->item( $every_three_paragraphs ) );
			}
			// Inject Teads.
			if ( $p_nodes->length > 5 ) {
				$middle_paragraph = $p_nodes->length / 2;
				$p_nodes->item( $middle_paragraph )->parentNode->insertBefore( $ad_node_teads, $p_nodes->item( $middle_paragraph ) );
			}
		} else {
			$body->appendChild( $ad_node_mobile_leaderboard );
		}

		$body->appendChild( $ad_node_taboola );
		$body->appendChild( $ad_node_cube );
	}
}