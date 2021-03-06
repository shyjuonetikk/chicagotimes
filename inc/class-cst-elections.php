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
		'election-2016-state' => 'http://hosted.ap.org/dynamic/files/elections/2016/general/by_state/state_sen_house/IL.html?SITE=ILCHSELN&SECTION=POLITICS',
		'election-2016-county' => 'http://hosted.ap.org/dynamic/files/elections/2016/general/by_county/state_sen_house/IL.html?SITE=ILCHSELN&SECTION=POLITICS',
		'election-2016-nov' => 'http://interactives.ap.org/2016/%1$s/?SITE=ILCHSELN&OFFICE=%2$s&DEFAULTGEO=TRUE',
		'election-2016-local-races' => 'http://hosted.ap.org/dynamic/files/elections/2016/general/by_county/local/IL.html?SITE=ILCHSELN&SECTION=POLITICS',
		'election-2016-fed-senate' => 'http://hosted.ap.org/dynamic/files/elections/2016/general/by_county/us_senate/IL.html?SITE=ILCHSELN&SECTION=POLITICS',
		'election-2016-fed-house' => 'http://hosted.ap.org/dynamic/files/elections/2016/general/by_county/us_house/IL.html?SITE=ILCHSELN&SECTION=POLITICS',
		'election-2016-us-house-results' => 'http://hosted.ap.org/dynamic/files/elections/2016/general/by_state/us_house/IL.html?SITE=ILCHSELN&SECTION=POLITICS',
		'election-2016-us-senate-results' => 'http://hosted.ap.org/dynamic/files/elections/2016/general/by_state/us_senate/IL.html?SITE=ILCHSELN&SECTION=POLITICS',
		'election-2016-race' => 'http://hosted.ap.org/elections/2016/general/by_race/IL_%1$s.js?SITE=ILCHSELN&SECTION=POLITICS',
		'primary-election-results' => 'http://interactives.ap.org/2016/primary-election-results/?STATE=%1$s&date=%2$s&SITEID=%3$s',
		'election-2016-navigation' => 'this-entry-left-intentionally-blank',
	);

	private static $instance;

	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new CST_Elections();
		}
		return self::$instance;
	}
	public function __construct() {


		$this->setup_short_codes();

		add_filter( 'nav_menu_css_class', [ $this, 'cst_election_add_button_class' ], 10, 3 );
	}

	/**
	 * @param $classes
	 * @param $item
	 * @param $args
	 *
	 * @return array
	 *
	 * Add button class to single li's in election navigation
	 */
	function cst_election_add_button_class( $classes, $item, $args ) {
		if ( 'election-page' === $args->theme_location ) {
			$classes[] = 'button';
		}
		return $classes;

	}


	/**
	 * Create shortcode hooks to the similarly named functions
	 */
	public function setup_short_codes() {

		foreach ( $this->shortcodes as $shortcode => $url ) {
			add_shortcode( $shortcode, array( $this, str_replace( '-', '_', $shortcode ) ) );
		}

	}
	/**
	 * @param $atts
	 * @param $shortcode_content
	 * @param $shortcode_name
	 *
	 * @return string
	 */
	public function election_2016_navigation( $atts, $shortcode_content, $shortcode_name ) {
		if ( has_nav_menu( 'election-page' ) ) {
			$html = wp_nav_menu( array(
				'theme_location' => 'election-page',
				'echo' => false,
				'container' => 'nav',
				'container_class' => 'top-bar election',
				'items_wrap' => '<ul id="%1$s" class="'. esc_attr( $shortcode_name ) . '">%3$s</ul>',
			) );
			return $html;
		}
		return '';
	}

	/**
	 * @param $atts
	 * @param $shortcode_content
	 * @param $shortcode_name
	 *
	 * @return string
	 */
	public function election_2016( $atts, $shortcode_content, $shortcode_name ) {
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
			'height' => '250px',
			'type' => 'state',
			'page' => 'US_Senate',
			'counts' => false,
		), $atts );

		if ( in_array( $attributes['type'], $available_types, true ) ) {
			$attributes['vd'] = ( 'cd' === $attributes['type'] ) ? '_VD' : '';
			$attributes['vd'] = ( true === $attributes['counts'] ) ? '_D' : $attributes['vd'];

			$html = sprintf( '<iframe src="%1$s"
  class="ap-embed" width="%2$s" height="%3$s" style="border: 1px solid #eee;">
 <!-- The following message will be displayed to users with unsupported browsers: -->
Your browser does not support the <code>iframe</code> HTML tag.
Try viewing this in a modern browser like Chrome, Safari, Firefox or Internet Explorer 9 or later.
</iframe>', sprintf( esc_url( $this->shortcodes[ $shortcode_name ] ), esc_attr( $attributes['type'] ), esc_attr( $attributes['page'] ) . '_' . esc_attr( $attributes['date'] ), esc_attr( $attributes['siteid'] ), esc_attr( $attributes['vd'] ) ),
				esc_attr( $attributes['width'] ),
			esc_attr( $attributes['height'] ) );

			return $html;
		} else {
			return '';
		}
	}

	/**
	 * @param $atts
	 * @param $shortcode_content
	 * @param $shortcode_name
	 *
	 * @return string
	 */
	public function election_2016_nov( $atts, $shortcode_content, $shortcode_name ) {

		$attributes = shortcode_atts( array(
			'width' => '100%',
			'height' => '200px',
			'office' => 'PRESIDENT',
			'page' => 'Balance_of_power',
			'counts' => false,
		), $atts );
		$html = sprintf( '<iframe src="%1$s"
class="ap-embed cube" width="%2$s" height="%3$s" style="border: 1px solid #eee;">
<!-- The following message will be displayed to users with unsupported browsers: -->
Your browser does not support the <code>iframe</code> HTML tag.
Try viewing this in a modern browser like Chrome, Safari, Firefox or Internet Explorer 9 or later.
</iframe>', sprintf( esc_url( $this->shortcodes[ $shortcode_name ] ), esc_attr( $attributes['page'] ), esc_attr( $attributes['office'] ) ),
			esc_attr( $attributes['width'] ),
			esc_attr( $attributes['height'] ) );

		return $html;
	}

	/**
	 * @param $atts
	 * @param $shortcode_content
	 * @param $shortcode_name
	 *
	 * @return string
	 */
	public function election_2016_race( $atts, $shortcode_content, $shortcode_name ) {
		$attributes = shortcode_atts( array(
			'width' => '100%',
			'height' => '250px',
			'counts' => false,
			'race_num' => '16413',
			'race_title' => 'US Senate General',
		), $atts );
		$html = sprintf( '<script language="JavaScript" src="%1$s"></script>%2$s',
			sprintf( esc_url( $this->shortcodes[ $shortcode_name ] ), esc_attr( $attributes['race_num'] ) ),
			is_front_page() ? '' : wp_kses_post( '<a class="button" href="#election-top">Back to top</a>' )
		);

		return $html;
	}

	/**
	 * @param $atts
	 * @param $shortcode_content
	 * @param $shortcode_name
	 *
	 * @return string
	 */
	public function election_2016_state( $atts, $shortcode_content, $shortcode_name ) {
		$attributes = shortcode_atts( array(
			'width' => '100%',
			'height' => '250px',

		), $atts );
		$html = sprintf( '<a id="%4$s"></a><iframe src="%1$s"
  class="ap-embed" width="%2$s" height="%3$s" style="border: 1px solid #eee;">
 <!-- The following message will be displayed to users with unsupported browsers: -->
Your browser does not support the <code>iframe</code> HTML tag.
Try viewing this in a modern browser like Chrome, Safari, Firefox or Internet Explorer 9 or later.
</iframe>%5$s',
			esc_url( $this->shortcodes[ $shortcode_name ] ),
			esc_attr( $attributes['width'] ),
			esc_attr( $attributes['height'] ),
			esc_attr( $shortcode_name ),
			is_front_page() ? '' : wp_kses_post( '<a class="button" href="#election-top">Back to top</a>' )
		);
		return $html;
	}

	/**
	 * @param $atts
	 * @param $shortcode_content
	 * @param $shortcode_name
	 *
	 * @return string
	 */
	public function election_2016_fed_senate( $atts, $shortcode_content, $shortcode_name ) {
		$attributes = shortcode_atts( array(
			'width' => '100%',
			'height' => '250px',

		), $atts );
		$html = sprintf( '<a id="%4$s"></a><iframe src="%1$s"
  class="ap-embed" width="%2$s" height="%3$s" style="border: 1px solid #eee;">
 <!-- The following message will be displayed to users with unsupported browsers: -->
Your browser does not support the <code>iframe</code> HTML tag.
Try viewing this in a modern browser like Chrome, Safari, Firefox or Internet Explorer 9 or later.
</iframe>%5$s',
			esc_url( $this->shortcodes[ $shortcode_name ] ),
			esc_attr( $attributes['width'] ),
			esc_attr( $attributes['height'] ),
			esc_attr( $shortcode_name ),
			is_front_page() ? '' : wp_kses_post( '<a class="button" href="#election-top">Back to top</a>' )
		);
		return $html;
	}

	/**
	 * @param $atts
	 * @param $shortcode_content
	 * @param $shortcode_name
	 *
	 * @return string
	 */
	public function election_2016_fed_house( $atts, $shortcode_content, $shortcode_name ) {
		$attributes = shortcode_atts( array(
			'width' => '100%',
			'height' => '250px',

		), $atts );
		$html = sprintf( '<a id="%4$s"></a><iframe src="%1$s"
  class="ap-embed" width="%2$s" height="%3$s" style="border: 1px solid #eee;">
 <!-- The following message will be displayed to users with unsupported browsers: -->
Your browser does not support the <code>iframe</code> HTML tag.
Try viewing this in a modern browser like Chrome, Safari, Firefox or Internet Explorer 9 or later.
</iframe>%5$s',
			esc_url( $this->shortcodes[ $shortcode_name ] ),
			esc_attr( $attributes['width'] ),
			esc_attr( $attributes['height'] ),
			esc_attr( $shortcode_name ),
			is_front_page() ? '' : wp_kses_post( '<a class="button" href="#election-top">Back to top</a>' )
		);
		return $html;
	}

	/**
	 * @param $atts
	 * @param $shortcode_content
	 * @param $shortcode_name
	 *
	 * @return string
	 */
	public function election_2016_us_house_results( $atts, $shortcode_content, $shortcode_name ) {
		$attributes = shortcode_atts( array(
			'width' => '100%',
			'height' => '250px',

		), $atts );
		$html = sprintf( '<a id="%4$s"></a><iframe src="%1$s"
  class="ap-embed" width="%2$s" height="%3$s" style="border: 1px solid #eee;">
 <!-- The following message will be displayed to users with unsupported browsers: -->
Your browser does not support the <code>iframe</code> HTML tag.
Try viewing this in a modern browser like Chrome, Safari, Firefox or Internet Explorer 9 or later.
</iframe>%5$s',
			esc_url( $this->shortcodes[ $shortcode_name ] ),
			esc_attr( $attributes['width'] ),
			esc_attr( $attributes['height'] ),
			esc_attr( $shortcode_name ),
			is_front_page() ? '' : wp_kses_post( '<a class="button" href="#election-top">Back to top</a>' )
		);
		return $html;
	}

	/**
	 * @param $atts
	 * @param $shortcode_content
	 * @param $shortcode_name
	 *
	 * @return string
	 */
	public function election_2016_local_races( $atts, $shortcode_content, $shortcode_name ) {
		$attributes = shortcode_atts( array(
			'width' => '100%',
			'height' => '250px',

		), $atts );
		$html = sprintf( '<a id="%4$s"></a><iframe src="%1$s"
  class="ap-embed" width="%2$s" height="%3$s" style="border: 1px solid #eee;">
 <!-- The following message will be displayed to users with unsupported browsers: -->
Your browser does not support the <code>iframe</code> HTML tag.
Try viewing this in a modern browser like Chrome, Safari, Firefox or Internet Explorer 9 or later.
</iframe>%5$s',
			esc_url( $this->shortcodes[ $shortcode_name ] ),
			esc_attr( $attributes['width'] ),
			esc_attr( $attributes['height'] ),
			esc_attr( $shortcode_name ),
			is_front_page() ? '' : wp_kses_post( '<a class="button" href="#election-top">Back to top</a>' )
		);
		return $html;
	}

	/**
	 * @param $atts
	 * @param $shortcode_content
	 * @param $shortcode_name
	 *
	 * @return string
	 */
	public function election_2016_us_senate_results( $atts, $shortcode_content, $shortcode_name ) {
		$attributes = shortcode_atts( array(
			'width' => '100%',
			'height' => '230px',

		), $atts );
		$html = sprintf( '<a id="%4$s"></a><iframe src="%1$s"
 width="%2$s" height="%3$s" style="border: 1px solid #eee;">
 <!-- The following message will be displayed to users with unsupported browsers: -->
Your browser does not support the <code>iframe</code> HTML tag.
Try viewing this in a modern browser like Chrome, Safari, Firefox or Internet Explorer 9 or later.
</iframe>%5$s',
			esc_url( $this->shortcodes[ $shortcode_name ] ),
			esc_attr( $attributes['width'] ),
			esc_attr( $attributes['height'] ),
			esc_attr( $shortcode_name ),
			is_front_page() ? '' : wp_kses_post( '<a class="button" href="#election-top">Back to top</a>' )
		);
		return $html;
	}

	/**
	 * @param $atts
	 * @param $shortcode_content
	 * @param $shortcode_name
	 *
	 * @return string
	 */
	public function election_2016_county( $atts, $shortcode_content, $shortcode_name ) {
		$attributes = shortcode_atts( array(
			'width' => '100%',
			'height' => '250px',

		), $atts );
		$html = sprintf( '<a id="%4$s"></a><iframe src="%1$s"
  class="ap-embed" width="%2$s" height="%3$s" style="border: 1px solid #eee;">
 <!-- The following message will be displayed to users with unsupported browsers: -->
Your browser does not support the <code>iframe</code> HTML tag.
Try viewing this in a modern browser like Chrome, Safari, Firefox or Internet Explorer 9 or later.
</iframe>%5$s',
			esc_url( $this->shortcodes[ $shortcode_name ] ),
			esc_attr( $attributes['width'] ),
			esc_attr( $attributes['height'] ),
			esc_attr( $shortcode_name ),
			is_front_page() ? '' : wp_kses_post( '<a class="button" href="#election-top">Back to top</a>' )
		);

		return $html;
	}

	/**
	 *
	 * Collect and return for display primary election results
	 * @param $atts
	 * @param $shortcode_content
	 * @param $shortcode_name
	 * @return string
	 */
	public function primary_election_results( $atts, $shortcode_content, $shortcode_name ) {
		$attributes = shortcode_atts( array(
			'state' => $this->election_state,
			'date' => $this->election_date,
			'siteid' => $this->site_id,
			'width' => '100%',
			'height' => '600px',
		), $atts );

		$html = sprintf( '<a id="%4$s"></a><iframe src="%1$s"
  class="ap-embed" width="%2$s" height="%3$s" style="border: 1px solid #eee;">
 <!-- The following message will be displayed to users with unsupported browsers: -->
Your browser does not support the <code>iframe</code> HTML tag.
Try viewing this in a modern browser like Chrome, Safari, Firefox or Internet Explorer 9 or later.
</iframe>%4$s', sprintf( esc_url( $this->shortcodes[ $shortcode_name ] ), esc_attr( $attributes['state'] ), esc_attr( $attributes['date'] ), esc_attr( $attributes['siteid'] ) ),
			esc_attr( $attributes['width'] ),
			esc_attr( $attributes['height'] ),
			esc_attr( $shortcode_name ),
			is_front_page() ? '' : wp_kses_post( '<a class="button" href="#election-top">Back to top</a>' )
		);

		return $html;
	}

	/**
	 * Homepage section
	 */
	public function election_shortcode() {
		if ( is_active_sidebar( 'election_2016_headlines' ) ) {
		?>
		<div class="row">
			<div class="large-12 elections-container">
				<div class="elections-2016">
					<?php
						dynamic_sidebar( 'election_2016_headlines' );
					?>
				</div>
			</div>
		</div>
		<?php
		}
	}
}

$cst_elections = new CST_Elections();
