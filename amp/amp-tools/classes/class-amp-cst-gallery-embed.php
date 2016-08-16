<?php
//
// from ...plugins/amp-wp/includes/embeds/class-amp-gallery-embed.php
//

require_once( AMP__DIR__ . '/includes/embeds/class-amp-base-embed-handler.php' );

class CST_AMP_Gallery_Embed extends AMP_Base_Embed_Handler {
	private static $script_slug = 'amp-carousel';
	private static $script_src = 'https://cdn.ampproject.org/v0/amp-carousel-0.1.js';

	public function register_embed() {
		// If we have an existing callback we are overriding, remove it.
		remove_shortcode( 'cst-content' );
		// Add our new callback
		add_shortcode( 'cst-content', array( $this, 'process_shortcode' ) );
	}

	public function unregister_embed() {
		// Let's clean up after ourselves, just in case.
	}

	public function get_scripts() {
		if ( ! $this->did_convert_elements ) {
			return array();
		}

		return array( self::$script_slug => self::$script_src );
	}

	public function process_shortcode( $attr ) {
		// See https://github.com/ampproject/amphtml/blob/master/extensions/amp-list/amp-list.md for details on amp-list
		if ( empty( $attr['id'] ) ) {
			return '';
		}
		$this->did_convert_elements = true;
		$gallery_id = intval( $attr['id'] );
		$obj = new \CST\Objects\Gallery( $gallery_id );
		$urls = array();

		foreach ( $obj->get_gallery_image_ids() as $slide_number => $image_id ) {
			$image = get_post( $image_id );
			if ( ! $image ) {
				continue;
			}

			$attachment  = new \CST\Objects\Attachment( $image );
			$caption   = $attachment->get_caption();
			list( $url, $width, $height ) = wp_get_attachment_image_src( $image_id, array( $attachment->get_height(), $attachment->get_width() ), true );

			if ( ! $url ) {
				continue;
			}

			$urls[] = array(
				'url' => $url,
				'width' => $width,
				'height' => $height,
				'caption' => $caption,
			);
		}

		return $this->render( array(
			'images' => $urls,
		) );
	}
	public function render( $args ) {

		$args = wp_parse_args( $args, array(
			'images' => false,
		) );

		if ( empty( $args['images'] ) ) {
			return '';
		}

		$this->did_convert_elements = true;
		$images                     = array();
		$captions                   = array();
		foreach ( $args['images'] as $image ) {
			$images[] = AMP_HTML_Utils::build_tag(
				'amp-img',
				array(
					'src'    => $image['url'],
					'width'  => $image['width'],
					'height' => $image['height'],
					'layout' => 'responsive',
				), AMP_HTML_Utils::build_tag(
				'div',
				array(
					'class'  => 'caption',
				), AMP_HTML_Utils::build_tag(
				'p',
				array(
					'class' => 'captiontext',
				), $image['caption']
			) ) );
		}

		return AMP_HTML_Utils::build_tag(
			'amp-carousel',
			array(
				'width'  => $this->args['width'],
				'height' => $this->args['height'],
				'type'   => 'slides',
				'layout' => 'responsive',
				'class'  => 'cst-amp-carousel',
			),
			implode( PHP_EOL, $images )
		);
	}
}