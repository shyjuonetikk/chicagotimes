<?php

namespace CST\Objects;
defined('API_ENDPOINT') || define('API_ENDPOINT', get_option( 'wire_curator_feed_url' ));

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
	public static function create_from_simpleobject( $feed_entry, $articleId = '' ) {
		global $edit_flow;
		$response = vip_safe_wp_remote_get( API_ENDPOINT . '/api/news/' . $feed_entry->id , '', 3, 3, 20, [] );
		$feed_data = json_decode(wp_remote_retrieve_body( $response ));
		$feed_entry = (object) array_merge((array) $feed_entry, (array) $feed_data);

		$pub_date = date('c');
		$gmt_published = date( 'Y-m-d H:i:s', strtotime( isset($feed_entry->published) ? $feed_entry->published : $pub_date ) );
		$gmt_modified = date( 'Y-m-d H:i:s', strtotime( isset($feed_entry->updated) ? $feed_entry->updated  : $pub_date ) );

		// Hack to fix Edit Flow bug where it resets post_date_gmt and really breaks things
		if ( is_object( $edit_flow ) ) {
			$_POST['post_type'] = 'cst_wire_item';
		}
		$is_exist = 0;
		if( isset($articleId) && !empty( $articleId ) ) {
			$args = array(
			    'meta_query' => array(
			        array(
			            'key' => 'article_id',
			            'value' => $articleId
			        )
			    ),
			    'post_type' => 'cst_wire_item',
			    'posts_per_page' => 200,
				'suppress_filters' => false,
			);
			$is_exist = get_posts($args)[0]->ID;
		}

		$post_args = array(
			'post_title'        => sanitize_text_field( $feed_entry->title ),
			'post_content'      => wp_filter_post_kses( $feed_entry->summary ),
			'post_type'         => 'cst_wire_item',
			'post_author'       => 0,
			'post_status'       => 'publish',
			'post_name'         => md5( 'ap_wire_item' . $feed_entry->id ),
			'post_date'         => get_date_from_gmt( $gmt_published ),
			'post_date_gmt'     => $gmt_published,
			'post_modified'     => get_date_from_gmt( $gmt_modified ),
			'post_modified_gmt' => $gmt_modified,
			);

		if( $is_exist ) {
			$post_args['ID'] = $is_exist;
			$post_id = wp_update_post($post_args, true );
		} else {
			$post_id = wp_insert_post( $post_args, true );
		}
		if ( is_wp_error( $post_id ) ) {
			return $post_id;
		}

		$post = new AP_Wire_Item( $post_id );
		$post->set_meta( 'article_id', $articleId );
		$post->saveMedia( $feed_entry->media );
		if( !empty( $feed_entry->summary )) {
			$post->set_wire_headline( sanitize_text_field( (string) $feed_entry->summary ) );
		}
		if( !empty($feed_entry->blocks )) {
			$post->set_wire_content( wp_filter_post_kses( implode( '', $feed_entry->blocks ) ) );
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
		$post_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s LIMIT 0,1", $key ) );
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

		$link = Link::create( [ 'post_title'     => sanitize_text_field( $headline ), ] );

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

	public function saveMedia( $media ) {
		$photolist = [];
		$videolist = [];
		$mediaObj = [
			(object) [ 'name' => 'Main', 'code' => 'photo' ],
			(object) [ 'name' => 'Preview', 'code' => 'pr' ],
			(object) [ 'name' => 'Thumbnail', 'code' => 'tb' ],
		];
		foreach($media as $item) {
			$fileName = $item->fileName;
			foreach( $mediaObj as $role) {
				$url =  "https://s3.amazonaws.com/cst-apfeed/{$role->code}_{$fileName}";
				if( !in_array( $fileName, $photolist, true ) && $item->type === 'Photo' ) {
						$photolist[] = $fileName;
				}

				if( !in_array( $fileName, $videolist, true ) && $item->type === 'Video' ) {
						$videolist[] = $fileName;
				}
				$this->set_meta( $role->name . "_" . $fileName, $url );
			}
		}

		$this->set_meta( 'photo', implode( ',', $photolist ) );
		$this->set_meta( 'videos', implode( ',', $videolist ) );
	}

	/**
	 * Get the media from ntif
	 *
	 * @return Object
	 */
	 public function get_wire_media( $type ) {
 		if( !isset( $type ) || $type === '')
 			return [];
 		if( !$this->get_meta( $type ) )
 			return [];

 		$media = [];
 		$mediaList = explode( ',', $this->get_meta( $type ) );
 		foreach( $mediaList as $key ) {
 			$mediaItem = new \stdClass;
 			foreach( [ 'Main','Preview','Thumbnail' ] as $item ) {
 				if( $this->get_meta( $item . '_' . $key ) ) {
 					$mediaItem->{strtolower($item)} = (object) [
 						"name" => $item . '_' . $key,
 						"file" => $this->get_meta( $item . '_' . $key ),
 					];
 				}
 			}
 			$media[] = $mediaItem;
 		}
 		return $media;
 	}

	public function get_media_by_key( $key ) {
		return $this->get_meta( $key );
	}

	public function get_article_id() {
		return $this->get_meta( 'article_id' );
	}

}
