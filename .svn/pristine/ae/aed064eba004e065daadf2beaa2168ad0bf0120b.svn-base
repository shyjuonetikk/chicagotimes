<?php

namespace CST\Objects;

class Video extends Post {

	protected static $post_type = 'cst_video';

	/**
	 * Get the font icon for an link
	 */
	public function get_font_icon() {
		return 'video-camera';
	}

	/**
	 * Video URL for the embed
	 *
	 * @return string
	 */
	public function get_video_url() {
		return $this->get_meta( 'video_url' );
	}

	/**
	 * Get the Video iframe embed
	 *
	 * @return string
	 */
	public function get_video_embed() {

		$video_url = $this->get_video_url();
		$host = parse_url( $video_url, PHP_URL_HOST );

		// ex http://youtu.be/HJMapA8WgYw
		if ( in_array( $host, array( 'youtu.be' ) ) ) {
			$video_id = trim( parse_url( $video_url, PHP_URL_PATH ), '/' );
		// ex https://www.youtube.com/watch?v=HJMapA8WgYw&feature=youtu.be
		} else if ( in_array( $host, array( 'youtube.com', 'www.youtube.com' ) ) ) {
			parse_str( parse_url( $this->get_video_url(), PHP_URL_QUERY ), $youtube_vars );
			$video_id = ( ! empty( $youtube_vars['v'] ) ) ? $youtube_vars['v'] : '';
		} else {
			$video_id = '';
		}

		if ( empty( $video_id ) ) {
			return '';
		}

		$iframe = '<iframe class="cst-responsive" data-true-height="640" data-true-width="360" width="100%" height="320px" src="' . esc_url( '//www.youtube.com/embed/' . sanitize_text_field( $video_id ) ) . '" frameborder="0"></iframe>';
		return $iframe;

	}

	/**
	 * Video Description for the embed
	 *
	 * @return string
	 */
	public function get_video_description() {
		return $this->get_meta( 'video_description' );
	}

	/**
	 * Better defaults for this content type
	 */
	public function get_default_facebook_open_graph_tag( $name ) {

		if ( 'description' === $name ) {
			return $this->get_video_description();
		} else {
			return parent::get_default_facebook_open_graph_tag( $name );
		}

	}

	/**
	 * Better defaults for this content type
	 */
	public function get_default_twitter_card_tag( $name ) {

		if ( 'description' === $name ) {
			return $this->get_video_description();
		} else {
			return parent::get_default_twitter_card_tag( $name );
		}

	}

	/**
	 * Automagically fetch the featured image
	 */
	public function fetch_featured_image() {

		// Various situations where we don't actually want to proceed
		$video_url = $this->get_video_url();
		if ( $this->get_featured_image_id()
			|| ! $video_url
			|| get_post_meta( $this->get_id(), '_cst_did_youtube_thumbnail', true )
			|| ! in_array( parse_url( $video_url, PHP_URL_HOST ), array( 'www.youtube.com', 'youtube.com', 'youtu.be' ) ) ) {
			return;
		}

		$request_url = 'http://www.youtube.com/oembed?format=json&maxheight=9999&maxwidth=9999&url=' . urlencode( $video_url );
		$response = wp_remote_get( $request_url );
		// Let's not try again anyway.
		if ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
			$this->set_meta( '_cst_did_youtube_thumbnail', 1 );
			return;
		}

		$body = json_decode( wp_remote_retrieve_body( $response ) );
		if ( ! $body ) {
			return;
		}
		if ( empty( $body->thumbnail_url ) ) {
			$this->set_meta( '_cst_did_youtube_thumbnail', 1 );
			return;
		}

		// See if there's a high-res version
		$high_res = str_replace( 'hqdefault.jpg', 'maxresdefault.jpg', $body->thumbnail_url );
		$high_res_request = wp_remote_head( $high_res );
		if ( 200 === wp_remote_retrieve_response_code( $high_res_request ) ) {
			$thumbnail_url = $high_res;
		} else {
			$thumbnail_url = $body->thumbnail_url;
		}

		$response = wpcom_vip_download_image( $thumbnail_url, $this->get_id() );
		if ( ! is_wp_error( $response ) ) {
			$this->set_meta( '_thumbnail_id', $response );
		}
		$this->set_meta( '_cst_did_youtube_thumbnail', 1 );

	}

}