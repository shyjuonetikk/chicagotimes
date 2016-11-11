<?php
class CST_AMP_Related_Posts_Embed extends AMP_Base_Embed_Handler {

	private $section_name;
	private $chart_beat_slug;

	public function register_embed() {
		// If we have an existing callback we are overriding, remove it.
//		remove_filter( 'the_content', 'xyz_add_related_posts' );

		// Add our new callback
		add_filter( 'the_content', array( $this, 'cst_amp_add_related_posts' ) );
	}

	public function unregister_embed() {
		// Let's clean up after ourselves, just in case.
//		add_filter( 'the_content', 'xyz_add_related_posts' );
		remove_filter( 'the_content', array( $this, 'cst_amp_add_related_posts' ) );
	}

	public function get_scripts() {
		return array( 'amp-mustache' => 'https://cdn.ampproject.org/v0/amp-mustache-0.1.js' );
	}

	/**
	 * @return array|bool
	 * Get cached or live Chartbeat data from Chartbeat API
	 */
	function get_chartbeat_data() {

		$chart_beat_url = $this->get_chartbeat_url();
		$cache_key = md5( $chart_beat_url );
		$result    = wp_cache_get( $cache_key, 'default' ); //VIP: for some reason fetch_feed is not caching this properly.
		if ( false === $result ) {
			$response = wpcom_vip_file_get_contents( $chart_beat_url );
			if ( ! is_wp_error( $response ) ) {
				$result = json_decode( $response );
				wp_cache_set( $cache_key, $result, 'default', 5 * MINUTE_IN_SECONDS );
			}
		}
		if ( ! empty( $result->pages ) ) {
			return $result->pages;
		}

		return false;
	}

	/**
	 * @return string
	 *
	 * Calculate and return Chartbeat API url
	 */
	private function get_chartbeat_url() {

		$obj = \CST\Objects\Post::get_by_post_id( get_the_ID() );
		$post_sections  = $obj->get_section_slugs();
		if ( $post_sections ) {
			if ( in_array( 'dear-abby', $post_sections, true ) || in_array( 'dear-abby-lifestyles', $post_sections, true ) ) {
				$this->chart_beat_slug = 'dear%20abby';
				$this->section_name   = 'Dear Abby';
			} else {
				$primary_section = $obj->get_primary_parent_section();
				$this->section_name    = $primary_section->name;
				$this->chart_beat_slug  = $primary_section->slug;
				if ( 'news' === $this->chart_beat_slug ) {
					$this->chart_beat_slug = 'chicago%20news';
				}
			}
		}
		$chart_beat_url = 'http://api.chartbeat.com/live/toppages/v3/?apikey=' . CST_CHARTBEAT_API_KEY . '&host=chicago.suntimes.com&section=' . $this->chart_beat_slug . '&sort_by=returning&now_on=1&limit=4&metrics=post_id';
		return $chart_beat_url;
	}

	/**
	 * @param $content
	 *
	 * @return string
	 *
	 * Get, build and return markup for Chartbeat popular content from their API
	 */
	public function cst_amp_add_related_posts( $content ) {
		$pages = $this->get_chartbeat_data();
		$recommended_article_block = '';
		if ( ! empty( $pages ) ) {
		$recommended_article_block_title = AMP_HTML_Utils::build_tag(
			'div',
			array(
			'class' => 'cst-recommendations',
			), AMP_HTML_Utils::build_tag(
			'h3',
				array(),
				esc_html( 'Previously from ' . $this->section_name )
			) );
		$recommended_article_block = $recommended_article_block_title;
			foreach ( $pages as $item ) {
				$chart_beat_top_content = (array) $item->metrics->post_id->top;
				if ( ! empty( $chart_beat_top_content ) && is_array( $chart_beat_top_content ) ) {
					$vals = array_values( array_flip( $chart_beat_top_content ) );
				}
				$image_url = $this->get_featured_image( $vals[0] );
				$temporary_title = explode( '|', $item->title );
				$recommended_article_curated_title = $temporary_title[0];
				$recommended_article_anchor_image = AMP_HTML_Utils::build_tag(
					'a',
					array(
						'class' => 'cst-rec-anchor',
						'href' => esc_url( $item->path ),
						'title' => esc_html( $recommended_article_curated_title ),
					), AMP_HTML_Utils::build_tag(
					'amp-img',
					array(
						'class' => 'cst-recommended-image',
						'src' => esc_url( $image_url ),
						'width' => 100,
						'height' => 65,
					)
				)
				);
				$recommended_article_anchor_text_link = AMP_HTML_Utils::build_tag(
					'a',
					array(
						'class' => 'cst-rec-anchor',
						'href' => esc_url( $item->path ),
						'title' => esc_html( $recommended_article_curated_title ),
					), AMP_HTML_Utils::build_tag(
						'span',
					array(),
					esc_html( $recommended_article_curated_title )
				)
				);

				$recommended_article_block .= AMP_HTML_Utils::build_tag(
					'div',
					array( 'class'=>'cst-recommended-content' ),
					AMP_HTML_Utils::build_tag(
						'div',
						array(
							'class'  => 'cst-article',
						),
						$recommended_article_anchor_image . $recommended_article_anchor_text_link
					)  );
			}
		}

		return $content . $recommended_article_block;
	}

	/**
	 * @param $post_id
	 *
	 * @return bool|string
	 *
	 * Use WordPress(.com) REST API to retrieve featured image url
	 */
	private function get_featured_image( $post_id ) {
		$featured_image_url = false;
		$remote_url = sprintf( 'https://public-api.wordpress.com/rest/v1.1/sites/suntimesmedia.wordpress.com/posts/%d?post_type=cst_article', $post_id );
		$response = wpcom_vip_file_get_contents( $remote_url );
		if ( ! is_wp_error( $response ) ) {
			$pages = json_decode( $response );
			$featured_image_url = $pages->featured_image . '?w=100';
		}
		return $featured_image_url;
	}
}