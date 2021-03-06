<?php
class CST_AMP_Social_Share_Embed extends AMP_Base_Embed_Handler {

	private $cst_amp, $obj;

	public function register_embed() {

		// Add our new callback
		add_filter( 'the_content', array( $this, 'cst_amp_render_share' ) );
	}

	public function unregister_embed() {
		remove_filter( 'the_content', array( $this, 'cst_amp_render_share' ) );
	}

	public function get_scripts() {
		return array( 'amp-social-share' => 'https://cdn.ampproject.org/v0/amp-social-share-0.1.js' );
	}

	/**
	 * @param $content
	 *
	 * @return string
	 *
	 * Build share bar below content, include Twitter, Facebook and original article link
	 */
	public function cst_amp_render_share( $content ) {
		$obj = \CST\Objects\Post::get_by_post_id( get_the_ID() );

		return $content .
			   '<hr>' .
			   AMP_HTML_Utils::build_tag(
				   'div',
				   array(
					   'class' => 'post-meta-social',
				   ),
				   $this->cst_build_twitter_share_element( $obj ) .
				   $this->cst_build_facebook_share_element( $obj ) .
				   $this->cst_build_original_article_link_element( $obj )
			   ) .
			   '<hr>';
	}

	/**
	 * @param $obj
	 *
	 * @return string
	 *
	 * Individual share icon HTML element for Twitter
	 */
	public function cst_build_twitter_share_element( $obj ) {
		return AMP_HTML_Utils::build_tag(
			'amp-social-share',
			array(
				'type' => 'twitter',
				'data-param-url'  => esc_url( $obj->get_share_link() ),
				'data-param-text' => esc_attr( $obj->get_twitter_share_text() ),
				'data-param-via' => esc_attr( CST_TWITTER_USERNAME ),
			)
		);
	}
	/**
	 * @param $obj
	 *
	 * @return string
	 *
	 * Individual share icon HTML element for Facebook
	 */

	public function cst_build_facebook_share_element( $obj ) {
		return AMP_HTML_Utils::build_tag(
			'amp-social-share',
			array(
				'type' => 'facebook',
				'data-param-href'   => esc_url( $obj->get_share_link() ),
				'data-param-app_id' => '1358394680844582',
			)
		);
	}

	/**
	 * @param $obj
	 *
	 * @return string
	 *
	 * Individual share icon HTML element for See original article link
	 */

	public function cst_build_original_article_link_element( $obj ) {

		return AMP_HTML_Utils::build_tag(
			'div',
			array(
				'class' => 'alignright',
			), sprintf( '
<a class="original-story" href="%s" title="See original story">Read original article: 
<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="49" height="48" viewBox="0 -2 40 40">
<path d="M28 8v-4h-28v22c0 1.105 0.895 2 2 2h27c1.657 0 3-1.343 3-3v-17h-4zM26 26h-24v-20h24v20zM4 10h20v2h-20zM16 14h8v2h-8zM16 18h8v2h-8zM16 22h6v2h-6zM4 14h10v10h-10z"></path>
</svg>
</a>', esc_url( get_permalink( $obj->get_id() ) )
			)
		);
	}
}