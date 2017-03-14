<?php
class CST_AMP_Public_Good_Embed extends AMP_Base_Embed_Handler {

	public function register_embed() {
		// Add our new callback
		add_filter( 'the_content', array( $this, 'cst_build_public_good_element' ) );
		add_filter( 'cst_amp_after_amp_content', array( $this, 'cst_build_public_good_element' ) );
	}

	public function unregister_embed() {
		remove_filter( 'the_content', array( $this, 'cst_build_public_good_element' ) );
	}

	public function get_scripts() {
		return array( 'amp-iframe' => 'https://cdn.ampproject.org/v0/amp-iframe-0.1.js' );
	}

	/**
	 * @return string
	 *
	 * Individual Public Good button iframe element
	 */

	public function cst_build_public_good_element( $content ) {
		$b = AMP_HTML_Utils::build_tag(
			'iframe',
			array(
				'href'   => esc_url( 'https://assets.pgs.io/button/v2/iframe.html?partner_id=chicago-sun-times' ),
				'target' => '_blank',
				'width' => '212',
				'height' => '50',
				'frameborder' => '0',
				'scrolling' => 'no',
			)
		);
		return $content . AMP_HTML_Utils::build_tag(
			'iframe',
			array(
				'href'   => esc_url( 'https://assets.pgs.io/button/v2/iframe.html?partner_id=chicago-sun-times' ),
				'target' => '_blank',
				'width' => '212',
				'height' => '50',
				'frameborder' => '0',
				'scrolling' => 'no',
			)
		);
	}
}
