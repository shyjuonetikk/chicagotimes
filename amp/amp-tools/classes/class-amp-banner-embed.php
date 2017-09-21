<?php
class CST_AMP_Banner_Embed extends AMP_Base_Embed_Handler {

	private $section_name;

	public function register_embed() {
	}

	public function unregister_embed() {
	}

	public function get_scripts() {
		return array( 'amp-app-banner' => 'https://cdn.ampproject.org/v0/amp-app-banner-0.1.js' );
	}

}