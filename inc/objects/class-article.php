<?php

namespace CST\Objects;

class Article extends Post {

	protected static $post_type = 'cst_article';
	private $send_to_news_embeds = array(
		'cubs'              => 'uqWfqG2Y',
		'white-sox'         => 'WOOeQ5Jw',
		'bulls'             => 's3AyJdaz',
		'bears'             => 'C30fZO7v',
		'pga-golf'          => '8Owdfvnq',
		'nascar'            => 'hdUJ4uMz',
		'ahl-wolves'        => 'dAT6rZV6',
		'college'           => 'IS3jNqMB',
		'rio-2016'          => 'BQ3NYJzd',
		'blackhawks-hockey' => 'idn8h9Kj',
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
				$template   = '<p><iframe id="%s" src="%s" %s></iframe></p>';
				$styles     = 'frameborder="0" scrolling="no" allowfullscreen="" style="height:100%; min-height: 26rem; width:1px; min-width:100%; margin:0 auto; padding:0; display:block; border:0 none;" class="s2nvcloader"';
				$iframe_url = sprintf( 'http://embed.sendtonews.com/player2/embedplayer.php?type=full&amp;fk=%s&amp;cid=4661', $this->send_to_news_embeds[ $media_type ] );
				$markup     = sprintf( $template, 's2nIframe-' . $this->send_to_news_embeds[ $media_type ] . '-' . $this->post->ID, $iframe_url, $styles );
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