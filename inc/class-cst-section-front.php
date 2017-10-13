<?php

namespace CST;

class CST_Section_Front {
	private static $instance;

	public $chicago_sports_team_slugs = [
		'blackhawks-hockey',
		'blackhawks',
		'cubs-baseball',
		'bears',
		'cubs',
		'white-sox',
		'white-sox-baseball',
		'bulls',
		'fire-soccer',
	];
	public $sports_object;
	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new CST_Section_Front;
			self::$instance->setup_actions();
			self::$instance->setup_filters();
			self::$instance->setup_constants();
		}
		return self::$instance;
	}

	public function setup_actions(  ) {

	}

	public function setup_filters(  ) {

	}

	public function setup_constants(  ) {
		$this->sports_object = wpcom_vip_get_term_by( 'name', 'sports', 'cst_section' );
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
	 * Render only if content slotted
	 *
	 */
	public function five_block( $title_slug ) {
		$customizer_partials = $this->create_partials( $title_slug );
		$render = false;
		foreach ( $customizer_partials as $customizer_partial => $value ) {
			if ( get_theme_mod( $customizer_partial ) ) {
				$render = true;
			}
		}
		if ( $customizer_partials && $render ) {
			?>
			<div class="stories-container">
				<div class="small-12 columns more-stories-container" id="sf-section-lead">
					<hr>
					<?php $this->heading( 'Leading ' . get_queried_object()->name . ' stories', $title_slug ); ?>
					<?php \CST_Frontend::get_instance()->mini_stories_content_block( $customizer_partials ); ?>
				</div><!-- /five-block -->
			</div>
			<?php
		}
	}
	public function sports_five_block( $headlines ) {
		?>
		<div class="stories-container">
			<div class="small-12 columns more-stories-container" id="sf-section-lead">
				<?php $this->heading( 'Chicago Sports Headlines', 'sports' ); ?>
				<hr>
				<?php \CST_Frontend::get_instance()->mini_stories_content_block( $headlines ); ?>
			</div><!-- /sports-five-block -->
		</div>
		<?php
	}
	/**
	 * Section front Hero story markup generation and display
	 * Used by the customizer render callback
	 *
	 * @param string $headline
	 */
	public function section_hero_story( $headline ) {
		$obj = Objects\Post::get_by_post_id( get_theme_mod( $headline ) );
		if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
			$author          = \CST_Frontend::get_instance()->hp_get_article_authors( $obj );
			remove_filter( 'the_excerpt', 'wpautop' );
			$story_long_excerpt = apply_filters( 'the_excerpt', $obj->get_long_excerpt() );
			add_filter( 'the_excerpt', 'wpautop' );
			?>
			<div class="hero-story js-<?php echo esc_attr( str_replace( '_', '-', $headline ) ); ?>">
				<a href="<?php echo esc_url( $obj->get_permalink() ); ?>"  data-on="click" data-event-category="content" data-event-action="navigate-sf-hero-story-title" >
					<h3 class="hero-title"><?php echo esc_html( $obj->get_title() ); ?></h3>
				</a>
				<div class="columns small-12 medium-6 large-12">
					<div class="row">
						<div class="hidden-for-large-up">
							<a href="<?php echo esc_url( $obj->get_permalink() ); ?>"  data-on="click" data-event-category="content" data-event-action="navigate-sf-hero-story-image" >
				<span class="image">
				<?php
				$featured_image_id = $obj->get_featured_image_id();
				if ( $featured_image_id ) {
					$attachment = wp_get_attachment_metadata( $featured_image_id );
					if ( $attachment ) {
						$image_markup = get_image_tag( $featured_image_id, $attachment['image_meta']['caption'], '', 'left', 'chiwire-header-small' );
						echo wp_kses_post( $image_markup );
					}
				}
				?>
				</span></a>
						</div>

					</div>
				</div>
				<div class="row">
					<div class="columns small-12 medium-6 large-12 large-offset-0">
						<a href="<?php echo esc_url( $obj->get_permalink() ); ?>"  data-on="click" data-event-category="content" data-event-action="navigate-sf-hero-story-excerpt" >
							<p class="excerpt">
								<?php echo wp_kses_post( $story_long_excerpt ); ?>
							</p>
						</a>
						<?php \CST_Frontend::get_instance()->homepage_byline( $obj, $author ); ?>
					</div>
				</div>
			</div>
			<?php
		}
	}

	/**
	 *
	 * Inject ad markup and script call within section front
	 * @param string $counter
	 */
	public function section_ad_injection( $counter ) {
		$placement          = 'div-gpt-placement-s';
		$ad_template        = '<div class="cst-ad-container sf">%s</div>';
		$mapping            = 'sf_new_inline_mapping';
		$targeting          = 'rr cube 2';
		$every_two = $counter % 2;
		if ( $every_two ) {
			$targeting = 'rr cube 3';
		}
		$ad_unit_definition = CST()->dfp_handler->dynamic_unit(
			$counter,
			esc_attr( $placement ),
			esc_attr( 'dfp-placement' ),
			esc_attr( $mapping ),
			esc_attr( $targeting ),
			''
		);
		echo sprintf(
			wp_kses( $ad_template, [ 'div' => ['class' => [] ] ] ),
			wp_kses( $ad_unit_definition, CST()->dfp_kses )
		);

	}

	/**
	 * @param $id
	 *
	 * @return bool
	 * Determine and return if on a sports or sports child section front
	 */
	public function is_sports_or_child( $id ) {
		return is_tax( 'cst_section', 'sports' ) || term_is_ancestor_of( $this->sports_object, $id, 'cst_section' );
	}
}