<?php

namespace CST\Objects;

class Liveblog extends Post {

	protected static $post_type = 'cst_liveblog';

	/**
	 * Get the font icon for an link
	 */
	public function get_font_icon() {
		return 'comments';
	}

	/**
	 * Whether or not liveblog has been enabled on this post
	 */
	public function has_been_enabled() {
		return \WPCOM_Liveblog::is_liveblog_post( $this->get_id() );
	}

	/**
	 * Get the Liveblog (editor and content)
	 */
	public function get_content() {

		$content = apply_filters( 'the_content', parent::get_content() );


		if ( ! class_exists( 'WPCOM_Liveblog' ) ) {
			return $content;
		}

		// Liveblog hasn't been activated yet
		if ( ! $this->has_been_enabled() ) {
			return $content;
		}

		return \WPCOM_Liveblog::add_liveblog_to_content( $content );
	}

	/**
	 * Render liveblog without applying the_content filters
	 */
	public function the_content() {
		echo $this->get_content();
	}

	/**
	 * Get rendered content for the latest entry
	 */
	public function get_latest_entry_content() {

		// Liveblog hasn't been activated yet
		if ( ! $this->has_been_enabled() ) {
			return '';
		}

		// Get liveblog entries.
		$query = new \WPCOM_Liveblog_Entry_Query( $this->get_id(), 'liveblog' );
		$entry = $query->get_latest();
		if ( ! $entry ) {
			return '';
		}
		return $entry->render();

	}

}