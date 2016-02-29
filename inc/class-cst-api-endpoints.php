<?php

class CST_API_Endpoints {

	private static $instance;
	
	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new CST_API_Endpoints();
		}
		return self::$instance;
	}
	/**
	 * @param $param
	 * @param $request
	 * @return string
	 *
	 * Are we being asked for a term we actually have?
	 */
	public function cst_section_validate( $param, $request ) {
		$term = wpcom_vip_term_exists( $param, 'cst_section' );
		return sanitize_title( $term );
	}

	/**
	 * @param $request
	 * @return array|WP_Error
	 * 
	 * Handle a section request
	 * Check the parameters and abort if out of range or invalid
	 */
	public function cst_section_handler( $request ) {

		$slug = $request->get_param( 'slug' );
		$count = (int) $request->get_param( 'count' );

		if ( null == $slug ) {
			return new WP_Error( 'chicagosuntimes', 'Invalid section', array( 'status' => 404 ) );
		}
		if ( $count == 0 ) {
			return new WP_Error( 'chicagosuntimes', 'Out of range', array( 'status' => 404 ) );
		}

		if ( $count > 100 ) {
			$count = 100;
		}

		$content = get_posts( array(
			'post_type'   => 'cst_article',
			'cst_section' => $slug,
			'posts_per_page' => $count,
		) );

		if ( empty( $content ) ) {
			return new WP_Error( 'chicagosuntimes', 'Invalid section', array( 'status' => 404 ) );
		}

		if ( is_array( $content ) ) {
			array_map( array( $this, 'cst_maybe_add_featured_image' ), $content );
		}
		if ( is_array( $content ) ) {
			array_map( array( $this, 'cst_maybe_add_media_ids' ), $content );
		}
		return $content;
	}

	/**
	 * @param $request
	 * @return array|WP_Error
	 *
	 * Expecting 'id' - an int representing post_id
	 * Return a post object
	 *
	 */
	public function cst_article_handler( $request ) {

		$id = $request->get_param( 'id' );

		// Abort if not present
		if ( null == $id ) {
			return new WP_Error( 'chicagosuntimes', 'Invalid content', array( 'status' => 404 ) );
		}

		$query = new \WP_Query( array(
			'p' => $id,
			'post_type' => 'cst_article',
			'post_status' => 'publish',
			'numberposts' => 1,
		) );

		// Abort if no content found that matches the id
		if ( empty( $query ) ) {
			return new WP_Error( 'chicagosuntimes', 'Invalid content', array( 'status' => 404 ) );
		}
		if ( $query->have_posts() ) {
			$query->the_post();
			$content = get_post( get_the_ID() );
			// Do we have attached thumbnail media?
			$this->cst_maybe_add_featured_image( $content );
			$this->cst_maybe_add_media_ids( $content );
			return $content;
		} else {
			return new WP_Error( 'chicagosuntimes', 'Invalid content', array( 'status' => 404 ) );
		}

	}
	/**
	 * @param $request
	 * @return array|WP_Error
	 *
	 * Expecting 'id' - an int representing post_id
	 *
	 */
	public function cst_media_handler( $request ) {

		$id = $request->get_param( 'id' );

		// Abort if not present
		if ( null == $id ) {
			return new WP_Error( 'chicagosuntimes', 'Invalid media', array( 'status' => 404 ) );
		}

		$content = get_post( $id );
		// Abort if no content found that matches the id
		if ( empty( $content ) ) {
			return new WP_Error( 'chicagosuntimes', 'Invalid media', array( 'status' => 404 ) );
		}

		if ( 'attachment' != $content->post_type ) {
			return new WP_Error( 'chicagosuntimes', 'Invalid media', array( 'status' => 404 ) );
		}

		// Do we have attached thumbnail media?
		$this->cst_maybe_add_featured_image( $content );

		return $content;
	}

	/**
	 * @param $content
	 * @return mixed
	 * 
	 * Add featured image id to post/content response object (if found)
	 */
	private function cst_maybe_add_featured_image( $content ) {

		$thumbnail_id = (int) get_post_thumbnail_id( $content->ID );
		if ( '' != $thumbnail_id ) {
			$content->featured_media = $thumbnail_id;
		}
		return $content;
	}
	/**
	 * @param $content
	 * @return mixed
	 *
	 * Add featured image id to post/content response object (if found)
	 * Adds attachments as an array of ids to the returned post object
	 */
	private function cst_maybe_add_media_ids( $content ) {

		$media = new \WP_Query( array(
				'post_type' => 'attachment',
				'post_parent' => $content->ID,
				'no_found_rows'	=> true,
				'post_status' => 'inherit',
				'fields' => array( 'ID' )
			)
		);
		if ( $media->have_posts() ) {
			$media_items = array();
			while( $media->have_posts() ) {
				$media->the_post();
				array_push( $media_items, get_the_ID() );
			}
			$content->attachments = array( $media_items );
		}
		return $content;
	}

}