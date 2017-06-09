<?php

namespace CST\Objects;

/**
 * Base class to represent an AP wire item
 */
class AP_Wire_Item extends Post {

	/**
	 * Create an AP Wire Item from its SimpleXML representation
	 *
	 * @param $feed_entry|SimpleXML
	 *
	 * @return AP_Wire_Item|int|\WP_Error|\WP_Post
	 */
	public static function create_from_simplexml( $feed_entry ) {
		global $edit_flow;

		$gmt_published = date( 'Y-m-d H:i:s', strtotime( $feed_entry->published ) );
		$gmt_modified = date( 'Y-m-d H:i:s', strtotime( $feed_entry->updated ) );

		// Hack to fix Edit Flow bug where it resets post_date_gmt and really breaks things
		if ( is_object( $edit_flow ) ) {
			$_POST['post_type'] = 'cst_wire_item';
		}

		$post_args = array(
			'post_title'        => sanitize_text_field( $feed_entry->title ),
			'post_content'      => wp_filter_post_kses( $feed_entry->content ),
			'post_type'         => 'cst_wire_item',
			'post_author'       => 0,
			'post_status'       => 'publish',
			'post_name'         => md5( 'ap_wire_item' . $feed_entry->id ),
			'post_date'         => get_date_from_gmt( $gmt_published ),
			'post_date_gmt'     => $gmt_published,
			'post_modified'     => get_date_from_gmt( $gmt_modified ),
			'post_modified_gmt' => $gmt_modified,
			);

		$post_id = wp_insert_post( $post_args, true );
		if ( is_wp_error( $post_id ) ) {
			return $post_id;
		}

		$post = new AP_Wire_Item( $post_id );

		// Process attributes
		foreach ( $feed_entry->link as $link ) {

			if ( 'AP Article' !== (string) $link['title'] ) {
				continue;
			}

			switch ( (string) $link['rel'] ) {
				case 'alternate':
					$post->set_external_url( esc_url_raw( (string) $link['href'] ) );
					break;

				case 'enclosure':

					$response = vip_safe_wp_remote_get( (string) $link['href'], '', 3, 3, 20 );
					if ( is_wp_error( $response ) ) {
						break;
					}
					if ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
						break;
					}

					$nitf_data = wp_remote_retrieve_body( $response );
					$headline = $post->get_nitf_field( $nitf_data, 'body/body.head/hedline/hl1' );
					if ( ! empty( $headline ) ) {
						$post->set_wire_headline( sanitize_text_field( (string) $headline[0] ) );
					}

					$dateline = $post->get_nitf_field( $nitf_data, 'body/body.head/dateline' );
					if ( ! empty( $dateline[0] ) ) {
						$post->set_wire_dateline( sanitize_text_field( (string) $dateline[0]->location ) );
					}

					$content = $post->get_nitf_field( $nitf_data, 'body/body.content/block' );
					if ( ! empty( $content ) ) {
						$post->set_wire_content( wp_filter_post_kses( $content[0]->asXML() ) );
					}

					break;
			}

		}

		return $post;
	}

	/**
	 * Get an AP Wire Item by its original ID
	 *
	 * @param string $original_id
	 * @return AP_Wire_Item|false
	 */
	public static function get_by_original_id( $original_id ) {
		global $wpdb;

		$key = md5( 'ap_wire_item' . $original_id );
		$post_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name=%s LIMIT 0,1", $key ) );
		if ( ! $post_id ) {
			return false;
		}

		return new AP_Wire_Item( $post_id );
	}

	/**
	 * Get the item's headline from its NITF data
	 *
	 * @return string
	 */
	public function get_wire_headline() {
		return $this->get_meta( 'wire_headline' );
	}

	/**
	 * Set the item's wire headline
	 *
	 * @param string
	 */
	public function set_wire_headline( $wire_headline ) {
		$this->set_meta( 'wire_headline', $wire_headline );
	}

	/**
	 * Get the item's dateline from its NITF data
	 *
	 * @return string
	 */
	public function get_wire_dateline() {
		return $this->get_meta( 'wire_dateline' );
	}

	/**
	 * Set the item's wire dateline
	 *
	 * @param string
	 */
	public function set_wire_dateline( $wire_dateline ) {
		$this->set_meta( 'wire_dateline', $wire_dateline );
	}

	/**
	 * Get the item's body from its NITF data
	 *
	 * @return string
	 */
	public function get_wire_content() {
		return $this->get_meta( 'wire_content' );
	}

	/**
	 * Set the item's wire body
	 *
	 * @param string
	 */
	public function set_wire_content( $wire_content ) {
		$this->set_meta( 'wire_content', $wire_content );
	}

	/**
	 * Get a given field from the NITF data
	 *
	 * @param $nitf_data
	 * @param $xpath
	 *
	 * @return \SimpleXMLElement[]|string
	 */
	public function get_nitf_field( $nitf_data, $xpath ) {

		if ( empty( $nitf_data ) ) {
			return '';
		}

		$obj = simplexml_load_string( $nitf_data );
		return $obj->xpath( $xpath );
	}

	/**
	 * External URL for the AP Wire Item
	 *
	 * @return string
	 */
	public function get_external_url() {
		return $this->get_meta( 'external_url' );
	}

	/**
	 * External URL for the AP Wire Item
	 *
	 * @param string
	 */
	public function set_external_url( $external_url ) {
		$this->set_meta( 'external_url', $external_url );
	}

	/**
	 * Get the post for the article
	 *
	 * @return \CST\Objects\Article|false
	 */
	public function get_article_post() {

		if ( $post_id = $this->get_meta( 'article_post_id' ) ) {

			if ( $post = get_post( $post_id ) ) {
				return new Article( $post );
			}

		}

		return false;
	}

	/**
	 * Create an article post from this wire item
	 *
	 * @return \CST\Objects\Article|false
	 */
	public function create_article_post() {
		global $coauthors_plus;

		$article = Article::create( array(
			'post_title'     => sanitize_text_field( $this->get_wire_headline() ),
			'post_content'   => wp_filter_post_kses( $this->get_wire_content() ),
		) );
		if ( ! $article ) {
			return false;
		}

		if ( WP_DEBUG && $coauthors_plus && $guest_author = $coauthors_plus->guest_authors->get_guest_author_by( 'post_name', 'associated-press' ) ) {
			$coauthors_plus->add_coauthors( $article->get_id(), array( $guest_author->user_nicename ), false );
		} elseif ( $coauthors_plus && $guest_author = $coauthors_plus->guest_authors->get_guest_author_by( 'post_name', 'associatedpress' ) ) {
			$coauthors_plus->add_coauthors( $article->get_id(), array( $guest_author->user_nicename ), false );
		}

		$this->set_meta( 'article_post_id', $article->get_id() );

		return $article;
	}

	/**
	 * Get the post for the link
	 *
	 * @return \CST\Objects\Link|false
	 */
	public function get_link_post() {

		if ( $post_id = $this->get_meta( 'link_post_id' ) ) {

			if ( $post = get_post( $post_id ) ) {
				return new Link( $post );
			}

		}

		return false;
	}

	/**
	 * Create a link post from this wire item
	 *
	 * @return \CST\Objects\Link|false
	 */
	public function create_link_post() {
		global $coauthors_plus;

		if ( $title = $this->get_wire_headline() ) {
			$headline = $title;
		} else {
			$headline = $this->get_title();
		}

		$link = Link::create( array(
			'post_title'     => sanitize_text_field( $headline ),
		) );
		if ( ! $link ) {
			return false;
		}

		if ( $coauthors_plus && $guest_author = $coauthors_plus->guest_authors->get_guest_author_by( 'post_name', 'associated-press' ) ) {
			$coauthors_plus->add_coauthors( $link->get_id(), array( $guest_author->user_nicename ), false );
		}

		$this->set_meta( 'link_post_id', $link->get_id() );
		$link->set_meta( 'external_url', $this->get_external_url() );

		return $link;
	}

	/**
	 * Not necessary because not displayed on frontend
	 */
	public function get_font_icon() {
		return '';
	}

}
