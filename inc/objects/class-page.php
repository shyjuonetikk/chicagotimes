<?php

namespace CST\Objects;

class Page extends Post {

	protected static $post_type = 'page';

	/**
	 * Get the font icon for an link
	 */
	public function get_font_icon() {
		return 'link';
	}

    /**
     * Get the yieldmo tag field for the page
     *
     * @return string
     */
    public function get_yieldmo_tag() {

        if ( $yieldmo_tag = $this->get_fm_field( 'yieldmo_tags' ) ) {
            return $yieldmo_tag;
        } else {
            return false;
        }

    }

}