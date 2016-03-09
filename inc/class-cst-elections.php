<?php

/**
 * Shortcodes for Hosted AP Election scripts / codes
 */

class CST_Elections {

	private $site_id = 'ILCHSELN';
	private $election_date = '0315';
	private $election_state = 'IL';

	private $shortcodes = array(
		'delegate-tracker' => 'http://interactives.ap.org/2016/delegate-tracker/',
		'primary-election-results' => 'http://interactives.ap.org/2016/primary-election-results/?STATE=%1$s&date=%2$s&SITEID=%3$s',
		'presidential-caucus-table' => 'http://hosted.ap.org/dynamic/files/elections/2016/by_%1$s/IL_Page_%2$s.html?SITE=%3$s&SECTION=POLITICS',
	);

	public function __construct() {

		$this->setup_short_codes();

	}

	/**
	 * Create shortcode hooks to the similarly named functions
	 */
	public function setup_short_codes() {

		foreach ( $this->shortcodes as $shortcode => $url ) {
			add_shortcode( $shortcode, array( $this, str_replace( '-', '_', $shortcode ) ) );
		}

	}

	public function delegate_tracker( $atts ) {
		$attributes = shortcode_atts( array(
			'image' => 'true',
			'width' => '100%',
			'height' => '600px',
		), $atts );

		$html = sprintf( '<iframe src="%1$s%2$s" class="ap-embed" width="%3$s" height="%4$s" style="border: 1px solid #eee;">
 <!-- The following message will be displayed to users with unsupported browsers: -->
 Your browser does not support the <code>iframe</code> HTML tag.
 Try viewing this in a modern browser like Chrome, Safari, Firefox or Internet Explorer 9 or later.
</iframe>', esc_url( $this->shortcodes['delegate-tracker'] ), '?image=' . $attributes['image'], $attributes['width'], $attributes['height'] );
		echo $html;
	}

	public function primary_election_results( $atts ) {
		$attributes = shortcode_atts( array(
			'state' => $this->election_state,
			'date' => $this->election_date,
			'siteid' => $this->site_id,
			'width' => '100%',
			'height' => '600px',
		), $atts );

		$html = sprintf( '<iframe src="%1$s"
  class="ap-embed" width="%2$s" height="%3$s" style="border: 1px solid #eee;">
 <!-- The following message will be displayed to users with unsupported browsers: -->
Your browser does not support the <code>iframe</code> HTML tag.
Try viewing this in a modern browser like Chrome, Safari, Firefox or Internet Explorer 9 or later.
</iframe>', sprintf( $this->shortcodes['primary-election-results'], $attributes['state'], $attributes['date'], $attributes['siteid'] ),
			$attributes['width'],
		$attributes['height'] );

		echo $html;
	}

	public function presidential_caucus_table( $atts ) {
		$attributes = shortcode_atts( array(
			'state' => $this->election_state,
			'date' => $this->election_date,
			'siteid' => $this->site_id,
			'width' => '100%',
			'height' => '600px',
			'type' => 'state',
		), $atts );
		$html = sprintf( '<iframe src="%1$s"
  class="ap-embed" width="%2$s" height="%3$s" style="border: 1px solid #eee;">
 <!-- The following message will be displayed to users with unsupported browsers: -->
Your browser does not support the <code>iframe</code> HTML tag.
Try viewing this in a modern browser like Chrome, Safari, Firefox or Internet Explorer 9 or later.
</iframe>', sprintf( $this->shortcodes['presidential-caucus-table'], $attributes['type'], $attributes['date'], $attributes['siteid'] ),
			$attributes['width'],
		$attributes['height'] );

		echo $html;
	}
}

$cst_elections = new CST_Elections();
