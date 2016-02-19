<?php

namespace CST\Objects;

class Link extends Post {

	protected static $post_type = 'cst_link';

	/**
	 * Get the font icon for an link
	 */
	public function get_font_icon() {
		return 'link';
	}

	/**
	 * External URL for the post
	 *
	 * @return string
	 */
	public function get_external_url() {
		return $this->get_meta( 'external_url' );
	}

}