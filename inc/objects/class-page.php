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

    /**
     * Subscribe Title text for the page
     *
     * @return array
     */
    public function get_subscribe_title_content() {
        return $this->get_meta( 'cst_subscribe' );
    }
    /**
     * Get Print Package for the Subscribe page
     *
     * @return array
     */
    public function get_subscribe_print_package() {
        return $this->get_meta( 'cst_subscribe_print' );
    }
    /**
     * Get Digital Package for the Subscribe page
     *
     * @return array
     */
    public function get_subscribe_digital_package() {
        return $this->get_meta( 'cst_subscribe_digital' );
    }
    /**
     * Get the image src based on the attachment id
     *
     * @return string
     */
    public function get_subscribe_image_url($attachment_id) {
        $url = wp_get_attachment_image_src($attachment_id, 'full-size');
        if( $url ) {
            return $url[0];
        } else {
            return false;
        }
    }

}