<?php

namespace CST;

class CST_Section_Front {
	private static $instance;

	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new CST_Section_Front;
			self::$instance->setup_actions();
			self::$instance->setup_filters();
		}
		return self::$instance;
	}

	public function setup_actions(  ) {

	}

	public function setup_filters(  ) {

	}

	public function create_headline_link( $team ) {
		$headlines = [];
		foreach ( \CST_Customizer::get_instance()->five_block as $item ) {
			$headlines['cst_' . sanitize_title( $team ) . '_section_' . $item] = true;
		}
		return $headlines;
	}
	/**
	 * Provide Chicago Sport heading, markup and link to section for homepage
	 * @param $team
	 */
	public function sports_heading( $team = 'Chicago Sports' ) {
		$sports_term = wpcom_vip_get_term_link( $team,'cst_section' );
		if ( ! is_wp_error( $sports_term ) ) { ?>
			<h2 class="more-sub-head"><a href="<?php echo esc_url( $sports_term ); ?>"><?php echo esc_html( ucfirst( $team ) ); ?></a></h2>
		<?php }
	}

	public function five_block( $team ) {
		?>
		<div class="stories-container">
			<div class="small-12 columns more-stories-container" id="sf-section-lead">
				<hr>
				<?php $this->sports_heading( $team ); ?>
				<?php $headlines = $this->create_headline_link( $team ); ?>
				<?php \CST_Frontend::get_instance()->mini_stories_content_block( $headlines ); ?>
			</div><!-- /#sf-section-lead -->
		</div>
		<?php
	}
}