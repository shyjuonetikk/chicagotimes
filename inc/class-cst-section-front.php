<?php

namespace CST;

class CST_Section_Front {
	private static $instance;

	public $chicago_sports_team_slugs = [
		'cubs-baseball',
		'cubs',
		'white-sox',
		'bulls',
		'bears-football',
		'blackhawks-hockey',
		'blackhawks',
		'fire-soccer',
	];
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

	public function create_partials( $team ) {
		$headlines = [];
		foreach ( \CST_Customizer::get_instance()->five_block as $item ) {
			$headlines['cst_' . sanitize_title( $team ) . '_section_' . $item] = true;
		}
		return $headlines;
	}
	/**
	 * Provide Chicago Sport heading, markup and link to section for homepage
	 * @param $title
	 * @param $term
	 */
	public function heading( $title = '', $term = '' ) {
		$term_link = wpcom_vip_get_term_link( $term,'cst_section' );
		if ( ! is_wp_error( $term_link ) ) { ?>
			<h2 class="more-sub-head"><a href="<?php echo esc_url( $term_link ); ?>"><?php echo esc_html( ucfirst( $title ) ); ?></a></h2>
		<?php }
	}

	/**
	 * @param $title_slug
	 *
	 * Title markup based on slug
	 * Get slotted content based on slug
	 *
	 */
	public function five_block( $title_slug ) {
		?>
		<div class="stories-container">
			<div class="small-12 columns more-stories-container" id="sf-section-lead">
				<hr>
				<?php $this->heading( 'Leading ' . get_queried_object()->name . ' stories', $title_slug ); ?>
				<?php $customizer_partials = $this->create_partials( $title_slug ); ?>
				<?php \CST_Frontend::get_instance()->mini_stories_content_block( $customizer_partials ); ?>
			</div><!-- /five-block -->
		</div>
		<?php
	}
	public function sports_five_block( $headlines ) {
		?>
		<div class="stories-container">
			<div class="small-12 columns more-stories-container" id="sf-section-lead">
				<?php $this->heading( 'Chicago Sports Headlines', 'sports' ); ?>
				<hr>
				<?php \CST_Frontend::get_instance()->mini_stories_content_block( $headlines ); ?>
				<hr>
			</div><!-- /sports-five-block -->
		</div>
		<?php
	}
}