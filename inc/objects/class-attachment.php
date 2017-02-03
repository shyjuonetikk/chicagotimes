<?php

namespace CST\Objects;

/**
 * Base class to represent a WordPress Attachment
 */
class Attachment extends Post {

	protected static $post_type = 'attachment';

	/**
	 * Get the font icon for a attachment
	 */
	public function get_font_icon() {
		return 'paperclip';
	}

	/**
	 * Get the URL to the asset
	 *
	 * @param string $size
	 * @return string
	 */
	public function get_url( $size = 'full' ) {
		$src = wp_get_attachment_image_src( $this->get_id(), $size );
		if ( ! $src ) {
			return '';
		}

		return $src[0];
	}

	/**
	 * Get the orientation of the asset
	 *
	 * @return string
	 */
	public function get_orientation() {

		$src = wp_get_attachment_image_src( $this->get_id(), 'full' );
		if ( ! $src ) {
			return '';
		}

		if ( $src[1] > $src[2] ) {
			return 'horizontal';
		} else if ( $src[2] > $src[1] ) {
			return 'vertical';
		} else {
			return 'square';
		}

	}

	/**
	 * Get the height of the asset
	 *
	 * @return int
	 */
	public function get_height( $size = 'full' ) {
		$src = wp_get_attachment_image_src( $this->get_id(), $size );
		if ( ! $src ) {
			return 0;
		}

		return $src[2];
	}

	/**
	 * Get the width of the asset
	 *
	 * @return int
	 */
	public function get_width( $size = 'full' ) {
		$src = wp_get_attachment_image_src( $this->get_id(), $size );
		if ( ! $src ) {
			return 0;
		}

		return $src[1];
	}

	/**
	 * Get the HTML to represent this attachment
	 *
	 * @return string
	 */
	public function get_html( $size = 'full', $args = array() ) {
		return wp_get_attachment_image( $this->get_id(), $size, false, $args );
	}

	/**
	 * Get the caption for the attachment
	 *
	 * @return string
	 */
	public function get_caption() {
		return $this->get_excerpt();
	}

	/**
	 * Set the caption for the attachment
	 *
	 * @param string
	 */
	public function set_caption( $caption ) {
		$this->set_excerpt( $caption );
	}

	/**
	 * Get the credit for the attachment
	 *
	 * @return string
	 */
	public function get_credit() {
		$metadata = $this->get_metadata();
		if ( ! empty( $metadata['image_meta']['credit'] ) ) {
			return $metadata['image_meta']['credit'];
		} else {
			return '';
		}
	}

	/**
	 * Set the credit for the attachment
	 *
	 * @param string
	 */
	public function set_credit( $credit ) {
		$metadata = $this->get_metadata();
		if ( ! isset( $metadata['image_meta'] ) ) {
			$metadata['image_meta'] = array();
		}
		$metadata['image_meta']['credit'] = $credit;
		wp_update_attachment_metadata( $this->get_id(), $metadata );
	}

	/**
	 * Get attachment metadata
	 *
	 * @return array
	 */
	protected function get_metadata() {
		return wp_get_attachment_metadata( $this->get_id() );
	}


	/**
	 * Get the HTML for the hero image html
	 * @param featured_image_id
	 * @param $hero_sig
	 * @param $size
	 * @return string
	 */
	public function get_hero_image_html( $featured_image_id, $size, $hero_sig, $hero_title ) {
		if ( (int) $featured_image_id ) {
			$output = '<div class="hero-image">';
			$output .= wp_get_attachment_image( $featured_image_id, $size, '' );
			$output .= '<div class="row hero-title">';
			$output .= '<div class="columns small-12 small-centered hero-middle"><h1 class="hero-feature-title">FREEDOM FOR A COP-KILLER</h1></div>';
			$output .= '</div>';
			$output .= '<div class="hero-sig">';
			$output .= '<h3>' . esc_html( $hero_sig ) . '</h3></div>';
			$output .= '</div>';
			return $output;
		} else {
			return '';
		}
	}


}
