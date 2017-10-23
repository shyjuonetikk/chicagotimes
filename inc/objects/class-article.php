<?php

namespace CST\Objects;

class Article extends Post {

	protected static $post_type = 'cst_article';
	private $send_to_news_embeds = array(
		'cubs'              => 'xXrmaE8c',
		'white-sox'         => 'TR8jtM5y',
		'bulls'             => 'oags2xgZ',
		'bears'             => 'L9X2Tt4y',
		'pga-golf'          => 'a7k31LHx',
		'nascar'            => 'L0muW63f',
		'ahl-wolves'        => 'udXbWp8Y',
		'college'           => 'SRHLAr2T',
		'rio-2016'          => 'fLPoOgHI',
		'blackhawks-hockey' => 'uy7k8sat',
		'hockey-blackhawks' => 'uy7k8sat',
	);
	/**
	 * Get the font icon for an article
	 */
	public function get_font_icon() {
		return 'file-o';
	}

	/**
	 * Get the featured media type for the article
	 * Handle custom video embeds but check they are disabled
	 * and if so resort to using featured image
	 *
	 * @return string
	 */
	public function get_featured_media_type() {
		if ( $media_type = $this->get_fm_field( 'cst_production', 'featured_media', 'featured_media_type' ) ) {
			$video_type = $this->get_fm_field( 'cst_production', 'featured_media', 'featured_video' );
			if ( 'embed_video' === $media_type ) {
				return $media_type;
			}
			if ( 'video' === $media_type && '--disable--' !== $video_type ) {
				return $media_type;
			}
			return $media_type;
		} else {
			return 'image';
		}
	}

	/**
	 * Return featured video embed markup for the article
	 * Return empty string if for some reason array key is outside scope
	 *
	 * @return string
	 */
	public function featured_video_embed() {
		// $media_type reflects choice for Featured Image position - image, SendToNews video or gallery
		$media_type = $this->get_fm_field( 'cst_production', 'featured_media', 'featured_video' );
		// $video_id reflects the id of the CST Video that has an embed such as Cube
		$video_id = $this->get_fm_field( 'cst_production', 'featured_media', 'embed_video' );
		if ( '--disable--' === $media_type && $video_id ) {
			return $this->get_cst_video_embed( (int) $video_id );
		} else if ( '--disable--' !== $media_type ) {
			if ( array_key_exists( $media_type, $this->send_to_news_embeds ) ) {
				if ( defined( 'AMP__VERSION' ) && is_amp_endpoint() ) {
					return $this->get_featured_video_embed( $media_type );
				} else {
					if ( is_singular() || is_tax( 'cst_section' ) ) {
						return $this->get_featured_video_embed( $media_type );
					}
				}
			} else {
				return '';
			}
		} else {
			return '';
		}
	}

	/**
	 * @param $embed_id
	 *
	 * @return string
	 */
	private function get_cst_video_embed( $embed_id ) {
		$obj = \CST\Objects\Post::get_by_post_id( $embed_id );
		if ( ! $obj || is_wp_error( $obj ) || 'publish' !== $obj->get_status() ) {
			return '';
		} else {
			return $obj->get_video_embed();
		}
	}
	/**
	 * @param $media_type
	 *
	 * @return string
	 */
	public function get_featured_video_embed( $media_type ) {

		if ( defined( 'AMP__VERSION' ) && is_amp_endpoint() ) { // legacy
			$template   = '<iframe id="%1$s" src="%2$s" %3$s></iframe>';
			$styles     = 'frameborder="0" scrolling="no" allowfullscreen=" class=s2nvcloader';
			$iframe_url = sprintf( 'https://embed.sendtonews.com/player2/embedplayer.php?type=full&amp;fk=%s&amp;cid=4661', $this->send_to_news_embeds[ $media_type ] );
			$markup = sprintf( $template, 's2nIframe-' . esc_attr( $this->send_to_news_embeds[ $media_type ] ) . '-' . esc_attr( $this->post->ID ), esc_url( $iframe_url ), esc_attr( $styles ) );
		} else {
			$template = '<div class="video-injection"><div class="s2nPlayer k-%1$s %2$s" data-type="float"><script type="text/javascript" src="' . esc_url( 'https://embed.sendtonews.com/player3/embedcode.js?fk=%1$s&cid=4661&offsetx=0&offsety=50&floatwidth=300&floatposition=top-left' ) . '" data-type="s2nScript"></script></div></div>';
			$markup   = sprintf( $template, esc_attr( $this->send_to_news_embeds[ $media_type ] ), esc_attr( $this->post->ID ) );
		}
		return $markup;
	}
	/**
	 * Get preferred section if set or fallback to default behavior
	 * and display the section as before (and as passed to this function)
	 *
	 * @param $default_section
	 * @return array
	 */
	public function get_preferred_section( $default_section ) {
		$preferred_terms = $this->get_preferred_terms( 'cst_preferred_terms' );
		$section = $default_section;
		$section_name = '';
		if ( $preferred_terms ) {
			if ( ! empty( $preferred_terms['choose_section'] ) ) {
				$preferred_section = $preferred_terms['choose_section']['featured_option_section'];
				if ( $preferred_section ) {
					$section = wpcom_vip_get_term_by( 'id', $preferred_section, 'cst_section' );
				}
			}
		}
		$term_link = wpcom_vip_get_term_link( $section, 'cst_section' );
		if ( is_wp_error( $term_link ) ) {
			$section_object = wpcom_vip_get_term_by( 'slug', $section, 'cst_section' );
			$term_link = '';
		} else {
			if ( is_object( $section ) ) {
				$section_object = $section;
			} else {
				$section_object = wpcom_vip_get_term_by( 'slug', $section, 'cst_section' );
			}
		}
		$section_name = $section_object->name;

		return array(
			'term_link' => $term_link,
			'term_name' => $section_name,
			'term_object' => $section_object,
		);
	}


	/**
	 * Get the featured gallery object for the article
	 *
	 * @return Gallery|false
	 */
	public function get_featured_gallery() {
		if ( $gallery = Gallery::get_by_post_id( $this->get_fm_field( 'cst_production', 'featured_media', 'featured_gallery' ) ) ) {
			return $gallery;
		} else {
			return false;
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