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

}

