<?php

namespace CST\Objects;

class Guest_Author extends Author {

	public function __construct( $guest_author ) {

		$this->guest_author = $guest_author;

	}

	/**
	 * Get the ID for the user
	 *
	 * @return int
	 */
	public function get_id() {
		return $this->get_field( 'ID' );
	}

	/**
	 * Get the display name for a user
	 *
	 * @return string
	 */
	public function get_display_name() {
		return $this->get_field( 'display_name' );
	}

	/**
	 * Get the first name for a user
	 *
	 * @return string
	 */
	public function get_first_name() {
		return $this->guest_author->first_name;
	}

	/**
	 * Get the last name for a user
	 *
	 * @return string
	 */
	public function get_last_name() {
		return $this->guest_author->last_name;
	}

	/**
	 * Get the user login value for the user
	 *
	 * @return string
	 */
	public function get_user_login() {
		return $this->get_field( 'user_login' );
	}

	/**
	 * Get the email address for the user
	 *
	 * @return string
	 */
	public function get_email() {
		return $this->get_field( 'user_email' );
	}

	/**
	 * Get the user's permalink
	 *
	 * @return string
	 */
	public function get_permalink() {
		return get_author_posts_url( $this->get_id(), $this->get_field( 'user_nicename') );
	}

	/**
	 * Get the avatar for the user
	 *
	 * @param int $size
	 * @return string
	 */
	public function get_avatar( $size ) {

		// @todo support for featured images
		return '';
	}

	/**
	 * Get the description for the user
	 *
	 * @return string
	 */
	public function get_description() {
		return $this->guest_author->description;
	}

	/**
	 * Get the Twitter username for this user
	 *
	 * @return string
	 */
	public function get_twitter_username() {
		return $this->get_meta( 'cap-twitter' );
	}

	/**
	 * Get a user's field
	 *
	 * @param string $key
	 * @return mixed
	 */
	protected function get_field( $key ) {
		return $this->guest_author->$key;
	}

	/**
	 * Get a meta value for a guest author post
	 *
	 * @param string
	 * @return mixed
	 */
	protected function get_meta( $key ) {
		return get_post_meta( $this->get_id(), $key, true );
	}

}