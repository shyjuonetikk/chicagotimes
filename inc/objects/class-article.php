<?php

namespace CST\Objects;

class Article extends Post {

	protected static $post_type = 'cst_article';
	private $send_to_news_embeds = array(
		'cubs'       => 'uqWfqG2Y',
		'white-sox'  => 'WOOeQ5Jw',
		'bulls'      => 's3AyJdaz',
		'bears'      => 'C30fZO7v',
		'pga-golf'   => '8Owdfvnq',
		'nascar'     => 'hdUJ4uMz',
		'ahl-wolves' => 'dAT6rZV6',
		'college'    => 'IS3jNqMB',
		'rio-2016'   => 'BQ3NYJzd',
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