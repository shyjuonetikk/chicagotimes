<?php
class CST_AMP_Ad_Injection_Sanitizer extends AMP_Base_Sanitizer {

	private static $script_slug = 'amp-ad';
	private static $script_src = 'https://cdn.ampproject.org/v0/amp-ad-0.1.js';
	public $dfp_handler;

	public function __construct( $dom, $args = [] ) {
		parent::__construct( $dom, $args = [] );
		$this->dfp_handler = new CST_DFP_Handler;
	}

	public function get_scripts() {
		return [
			self::$script_slug => self::$script_src,
			'amp-sticky-ad' => 'https://cdn.ampproject.org/v0/amp-sticky-ad-1.0.js',
		];
	}
	public function sanitize() {
		// Paragraph block ad spacing
		$ad_paragraph_spacing = 5;
		$body = $this->get_body_node();
		$paragraph_nodes = $body->getElementsByTagName( 'p' );
		// Initial value includes all elements like galleries
		// But these should not be included when determining ad cube placement
		$number_of_paragraph_blocks = $paragraph_nodes->length;
		$cst_cube_ads = [];
		$classes_to_avoid_injecting_ads = [
			'post-lead-media',
			'captiontext',
			'caption',
			'image-caption',
			'wp-caption',
			'wp-caption-text',
		];
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

		$ad_node_teads = AMP_DOM_Utils::create_node( $this->dom, 'amp-ad', [
			// Taken from example at https://github.com/ampproject/amphtml/blob/master/ads/teads.md
			'width'            => 300,
			'height'           => 1,
			'type'             => 'teads',
			'layout'           => 'responsive',
			'data-pid'         => '59505',
		] );
		for ( $index = 0; $index <= $paras_to_inject_ad_into; $index++ ) {
			$center_div = AMP_DOM_Utils::create_node( $this->dom, 'div', [ 'class' => 'ad-center' ] );
			$center_div->appendChild( AMP_DOM_Utils::create_node( $this->dom, 'amp-ad', [
				// Taken from example at https://github.com/ampproject/amphtml/blob/master/builtins/amp-ad.md
				'width'     => 300,
				'height'    => 250,
				'type'      => 'doubleclick',
				'data-slot' => $this->dfp_handler->ad_header_settings( true ),
				'json'      => '{"targeting":{"pos":"AMP Cube"}}',
			] ) );
			$cst_cube_ads[ $index ] = $center_div;
		}
		$ad_node_nativo = AMP_DOM_Utils::create_node( $this->dom, 'amp-ad', [
			// Taken from example at https://github.com/ampproject/amphtml/blob/master/ads/teads.md
			'width'            => 300,
			'height'           => 1,
			'type'             => 'nativo',
			'layout'           => 'responsive',
		] );
		$center_div_leaderboard = AMP_DOM_Utils::create_node( $this->dom, 'div', array( 'class' => 'ad-center' ) );
		$center_div_leaderboard->appendChild( AMP_DOM_Utils::create_node( $this->dom, 'amp-ad', [
			// Taken from example at https://github.com/ampproject/amphtml/blob/master/builtins/amp-ad.md
			'width'     => 320,
			'height'    => 50,
			'type'      => 'doubleclick',
			'data-slot' => $this->dfp_handler->ad_header_settings( true ),
			'json'      => '{"targeting":{"pos":"mobile leaderboard"}}',
		] ) );
		$ad_node_cube_last = AMP_DOM_Utils::create_node( $this->dom, 'div', [ 'class' => 'ad-center' ] );
		$ad_node_cube_last->appendChild( AMP_DOM_Utils::create_node( $this->dom, 'amp-ad', [
			// Taken from example at https://github.com/ampproject/amphtml/blob/master/builtins/amp-ad.md
			'width'     => 300,
			'height'    => 250,
			'type'      => 'doubleclick',
			'data-slot' => $this->dfp_handler->ad_header_settings( true ),
			'json'      => '{"targeting":{"pos":"AMP Cube"}}',
		] ) );
		$ad_node_taboola = AMP_DOM_Utils::create_node( $this->dom, 'amp-embed', [
			// Updated with amp codw from Taboola
			'width'            => 100,
			'height'           => 100,
			'type'             => 'taboola',
			'layout'           => 'responsive',
			'heights'          => '(min-width:524px) 621%, (min-width:401px) 659%, 711%',
			'data-publisher'   => 'chicagosuntimes-network',
			'data-mode'        => 'thumbnails-a-amp',
			'data-placement'   => 'mobile below article thumbnails amp',
			'data-target_type' => 'mix',
			'data-article'     => 'auto',
		] );

		// Add in Teads then multiple cubes based on paragraph count
		if ( $paras_to_inject_ad_into >= 1 ) {
			$paragraph_nodes->item( 2 )->parentNode->insertBefore( $ad_node_teads, $paragraph_nodes->item( 2 ) );
			// Now add in the Nativo unit
			$paragraph_nodes->item( 6 )->parentNode->insertBefore( $ad_node_nativo, $paragraph_nodes->item( 6 ) );
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

		$body->appendChild( AMP_DOM_Utils::create_node( $this->dom, 'amp-ad', [
			'height'            => 200,
			'type'             => 'yieldmo',
			'data-ymid'        => '1555064078586984494',
		] ) );
		$amp_sticky = AMP_DOM_Utils::create_node( $this->dom, 'amp-sticky-ad', [ 'layout' => 'nodisplay' ] );
		$amp_sticky->appendChild( AMP_DOM_Utils::create_node( $this->dom, 'amp-ad', [
			'width'     => 320,
			'height'    => 50,
			'type'      => 'doubleclick',
			'data-slot' => $this->dfp_handler->ad_header_settings( true ),
			'json'      => '{"targeting":{"pos":"cst-adhesion"}}',
		] ) );
		$body->appendChild( $amp_sticky );
	}
}