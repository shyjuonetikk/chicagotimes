<?php

/**
 * Shortcodes for Hosted AP Election scripts / codes March 2016
 */

class CST_Elections {

	private $site_id = 'ILCHSELN';
	private $election_date = '0315';
	private $election_state = 'IL';

	private $shortcodes = array(
		'election-2016' => 'http://hosted.ap.org/dynamic/files/elections/2016/by_%1$s/IL_%2$s%4$s.html?SITE=%3$s&SECTION=POLITICS',
		'primary-election-results' => 'http://interactives.ap.org/2016/primary-election-results/?STATE=%1$s&date=%2$s&SITEID=%3$s',
		'vote-results-widget' => 'http://hosted.ap.org/elections/2016/by_race/IL_%1$s%2$s.js?SITE=%3$s&SECTION=POLITICS',
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

	public function election_2016( $atts ) {
		$available_types = array(
			'state',
			'county',
			'cd',
		);
		$attributes = shortcode_atts( array(
			'state' => $this->election_state,
			'date' => $this->election_date,
			'siteid' => $this->site_id,
			'width' => '100%',
			'height' => '400px',
			'type' => 'state',
			'page' => 'US_Senate',
			'counts' => false,
		), $atts );

		if ( in_array( $attributes['type'], $available_types, true ) ) {
			$attributes['vd'] = ( 'cd' === $attributes['type'] ) ? '_VD' : '';
			$attributes['vd'] = ( true === $attributes['counts'] ) ? '_D' : $attributes['vd'];

			$html             = sprintf( '<iframe src="%1$s"
  class="ap-embed" width="%2$s" height="%3$s" style="border: 1px solid #eee;">
 <!-- The following message will be displayed to users with unsupported browsers: -->
Your browser does not support the <code>iframe</code> HTML tag.
Try viewing this in a modern browser like Chrome, Safari, Firefox or Internet Explorer 9 or later.
</iframe>', sprintf( esc_url( $this->shortcodes['election-2016'] ), $attributes['type'], $attributes['page'] . '_' . $attributes['date'], $attributes['siteid'], $attributes['vd'] ),
				$attributes['width'],
			$attributes['height'] );

			return $html;
		} else {
			return '';
		}
	}

	/**
	 * @param $atts
	 *
	 * @return string
	 */
	public function vote_results_widget( $atts ) {
		$attributes = shortcode_atts( array(
			'counts' => false,
			'siteid' => $this->site_id,
			'racenumber' => 14999,
		), $atts );

		$attributes['racenumber'] = (int) $attributes['racenumber'];
		$attributes['counts'] = ( true === $attributes['counts'] ) ? '_D' : '';

		$remote_url = sprintf( esc_url( $this->shortcodes['vote-results-widget'] ), $attributes['racenumber'], $attributes['counts'], $attributes['siteid'] );
		$response = vip_safe_wp_remote_get( $remote_url );
		if ( ! is_wp_error( $response ) ) {
			$body = wp_remote_retrieve_body( $response );
			return '<script>' . $body . '</script>';
		} else {
			return '';
		}
	}

	/**
	 *
	 * Collect and return for display primary election results
	 * @param $atts
	 *
	 * @return string
	 */
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
</iframe>', sprintf( esc_url( $this->shortcodes['primary-election-results'] ), $attributes['state'], $attributes['date'], $attributes['siteid'] ),
			$attributes['width'],
		$attributes['height'] );

		return $html;
	}
}

$cst_elections = new CST_Elections();
