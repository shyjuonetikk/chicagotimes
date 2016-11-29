<?php
class CST_AMP_Social_Share_Embed extends AMP_Base_Embed_Handler {

	private $cst_amp, $obj;


	public function sanitize() {
		$this->cst_amp = CST_AMP::get_instance();
		$post = get_post();
		$this->obj = new CST\Objects\Article( $post->ID );
	}
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

	public function cst_amp_render_share( $content ) {
		return $content . AMP_HTML_Utils::build_tag(
			'amp-social-share',
			array(
				'url'  => $this->obj->get_twitter_share_url(),
			)
		);
	}
}