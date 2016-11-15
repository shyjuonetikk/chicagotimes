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
		$ad_paragraph_spacing = 5;
		$body = $this->get_body_node();
		$paragraph_nodes = $body->getElementsByTagName( 'p' );
		$paras_to_inject_ad_into = absint( ( $paragraph_nodes->length / $ad_paragraph_spacing ) ) - 1; // less one to accommodate first ad as mobile leaderboard
		$cst_cube_ads = array();

		$ad_node_teads = AMP_DOM_Utils::create_node( $this->dom, 'amp-ad', array(
			// Taken from example at https://github.com/ampproject/amphtml/blob/master/ads/teads.md
			'width'            => 300,
			'height'           => 1,
			'type'             => 'teads',
			'layout'           => 'responsive',
			'data-pid'         => '58294',
		) );
		$cst_cube_ads[0] = $ad_node_teads;
		for ( $index = 1; $index <= $paras_to_inject_ad_into; $index++ ) {
			$center_div = AMP_DOM_Utils::create_node( $this->dom, 'div', array( 'class' => 'ad-center' ) );
			$center_div->appendChild( AMP_DOM_Utils::create_node( $this->dom, 'amp-ad', array(
				// Taken from example at https://github.com/ampproject/amphtml/blob/master/builtins/amp-ad.md
				'width'     => 300,
				'height'    => 250,
				'type'      => 'doubleclick',
				'data-slot' => $this->dfp_handler->ad_header_settings( true ),
				'json'      => '{"targeting":{"pos":"rr cube 1"}}',
			) ) );
			$cst_cube_ads[ $index ] = $center_div;
		}
		$center_div_leaderboard = AMP_DOM_Utils::create_node( $this->dom, 'div', array( 'class' => 'ad-center' ) );
		$center_div_leaderboard->appendChild( AMP_DOM_Utils::create_node( $this->dom, 'amp-ad', array(
			// Taken from example at https://github.com/ampproject/amphtml/blob/master/builtins/amp-ad.md
			'width'     => 320,
			'height'    => 50,
			'type'      => 'doubleclick',
			'data-slot' => $this->dfp_handler->ad_header_settings( true ),
			'json'      => '{"targeting":{"pos":"mobile leaderboard"}}',
		) ) );
		$ad_node_cube_last = AMP_DOM_Utils::create_node( $this->dom, 'div', array( 'class' => 'ad-center' ) );
		$ad_node_cube_last->appendChild( AMP_DOM_Utils::create_node( $this->dom, 'amp-ad', array(
			// Taken from example at https://github.com/ampproject/amphtml/blob/master/builtins/amp-ad.md
			'width'     => 300,
			'height'    => 250,
			'type'      => 'doubleclick',
			'data-slot' => $this->dfp_handler->ad_header_settings( true ),
			'json'      => '{"targeting":{"pos":"rr cube 1"}}',
		) ) );
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

		// One mobile leaderboard then multiple cubes based on paragraph count
		if ( $paragraph_nodes->length > 1 ) {
			$paragraph_nodes->item( 2 )->parentNode->insertBefore( $center_div_leaderboard, $paragraph_nodes->item( 2 ) );
			for ( $index = 0, $paras = $ad_paragraph_spacing; $index <= $paras_to_inject_ad_into; $index++  ) {
				$paragraph_nodes->item( $paras )->parentNode->insertBefore( $cst_cube_ads[ $index ], $paragraph_nodes->item( $paras ) );
				$paras += $ad_paragraph_spacing;
				if ( $paras >= $paragraph_nodes->length ) {
					break;
				}
			}
		} else {
			$body->appendChild( $center_div_leaderboard );
		}

		$body->appendChild( $ad_node_taboola );

		// Only add a lower / last ad cube if the article is less than 9 paragraphs.
		if ( $paragraph_nodes->length < 9 ) {
			$body->appendChild( $ad_node_cube_last );
		}
	}
}