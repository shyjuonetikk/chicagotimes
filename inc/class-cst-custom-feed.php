<?php

class CST_Feeds {

	private static $instance;
	private $syndicated_feeds = array(
		'headlinenews',
	);

	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new \CST_Feeds();
		}
		return self::$instance;
	}
	public function __construct() {

		foreach ( $this->syndicated_feeds as $syndicated_feed ) {
			add_feed( $syndicated_feed, [ $this, 'process_syndicated_news_feed' ] );
		}
		add_action( 'post_rss', [ $this, 'track_feed_referer' ] );
	}

	/**
	 * @return bool
	 *
	 * Is this feed delivering content for a publishing partner who cannot be
	 * given syndicated content?
	 */
	public function is_publishing_partner() {
		$syndicated = false;
		foreach ( $this->syndicated_feeds as $syndicated_feed ) {
			if ( is_feed( $syndicated_feed ) ) {
				$syndicated = true;
			}
		}
		return $syndicated;

	}

	/**
	 * Include feed template for a custom feed.
	 */
	public function process_syndicated_news_feed() {
		if ( file_exists( get_template_directory() . '/feeds/feed-rss2.php' ) ) {
			require( get_template_directory() . '/feeds/feed-rss2.php' );
		}
	}

	/**
	 * Determine if content destined for the feed is syndicated or not
	 * @param $obj
	 * @return bool
	 */
	public function is_syndicated_content( $obj ) {

		$syndication_partners = array(
			'Associated Press',
			'USA Today',
			'USA TODAY',
			'USA TODAY Network',
			'Georgia Nicols',
			'| Associated Press',
			'| AP Auto Writer',
			'| AP White House Correspondent',
			'S. E. Cupp',
			'Roger Simon',
			'Anthony L. Komaroff, M.D.',
			'Robert Ashley, M.D.',
			'Eve Glazier, M.D., and Elizabeth Ko, M.D.',
			'Eve Glazier, M.D.',
			'Elizabeth Ko, M.D.',
			'Kaiser Health News',
			'Connie Schultz',
			'John Stossel',
			'Jacob Sullum',
			'Linda Chavez',
			'Jesse Jackson',
			'Mona Charon',
			'Roger Simon',
			'Gene Lyons',
		);
		if ( $byline = $obj->get_byline() ) {
			if ( array_key_exists( $byline, $syndication_partners ) ) {
				return true;
			} else {
				foreach ( $syndication_partners as $syndication_partner ) {
					if ( stristr( $byline, $syndication_partner ) ) {
						return true;
					}
				}
			}
		}
		$authors = get_coauthors();
		foreach ( $authors as $author ) {
			if ( array_key_exists( $author->display_name, $syndication_partners ) ) {
				return true;
			} else {
				foreach ( $syndication_partners as $syndication_partner ) {
					if ( stristr( $author->display_name, $syndication_partner ) ) {
						return true;
					}
				}
			}
		}
		return false;
	}

	/**
	 * @param $obj
	 *
	 * @return bool
	 *
	 * Determine if we can offer this piece of content in
	 * response to a feed request
	 */
	public function publish_this_content_item( $obj ) {
		$publish_me = false;
		if ( $this->is_publishing_partner() ) {
			if ( ! $this->is_syndicated_content( $obj ) ) {
				$publish_me = true;
			}
		} else {
			$publish_me = true;
		}
		return $publish_me;
	}

	public function track_feed_referer() {

		$requester = array();
		$requester['user_ip']    = esc_attr( $_SERVER['REMOTE_ADDR'] );
		$requester['user_agent'] = esc_attr( $_SERVER['HTTP_USER_AGENT'] );
		$requester['referrer']   = esc_url( $_SERVER['HTTP_REFERER'] );
		$requester['https']   = esc_url( $_SERVER['HTTPS'] );
		$requester['host']   = esc_url( $_SERVER['HTTP_HOST'] );
		$requester['request_uri']   = esc_url( $_SERVER['REQUEST_URI'] );
		$var_utmac = defined( 'CST_GOOGLE_ANALYTICS' ) || 'UA-52083976-1';
		$var_utmhn = $requester['host'] . $requester['request_uri'];
		$var_utmn = rand( 1000000000, 9999999999 );//random request number
		$var_cookie = rand( 10000000, 99999999 );//random cookie number
		$var_random = rand( 1000000000, 2147483647 ); //number under 2147483647
		$var_today = time(); //today
		$var_referer = $_SERVER['HTTP_REFERER']; //referer url
		$var_uservar = '-rsswho';
		$ga_remote_url = 'http://www.google-analytics.com/__utm.gif?utmwv=1&amp;utmn=' . $var_utmn . '&amp;utmsr=-&amp;utmsc=-&amp;utmul=-&amp;utmje=0&amp;utmfl=-&amp;utmdt=-&amp;utmhn=' . $var_utmhn . '&amp;utmr=' . $var_referer . '&amp;utmp=' . $var_utmp . '&amp;utmac=' . $var_utmac . '&amp;utmcc=__utma%3D' . $var_cookie . '.' . $var_random . '.' . $var_today . '.' . $var_today . '.' . $var_today . '.2%3B%2B__utmb%3D' . $var_cookie . '%3B%2B__utmc%3D' . $var_cookie . '%3B%2B__utmz%3D' . $var_cookie . '.' . $var_today . '.2.2.utmccn%3D(direct)%7Cutmcsr%3D(direct)%7Cutmcmd%3D(none)%3B%2B__utmv%3D' . $var_cookie . '.' . $var_uservar . '%3B';
		$b = $ga_remote_url;
	}
}

