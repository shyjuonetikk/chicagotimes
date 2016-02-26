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
	 */
	public function cst_section_validate( $param, $request ) {
		$term = term_exists( $param, 'cst_section' );
		return sanitize_title( $term );
	}

	public function cst_section_handler( $request ) {
		$slug = $request->get_param( 'slug' );

		if ( null == $slug ) {
			return new WP_Error( 'chicagosuntimes', 'Invalid section', array( 'status' => 404 ) );
		}

		$content = get_posts( array(
			'post_type'   => 'cst_article',
			'cst_section' => $slug
		) );

		if ( empty( $content ) ) {
			return new WP_Error( 'chicagosuntimes', 'Invalid section', array( 'status' => 404 ) );
		}

		if ( is_array( $content ) ){
			array_map( array( $this, 'cst_maybe_add_featured_image' ), $content );
		}
		return $content;
	}

	/**
	 * @param $request
	 * @return array|WP_Error
	 *
	 * Expecting 'id' - an int representing post_id
	 *
	 */
	public function cst_article_handler( $request ) {

		$id = $request->get_param( 'id' );

		// Abort if not present
		if ( null == $id ) {
			return new WP_Error( 'chicagosuntimes', 'Invalid content', array( 'status' => 404 ) );
		}

		$content = get_post( $id );

		// Abort if no content found that matches the id
		if ( empty( $content ) ) {
			return new WP_Error( 'chicagosuntimes', 'Invalid content', array( 'status' => 404 ) );
		}
		// Do we have attached thumbnail media?
		$this->cst_maybe_add_featured_image( $content );

		return $content;
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

	public function cst_author_handler( $request ){

		$id = (int) $request->get_param( 'id' );
		$user = get_userdata( $id );
		$types = get_post_types( array( 'public' => true ), 'names' );
		// Abort if not present / valid
		if ( empty( $id ) || empty( $user->ID ) ) {
			return new WP_Error( 'chicagosuntimes', __( 'Invalid resource id.' ), array( 'status' => 404 ) );
		}
		if ( null == $id ) {
			return new WP_Error( 'chicagosuntimes', 'Invalid author', array( 'status' => 404 ) );
		}

	}
}