<?php

namespace CST\Objects;

class Embed extends Post {

	protected static $post_type = 'cst_embed';

	/**
	 * Get the font icon for an link
	 */
	public function get_font_icon() {
		$icons = array(
			'twitter'    => 'twitter',
			'instagram'  => 'instagram'
			);
		if ( isset( $icons[ $this->get_embed_type() ] ) ) {
			return $icons[ $this->get_embed_type() ];
		} else {
			return 'flickr';
		}
	}

	/**
	 * Get the embed type
	 *
	 * @return string|false
	 */
	public function get_embed_type() {

		$embed_url = $this->get_embed_url();
		if ( ! $embed_url ) {
			return false;
		}
		$domain = parse_url( $embed_url, PHP_URL_HOST );

		$types = array(
			'twitter.com'    => 'twitter',
			'instagram.com'  => 'instagram',
			'instagr.am'     => 'instagram',
			);
		if ( isset( $types[ $domain ] ) ) {
			return $types[ $domain ];
		} else {
			return false;
		}

	}

	/**
	 * Embed URL for the post
	 *
	 * @return string
	 */
	public function get_embed_url() {
		return $this->get_meta( 'embed_url' );
	}

	/**
	 * Get the data for the embed
	 *
	 * @return mixed
	 */
	public function get_embed_data() {

		$embed_url = $this->get_embed_url();

		if ( ! $embed_url ) {
			return false;
		}

		$key = 'embed_data_' . md5( $embed_url );
		return $this->get_meta( $key );
	}

	/**
	 * Inspect embed data to see if it's currently errored
	 *
	 * @return bool
	 */
	public function is_embed_data_errored() {

		$embed_data = $this->get_embed_data();
		switch ( $this->get_embed_type() ) {
			case 'twitter':
				if ( ! empty( $embed_data->errors ) ) {
					return true;
				}
				return false;

			// @todo error handling.
			case 'instagram':
				return false;

			default:
				return true;
		}

	}

	/**
	 * Fetch the data for the embed
	 */
	public function fetch_embed_data() {

		$embed_url = $this->get_embed_url();

		// Bail if the URL is already est
		$key = 'embed_data_' . md5( $embed_url );
		if ( ! $embed_url || ( $this->get_meta( $key ) && ! $this->is_embed_data_errored() ) ) {
			return;
		}

		$type = $this->get_embed_type();
		switch ( $type ) {

			case 'twitter':
				$wp_codebird = new \WP_Codebird;
				$wp_codebird->setConsumerKey( CST_TWITTER_CONSUMER_KEY, CST_TWITTER_CONSUMER_SECRET );

				preg_match( '#https?://(www\.)?twitter\.com/.+?/status(es)?/([0-9]+)#i', $embed_url, $matches );
				$status_id = isset( $matches[3] ) ? $matches[3] : 0;

				$status = (object) $wp_codebird->statuses_show_ID( 'id=' . $status_id );
				$this->set_meta( $key, $status );

				if ( $this->is_embed_data_errored() ) {
					// Errored Tweets shouldn't be published
					$this->set_status( 'pending' );
				} else {
					$short_status = substr( sanitize_text_field( $status->text ), 0, 50 );
					// Uh oh, fall back
					if ( empty( $short_status ) ) {
						$short_status = sanitize_text_field( sprintf( __( "Tweet from %s", 'chicagosuntimes' ), $status->user->screen_name ) );
					}
					$this->set_title( $short_status );
					$this->set_slug( sanitize_title( $short_status ) );
				}

				break;

			case 'instagram':

				$response = vip_safe_wp_remote_get( 'http://api.instagram.com/oembed?url=' . urlencode( $embed_url ) );

				if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
					break;
				}

				$instagram_data = json_decode( wp_remote_retrieve_body( $response ) );

				if ( ! $instagram_data ) {
					break;
				}

				if( preg_match( "#http://instagr(\.am|am\.com)/p/([a-zA-Z0-9-^/]+)#i", $embed_url, $matches ) ) {
					$instagram_data->instagram_id = sanitize_text_field( trim( $matches[2], '/' ) );
				} else {
					// Need the instagram ID for the frontend
					break;
				}

				$this->set_meta( $key, $instagram_data );
				$title = substr( $instagram_data->title, 0, 50 );
				$title = sanitize_text_field( $title );

				if ( empty( $title ) ) {
					$title = sanitize_text_field( sprintf( __( "Instagram brought to you by %s", 'chicagosuntimes' ), $instagram_data->author_name ) );
				}

				$this->set_title( $title );
				$this->set_slug( sanitize_title( $title ) );

				break;
		}

	}

}