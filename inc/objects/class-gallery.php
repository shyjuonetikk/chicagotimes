<?php

namespace CST\Objects;

class Gallery extends Post {

	protected static $post_type = 'cst_gallery';

	/**
	 * Get the font icon for an link
	 */
	public function get_font_icon() {
		return 'photo';
	}

	/**
	 * Use the first image as the featured image if the latter isn't set
	 *
	 * @return int|false
	 */
	public function get_featured_image_id() {

		if ( $featured_id = parent::get_featured_image_id() ) {
			return $featured_id;
		}

		$image_ids = $this->get_gallery_image_ids();
		if ( ! empty( $image_ids ) ) {
			return array_shift( $image_ids );
		} else {
			return false;
		}

	}

	/**
	 * Get gallery image ids
	 *
	 * @return array
	 */
	public function get_gallery_image_ids() {
		if ( $ids = $this->get_meta( 'gallery_images' ) ) {
			return $ids;
		} else {
			return array();
		}
	}

	/**
	 * Get the excerpt for the post
	 *
	 * @return mixed
	 */
	public function get_excerpt() {
			if ( $excerpt = $this->get_field( 'post_excerpt' ) ) {
					return $excerpt;
		}
	}

	/**
	 * Get the long excerpt for the post
	 *
	 * @return mixed
	 */
	public function get_long_excerpt() {
			if ( $excerpt = $this->get_fm_field( 'cst_long_excerpt' ) ) {
					return $excerpt;
		} else {
					return $this->get_excerpt();
		}
	}
}