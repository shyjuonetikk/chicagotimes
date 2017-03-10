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
		'rio-2016'          => 'BQ3NYJzd',
		'blackhawks-hockey' => 'idn8h9Kj',
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
	 *
	 * @return string
	 */
	public function get_featured_media_type() {
		if ( $media_type = $this->get_fm_field( 'cst_production', 'featured_media', 'featured_media_type' ) ) {
			return $media_type;
		} else {
			return 'image';
		}
	}

	/**
	 * Get the featured video embed code for the article
	 * Return empty string if for some reason array key is outside scope
	 *
	 * @return string
	 */
	public function get_featured_video_embed() {
		if ( $media_type = $this->get_fm_field( 'cst_production', 'featured_media', 'featured_video' ) ) {
			if ( array_key_exists( $media_type, $this->send_to_news_embeds ) ) {
				$template   = '<div class="video-injection"><div class="s2nPlayer k-%1$s %2$s" data-type="float"></div><script type="text/javascript" src="http://embed.sendtonews.com/player3/embedcode.js?fk=%1$s&cid=4661&offsetx=0&offsety=75&floatwidth=300&floatposition=top-left" data-type="s2nScript"></script></div>';
				$markup     = sprintf( $template, $this->send_to_news_embeds[ $media_type ], $this->post->ID );
				return $markup;
			} else {
				return '';
			}
		} else {
			return '';
		}
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
}