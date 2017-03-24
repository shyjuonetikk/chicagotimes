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
		add_action( 'pre_get_posts', [ $this, 'increase_post_count' ] );
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
	 * @param $query
	 *
	 * Increasing get post limit for each syndicated or partner feed
	 * given there is probably attrition due to use of licensed images
	 */
	public function increase_post_count( $query ) {
		if ( $query->is_feed() ) {
			foreach ( $this->syndicated_feeds as $syndicated_feed ) {
				if ( is_feed( $syndicated_feed ) ) {
					$query->set( 'posts_per_page', 20 );
				}
			}
		}
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
	 * @param \CST\Objects\Article|\CST\Objects\Gallery $obj
	 *
	 * @return bool
	 *
	 * Deny publishing of content with licensed images in a partner feed
	 */
	private function contains_licensed_image( $obj ) {

		if ( ! $obj ) {
			// cannot deny or confirm
			return false;
		}

		// get and check featured image - easiest
		$featured_image_id = $obj->get_featured_image_id();
		if ( $featured_image_id && $attachment = \CST\Objects\Attachment::get_by_post_id( $featured_image_id ) ) {
			if ( $this->check_image_credit( $attachment ) ) {
				return true;
			}
		}
		// get and check attached images - easy
		$attached_to_content = get_attached_media( 'image/*', $obj->get_id() );
		if ( is_array( $attached_to_content ) && ! empty( $attached_to_content ) ) {
			foreach ( $attached_to_content as $item ) {
				$attachment = \CST\Objects\Attachment::get_by_post_id( $item->ID );
				if ( $this->check_image_credit( $attachment ) ) {
					return true;
				}
			}
		}
		// get and check inline images - if necessary hard
		return false;
	}

	/**
	 * @param $attachment
	 *
	 * @return bool
	 * Establish if the content (an attachment) is from a licensed partner
	 */
	private function check_image_credit( $attachment ) {
		$image_credit = $attachment->get_credit();
		if ( '' !== $image_credit ) {
			$licensed_photo_sources = array(
				'AP Photo',
				'Getty Images',
			);
			foreach ( $licensed_photo_sources as $licensed_photo_source ) {
				if ( false !== strpos( $licensed_photo_source, $image_credit ) ) {
					// License source found somewhere in credit meta
					return true;
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
				if ( $this->contains_licensed_image( $obj ) ) {
					return false;
				}
				return true;
			}
			if ( $this->contains_licensed_image( $obj ) ) {
				return false;
			}
		} else {
			$publish_me = true;
		}
		return $publish_me;
	}

}

