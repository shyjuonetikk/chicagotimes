<?php
//
// from ...plugins/amp-wp/includes/embeds/class-amp-gallery-embed.php
//

require_once( AMP__DIR__ . '/includes/embeds/class-amp-base-embed-handler.php' );

class CST_AMP_Gallery_Embed extends AMP_Base_Embed_Handler {
	private static $script_slug = 'amp-carousel';
	private static $script_src = 'https://cdn.ampproject.org/v0/amp-carousel-0.1.js';
	public $dfp_handler;

	public function __construct( $args = array() ) {
		parent::__construct( $args = array(
			'width' => 640,
			'height' => 480,
		) );
		$this->dfp_handler = new CST_DFP_Handler;
	}

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
		$gallery_id                 = intval( $attr['id'] );
		$obj                        = new \CST\Objects\Gallery( $gallery_id );
		$urls                       = array();

		foreach ( $obj->get_gallery_image_ids() as $slide_number => $image_id ) {
			$image = get_post( $image_id );
			if ( ! $image ) {
				continue;
			}

			$attachment = new \CST\Objects\Attachment( $image );
			list( $url, $width, $height ) = wp_get_attachment_image_src( $image_id, 'chiwire-header-large', true );

			if ( ! $url ) {
				continue;
			}
			$caption    = $attachment->get_caption();

			$urls[] = array(
				'url'     => $url,
				'width'   => $width,
				'height'  => $height,
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
			$images[] = AMP_HTML_Utils::build_tag( 'div', array( 'class' => 'cst-image-container' ),
				AMP_HTML_Utils::build_tag(
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
			) ) ) );
		}
		$number_of_slides = count( $images );
		$ad_cadence = 3;
		for ( $index = 0; $index < $number_of_slides; $index++ ) {
			if ( $index > 0 ) { // avoid having an ad as the first slide :-)
				if ( 0 === ( $index % $ad_cadence ) ) {
					array_splice( $images, $index, 0, AMP_HTML_Utils::build_tag( 'amp-ad', array(
						'width'     => 300,
						'height'    => 250,
						'type'      => 'doubleclick',
						'data-slot' => $this->dfp_handler->ad_header_settings( true ),
						'json'      => '{"targeting":{"pos":"rr cube 1"}}',
					) ) );
				}
			}
		}

		$carousel_content = AMP_HTML_Utils::build_tag(
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

		return AMP_HTML_Utils::build_tag(
			'div',
			array(
				'class' => 'spacer',
			), $carousel_content
		);
	}
}