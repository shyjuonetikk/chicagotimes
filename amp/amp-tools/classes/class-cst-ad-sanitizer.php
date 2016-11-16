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
		// Paragraph block ad spacing
		$ad_paragraph_spacing = 5;
		$body = $this->get_body_node();
		$paragraph_nodes = $body->getElementsByTagName( 'p' );
		// Initial value includes all elements like galleries
		// But these should not be included when determining ad cube placement
		$number_of_paragraph_blocks = $paragraph_nodes->length;
		$cst_cube_ads = array();
		$classes_to_avoid_injecting_ads = array(
			'post-lead-media',
			'captiontext',
			'image-caption',
			'wp-caption',
			'wp-caption-text',
		);
		// Determine paragraph blocks
		foreach ( $paragraph_nodes as $content_item ) {
			if ( $content_item->hasAttributes() ) {
				$classy = $content_item->getAttribute( 'class' );
				if ( in_array( $classy, $classes_to_avoid_injecting_ads, true )  ) {
					$number_of_paragraph_blocks--;
					$classy = '';
				}
			}
		}
		$paras_to_inject_ad_into = absint( ( $number_of_paragraph_blocks / $ad_paragraph_spacing ) );

		$ad_node_teads = AMP_DOM_Utils::create_node( $this->dom, 'amp-ad', array(
			// Taken from example at https://github.com/ampproject/amphtml/blob/master/ads/teads.md
			'width'            => 300,
			'height'           => 1,
			'type'             => 'teads',
			'layout'           => 'responsive',
			'data-pid'         => '59505',
		) );
		for ( $index = 0; $index <= $paras_to_inject_ad_into; $index++ ) {
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

		// Add in Teads then multiple cubes based on paragraph count
		if ( $paras_to_inject_ad_into >= 1 ) {
			$paragraph_nodes->item( 2 )->parentNode->insertBefore( $ad_node_teads, $paragraph_nodes->item( 2 ) );
			// Now add in cubes spaced as best possible
			for ( $index = 0, $paras = $ad_paragraph_spacing; $index <= $paras_to_inject_ad_into; $index++, $paras += $ad_paragraph_spacing  ) {
				if ( $paras > $number_of_paragraph_blocks ) {
					break;
				}
				// Accommodate articles of $ad_paragraph_spacing length.
				if ( $paras === $paras_to_inject_ad_into ) {
					$current_paragraph = $paragraph_nodes->item( ( $paras - 1 ) );
				} else {
					$current_paragraph = $paragraph_nodes->item( $paras );
				}
				// Try to avoid putting ad in carousel caption and empty nodes/past end of node list
				if ( null !== $current_paragraph ) {
					if ( $current_paragraph->hasAttributes() ) {
						$classy = $current_paragraph->getAttribute( 'class' );
						if ( ! in_array( $classy, $classes_to_avoid_injecting_ads, true ) ) {
							$current_paragraph->parentNode->insertBefore( $cst_cube_ads[ $index ], $current_paragraph );
						}
					} else {
						$current_paragraph->parentNode->insertBefore( $cst_cube_ads[ $index ], $current_paragraph );
					}
				}
			}
		} else {
			$body->appendChild( $center_div_leaderboard );
		}

		$body->appendChild( $ad_node_taboola );

		$body->appendChild( AMP_DOM_Utils::create_node( $this->dom, 'amp-ad', array(
			'height'            => 200,
			'type'             => 'yieldmo',
			'data-ymid'        => '1555064078586984494',
		) ) );
	}
}