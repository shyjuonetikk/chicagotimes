<?php
class CST_AMP_Ad_Injection_Sanitizer extends AMP_Base_Sanitizer {

	private static $script_slug = 'amp-ad';
	private static $script_src = 'https://cdn.ampproject.org/v0/amp-ad-0.1.js';

	public function get_scripts() {
		return array( self::$script_slug => self::$script_src );
	}
	public function sanitize() {
		$body = $this->get_body_node();

		// Build our amp-ad tag
		$ad_node_first = AMP_DOM_Utils::create_node( $this->dom, 'amp-ad', array(
			// Taken from example at https://github.com/ampproject/amphtml/blob/master/builtins/amp-ad.md
			'width' => 300,
			'height' => 250,
			'type' => 'doubleclick',
			'data-slot' => '/61924087/chicago.suntimes.com/chicago.suntimes.com.news/chicago.suntimes.com.news.index',
			'json' => '{"targeting":{"pos":"rr cube 1"}}',
		) );
		// Build our amp-ad tag
		$ad_node_second = AMP_DOM_Utils::create_node( $this->dom, 'amp-ad', array(
			// Taken from example at https://github.com/ampproject/amphtml/blob/master/builtins/amp-ad.md
			'width' => 300,
			'height' => 250,
			'type' => 'doubleclick',
			'data-slot' => '/61924087/chicago.suntimes.com/chicago.suntimes.com.news/chicago.suntimes.com.news.index',
			'json' => '{"targeting":{"pos":"rr cube 2"}}',
		) );

		// Add a placeholder to show while loading
		$fallback_node = AMP_DOM_Utils::create_node( $this->dom, 'amp-img', array(
			'placeholder' => '',
			'layout' => 'fill',
			'src' => 'https://placehold.it/300x250?text=loading...',
		) );
		$ad_node_first->appendChild( $fallback_node );
		$ad_node_second->appendChild( $fallback_node );

		// If we have a lot of paragraphs, insert before the 4th one.
		// Otherwise, add it to the end.
		$p_nodes = $body->getElementsByTagName( 'p' );
		if ( $p_nodes->length > 6 ) {
			$p_nodes->item( 4 )->parentNode->insertBefore( $ad_node_first, $p_nodes->item( 4 ) );
		} else {
			$body->appendChild( $ad_node_first );
		}
		if ( $p_nodes->length > 12 ) {
			$p_nodes->item( 10 )->parentNode->insertBefore( $ad_node_second, $p_nodes->item( 10 ) );
		} else {
			$body->appendChild( $ad_node_second );
		}
	}
}