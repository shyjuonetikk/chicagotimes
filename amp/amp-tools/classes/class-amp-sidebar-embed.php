<?php
class CST_AMP_Sidebar_Embed extends AMP_Base_Embed_Handler {

	private $section_name;

	public function register_embed() {
	}

	public function unregister_embed() {
	}

	public function get_scripts() {
		return array( 'amp-sidebar' => 'https://cdn.ampproject.org/v0/amp-sidebar-0.1.js' );
	}

	public function cst_amp_render_sidebar( $content) {

	}
}