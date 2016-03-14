<?php

namespace CST\Objects;

/**
 * Base User class
 */
class User extends Author {

	private $user;

	public function __construct( $user ) {

		if ( is_numeric( $user ) ) {
			$user = get_user_by( 'id', $user );
		}

		$this->user = $user;

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
		return $this->user->display_name;
	}

	/**
	 * Get the first name for a user
	 *
	 * @return string
	 */
	public function get_first_name() {
		if ( $first_name = $this->user->first_name ) {
			return $first_name;
		} else {
			$parts = explode( ' ', $this->get_display_name() );
			return array_shift( $parts );
		}
	}

	/**
	 * Get the last name for a user
	 *
	 * @return string
	 */
	public function get_last_name() {
		if ( $last_name = $this->user->last_name ) {
			return $last_name;
		} else {
			$parts = explode( ' ', $this->get_display_name() );
			return array_pop( $parts );
		}
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
		return get_avatar( $this->get_id(), $size );
	}

	/**
	 * Get the description for the user
	 *
	 * @return string
	 */
	public function get_description() {
		return $this->user->description;
	}

	/**
	 * Get the type of the user
	 *
	 * @return string
	 */
	public function get_type() {
		return $this->user->type;
	}

	/**
	 * Get the Twitter username for this user
	 *
	 * @return string
	 */
	public function get_twitter_username() {
		return $this->get_gravatar_detail( 'twitter_username' );
	}

	/**
	 * Get the Twitter username for this geust user
	 *
	 * @return string
	 */
	public function get_guest_twitter_username() {
		return $this->get_meta( 'cap-twitter' );
	}

	/**
	 * Get a user's field
	 *
	 * @param string $key
	 * @return mixed
	 */
	protected function get_field( $key ) {
		return $this->user->$key;
	}

	/**
	 * Get a detail from the user's Gravatar profile
	 *
	 * @param string $detail
	 * @return mixed
	 */
	protected function get_gravatar_detail( $detail ) {

		$gravatar_details = wpcom_vip_get_user_profile( $this->get_email() );

		$ret = false;
		switch ( $detail ) {
			case 'twitter_username':

				if ( empty( $gravatar_details['accounts'] ) ) {
					break;
				}

				$twitter_account = false;
				foreach( $gravatar_details['accounts'] as $account ) {

					if ( 'twitter' == $account['shortname'] ) {
						$twitter_account = $account;
						break;
					}

				}

				$ret = ! empty( $twitter_account['username'] ) ? $twitter_account['username'] : '';
				break;

			default:
				break;
		}

		return $ret;

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