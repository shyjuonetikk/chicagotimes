<?php
class CST_AMP_Sidebar_Embed extends AMP_Base_Embed_Handler {

	private $section_name;
	private $chart_beat_slug;

	public function register_embed() {

		// Add our new callback
		add_filter( 'the_content', array( $this, 'cst_amp_render_sidebar' ) );
	}

	public function unregister_embed() {
		remove_filter( 'the_content', array( $this, 'cst_amp_add_sidebar' ) );
	}

	public function get_scripts() {
		return array( 'amp-sidebar' => 'https://cdn.ampproject.org/v0/amp-sidebar-0.1.js' );
	}

	public function cst_amp_render_sidebar( $content ) {
		return $content . AMP_HTML_Utils::build_tag(
			'amp-sidebar',
			array(
				'id'     => 'cst-sidebar',
				'layout' => 'nodisplay',
				'side'   => 'right',
			), AMP_HTML_Utils::build_tag(
			'span',
			array( 'class' => 'close-sidebar' ),
			'&times;'
		)
		);
	}
}