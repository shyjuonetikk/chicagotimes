<?php

/**
 * Class CST_Homepage_Headlines_Widget
 *
 * Version 3
 *
 */

class CST_Homepage_Headlines_Widget extends WP_Widget {

	private $hero_headlines = array(
		'cst_homepage_headlines_one' => true,
		'cst_homepage_headlines_two' => true,
		'cst_homepage_headlines_three' => true,
	);
	private $mini_headlines = array(
		'cst_homepage_mini_headlines_one' => true,
		'cst_homepage_mini_headlines_two' => true,
		'cst_homepage_mini_headlines_three' => true,
		'cst_homepage_mini_headlines_four' => true,
		'cst_homepage_mini_headlines_five' => true,
	);
	private $five_story_block_headlines = array(
		'cst_homepage_story_block_headlines_one' => true,
		'cst_homepage_story_block_headlines_two' => true,
		'cst_homepage_story_block_headlines_three' => true,
		'cst_homepage_story_block_headlines_four' => true,
		'cst_homepage_story_block_headlines_five' => true,
	);
	private $hero_related = array(
		'cst_homepage_hero_related_one' => true,
		'cst_homepage_hero_related_two' => true,
		'cst_homepage_hero_related_three' => true,
	);

	private $cache_key_stub;

	public function __construct() {
		parent::__construct(
			'cst_homepage_headlines',
			esc_html__( 'CST! Homepage Main Headline Posts', 'chicagosuntimes' ),
			array(
				'description' => esc_html__( 'Displays Home/Section from selected Headlines.', 'chicagosuntimes' ),
				'customize_selective_refresh' => true,
			)
		);
		$this->cache_key_stub = 'homepage-headlines-widget';
		add_action( 'wp_ajax_cst_homepage_headlines_get_posts', array( $this, 'cst_homepage_headlines_get_posts' ) );
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}
	}

	/**
	 * Get all published posts to display in Select2 dropdown
	 */
	public function cst_homepage_headlines_get_posts() {

		if ( ! wp_verify_nonce( $_GET['nonce'], 'cst_homepage_headlines' )
			 || ! current_user_can( 'edit_others_posts' ) ) {
			wp_send_json_error();
		}

		$term = sanitize_text_field( $_GET['searchTerm'] );

		$search_args = array(
			'post_type'		=> array( 'cst_article', 'cst_feature', 'cst_embed', 'cst_link', 'cst_gallery' ),
			's'				=> $term,
			'post_status'   => 'publish',
			'no_found_rows'	=> true,
		);

		$search_query = new WP_Query( $search_args );

		$returning = array();
		$posts = array();

		if ( '' !== $term && strlen( $term ) >= 3 && $search_query->have_posts() ):

			while ( $search_query->have_posts() ) : $search_query->the_post();
				$obj = get_post( get_the_ID() );
				if ( $obj ) {
					$content_type = get_post_type( $obj->ID );
					$posts['id'] = get_the_ID();
					$posts['text'] = $obj->post_title . ' [' . $content_type . ']';
					array_push( $returning, $posts );
				}

			endwhile;
		endif;

		echo json_encode( $returning );
		exit();

	}

	public function enqueue_scripts() {

		wp_enqueue_script( 'cst_homepage_headlines', get_template_directory_uri() . '/assets/js/cst-homepage-headlines.js', array( 'jquery-ui-sortable', 'jquery' ) );
		wp_localize_script( 'cst_homepage_headlines', 'CSTCategoryHeadlinesData', array(
			'placeholder_text'	=> esc_html__( 'Choose article', 'chicagosuntimes' ),
			'nonce'				=> wp_create_nonce( 'cst_homepage_headlines' ),
		) );
		wp_enqueue_style( 'select2', get_template_directory_uri() . '/assets/js/vendor/select2/select2.css' );
		wp_enqueue_script( 'select2', get_template_directory_uri() . '/assets/js/vendor/select2/select2.min.js' );
		wp_enqueue_style( 'dashicons' );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {

		global $homepage_main_well_posts;
		$widget_posts = array();

		// @TODO need to parse instance to part out $hero_headlines and other variables
		$article_map = array();
		foreach ( $this->hero_headlines as $hero_headline => $value ) {
			$article_id = isset( $instance[$hero_headline] ) ? intval( $instance[$hero_headline] ) : 0;
			if ( $article_id ) {
				$widget_posts[] = $article_id;
				$article_map[$hero_headline] = $article_id;
			}
		}
		foreach ( $this->mini_headlines as $mini_headline => $value ) {
			$article_id = isset( $instance[$mini_headline] ) ? intval( $instance[$mini_headline] ) : 0;
			if ( $article_id ) {
				$widget_posts[] = $article_id;
				$article_map[$mini_headline] = $article_id;
			}
		}
		foreach ( $this->hero_related as $hero_related_headline => $value ) {
			$article_id = isset( $instance[$hero_related_headline] ) ? intval( $instance[$hero_related_headline] ) : 0;
			if ( $article_id ) {
				$widget_posts[] = $article_id;
				$article_map[$hero_related_headline] = $article_id;
			}
		}
		foreach ( $this->five_story_block_headlines as $five_story_block_headlines => $value ) {
			$article_id = isset( $instance[$five_story_block_headlines] ) ? intval( $instance[$five_story_block_headlines] ) : 0;
			if ( $article_id ) {
				$widget_posts[] = $article_id;
				$article_map[$five_story_block_headlines] = $article_id;
			}
		}
		if ( ! empty( $widget_posts ) ) {
			$this->widget_markup( $article_map, $instance );
		}

	}

	/**
	 * @param array $widget_posts Array of integers representing post ids
	 * @return array Of found posts
	 *
	 */
	public function get_headline_posts( $widget_posts ) {
		if ( false === ( $found = wpcom_vip_cache_get( $this->cache_key_stub ) ) ) {
			$widget_posts_query = array(
				'post__in' => $widget_posts,
				'post_type' => 'any',
				'orderby'	=> 'post__in',
				'ignore_sticky_posts' => true,
				'no_found_rows' => true,
			);
			$display_these_posts = new \WP_Query( $widget_posts_query );
			$display_these_posts->have_posts();
			$found = $display_these_posts->get_posts();
			wpcom_vip_cache_set( $this->cache_key_stub, $found, '', 1 * HOUR_IN_SECONDS );
		}

		return $found;
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 * @return array
	 */

	public function form( $instance ) {
		$this->enqueue_scripts();
		if ( ! empty( $instance ) ) {
			$count = 0;
			$width = is_customize_preview() ? 'width:250px;' : 'width:400px;';
			?>
			<h3>Hero Story and 2 leads</h3>
			<h4>Featured image included in certain layouts</h4>
			<div id="widget-lead-stories">
			<?php
			foreach ( $this->hero_headlines as $key => $array_member ) {
				$headline = ! empty( $instance[ $key ] ) ? $instance[ $key ] : '';
				$obj = get_post( $headline );
				if ( $obj ) {
					$content_type = get_post_type( $obj->ID );
					$story_title = $obj->post_title . ' [' . $content_type . ']';
				} else {
					$story_title = '';
				}
				$dashed_key = preg_replace( '/_/', '-', $key );
				?>
				<p class="ui-state-default" id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>">
					<label for="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>">
						<?php esc_html_e( $key, 'chicagosuntimes' ); ?>
					</label>
					<input class="<?php echo esc_attr( $dashed_key ); ?>" id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>" value="<?php echo esc_attr( $headline ); ?>" data-story-title="<?php echo esc_attr( $story_title ); ?>" style="<?php echo esc_attr( $width ); ?>"/>
				</p>
				<?php
				if ( 0 === $count ) { ?>
					<p>
						<label for="<?php echo esc_attr( $this->get_field_name( 'related-posts' ) ); ?>">
							Select related stories to hero?
							<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'related-posts' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'related-posts' ) ); ?>"
								   value="1" <?php checked( $instance['related-posts'], 1 ); ?>/>
						</label>
					</p>
					<?php if ( 1 === $instance['related-posts'] ) { ?>
						<div class="related-posts">
						<?php foreach ( $this->hero_related as $related_key => $hero_parameter ) {
							$headline = ! empty( $instance[ $related_key ] ) ? $instance[ $related_key ] : '';
							$obj      = get_post( $headline );
							if ( $obj ) {
								$content_type = get_post_type( $obj->ID );
								$story_title  = $obj->post_title . ' [' . $content_type . ']';
							} else {
								$story_title = '';
							}
							$dashed_key = preg_replace( '/_/', '-', $key );
							?>
							<p class="ui-state-default">
								<label for="<?php echo esc_attr( $this->get_field_name( $related_key ) ); ?>">
									<em>Related stories</em>
								</label>
								<input class="<?php echo esc_attr( $dashed_key ); ?>" id="<?php echo esc_attr( $this->get_field_id( $related_key ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $related_key ) ); ?>"
									   value="<?php echo esc_attr( $headline ); ?>" data-story-title="<?php echo esc_attr( $story_title ); ?>" style="<?php echo esc_attr( $width ); ?>"/>
							</p>
							<?php
						}
						?></div><?php
					}
				}
				$count++;
			}
			?>
			</div><!-- /#widget-lead-stories -->
			<hr>
			<h3>Other stories 1 above 2x2</h3>
			<small>5 slottable stories - featured image included</small>
			<div id="widget-other-stories">
			<?php
			foreach ( $this->mini_headlines as $key => $array_member ) {
				$headline = ! empty( $instance[ $key ] ) ? $instance[ $key ] : '';
				$obj = get_post( $headline );
				if ( $obj ) {
					$content_type = get_post_type( $obj->ID );
					$story_title = $obj->post_title . ' [' . $content_type . ']';
				} else {
					$story_title = '';
				}
				$dashed_key = preg_replace( '/_/', '-', $key );
				?>
				<p class="ui-state-default" id="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>">
					<label for="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>">
						<?php esc_html_e( $key, 'chicagosuntimes' ); ?>
					</label>
					<input class="<?php echo esc_attr( $dashed_key ); ?>" id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>" value="<?php echo esc_attr( $headline ); ?>" data-story-title="<?php echo esc_attr( $story_title ); ?>" style="<?php echo esc_attr( $width ); ?>"/>
				</p>
				<?php
			} ?>
			</div><!-- /#widget-other-stories -->
			<hr>
			<h3>Other section stories 1 beside 2x2</h3>
			<small>Featured image included</small>
			<h4>Choose section heading:</h4>
			<div id="widget-five-block">
			<?php $sections = get_terms( 'cst_section', array( 'parent' => 0 ) ); ?>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'other_section_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'other_section_title' ) ); ?>">
				<?php if ( ! empty( $sections ) && ! is_wp_error( $sections ) ) : ?>
				<?php foreach( $sections as $section ) : ?>
						<option <?php selected( $section->slug == $instance['other_section_title'] ) ?> value="<?php echo esc_attr( $section->slug . ':' . $section->term_id ); ?>"><?php echo esc_html( $section->name ); ?></option>
				<?php endforeach; ?>
				<?php endif; ?>
			</select>
			<?php foreach ( $this->five_story_block_headlines as $key => $array_member ) {
				$headline = ! empty( $instance[ $key ] ) ? $instance[ $key ] : '';
				$obj = get_post( $headline );
				if ( $obj ) {
					$content_type = get_post_type( $obj->ID );
					$story_title = $obj->post_title . ' [' . $content_type . ']';
				} else {
					$story_title = '';
				}
				$dashed_key = preg_replace( '/_/', '-', $key );
				?>
				<p class="ui-state-default" id="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>">
					<label for="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>">
						<?php esc_html_e( $key, 'chicagosuntimes' ); ?>
					</label>
					<input class="<?php echo esc_attr( $dashed_key ); ?>" id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>" value="<?php echo esc_attr( $headline ); ?>" data-story-title="<?php echo esc_attr( $story_title ); ?>" style="<?php echo esc_attr( $width ); ?>"/>
				</p>
				<?php
			}
			?></div><!-- /#widget-five-block -->
			<?php
		} // empty $instance
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		// @TODO need to parse instance to match $hero_headlines etc and save accordingly
		$instance['related-posts'] = isset( $new_instance['related-posts'] ) ? 1 : 0;
		foreach ( $this->hero_headlines as $hero_headline => $value ) {
			$instance[$hero_headline] = isset( $new_instance[$hero_headline] ) ? intval( $new_instance[$hero_headline] ) : 0;
		}
		foreach ( $this->mini_headlines as $mini_headline => $value ) {
			$instance[$mini_headline] = isset( $new_instance[$mini_headline] ) ? intval( $new_instance[$mini_headline] ) : 0;
		}
		foreach ( $this->hero_related as $hero_related_headline => $value ) {
			$instance[$hero_related_headline] = isset( $new_instance[$hero_related_headline] ) ? intval( $new_instance[$hero_related_headline] ) : 0;
		}
		foreach ( $this->five_story_block_headlines as $five_story_block_headline => $value ) {
			$instance[$five_story_block_headline] = isset( $new_instance[$five_story_block_headline] ) ? intval( $new_instance[$five_story_block_headline] ) : 0;
		}
		$temp_section = isset( $new_instance['other_section_title'] ) ? $new_instance['other_section_title'] : '';
		$section_info = explode( ':', $temp_section );
		$instance['other_section_title'] = isset( $section_info[0] ) ? $section_info[0] : '';
		$instance['other_section_id'] = isset( $section_info[1] ) ? $section_info[1] : '';
//		$total = count( $new_instance );
//		for ( $count = 0; $count < $total; $count++ ) {
//			$instance[] = intval( array_shift( $new_instance ) );
//		}
		wp_cache_delete( $this->cache_key_stub );
		return $instance;
	}

	/**
	 * @param $article_map array
	 * @param $instance array
	 */
	public function widget_markup( $article_map, $instance ) {
	// @TODO Review parameters, error check etc
	// We have post ids in $article_map
	// If we can select the post object and pass only that to the story function that might
	// save a post retrieval / lookup
	// Currently we pass the ID and it is looked up again within the story function.
	// @TODO caching
?>
<div class="row stories-container">
	<div class="columns small-12 medium-8 large-9 stories">
		<div class="row" data-equalizer-mq="large-up">
			<div class="columns small-12 large-4 lead-stories" id="hp-main-lead">
				<?php $this->homepage_hero_story( $article_map['cst_homepage_headlines_one'], $instance ); ?>
				<?php $this->homepage_lead_story( $article_map['cst_homepage_headlines_two'] ); ?>
				<?php $this->homepage_lead_story( $article_map['cst_homepage_headlines_three'] ); ?>
			<div class="show-for-large-up">
				<?php CST()->frontend->inject_newsletter_signup( 'news' ); ?>
			</div>
		</div><!-- /hp-main-lead -->
		<div class="columns small-12 large-8 other-lead-stories">
			<div class="show-for-medium-only"><h3>In other news</h3></div>
			<div id="hp-other-lead">
			<div class="row lead-mini-story">
				<?php
				$obj = \CST\Objects\Post::get_by_post_id( $article_map['cst_homepage_mini_headlines_one'] );
				if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
					$author          = CST()->frontend->hp_get_article_authors( $obj );
					$this->homepage_mini_story_lead( $obj, $author );
				}
				?>
			</div>
			<hr>
			<?php
			CST()->frontend->mini_stories_content_block( array(
				$article_map['cst_homepage_mini_headlines_two'],
				$article_map['cst_homepage_mini_headlines_three'],
				$article_map['cst_homepage_mini_headlines_four'],
				$article_map['cst_homepage_mini_headlines_five'],
			) ); ?>
			</div><!-- hp-other-lead -->
			<div class="other-stories show-for-large-up">
			<?php if ( ! $this->is_preview() ) { // @TODO Selective display / render as this seems to trip up customizer ?>
				<hr>
				<h2>Trending in the Chicago Sun-Times (Chartbeat)</h2>
				<div id="root"></div>
				<script type="text/javascript" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/js/main.641bf377.js"></script>
			<?php } ?>
			</div>
			<div class="other-stories hide-for-xlarge-up">
			<h3>Hello</h3>
			<ul>
				<li>Please</li>
				<li>Fill</li>
				<li>me</li>
				<li>up</li>
				<li>with content</li>
				</ul>
			</div>
		</div>
		<div class="small-12 columns more-stories-container" id="hp-section-lead">
		<h3 class="more-sub-head">
		<?php
			$section_link_url = wpcom_vip_get_term_link( intval( $instance['other_section_id'] ) );
			if ( ! is_wp_error( $section_link_url ) ) {
				echo '<a href="' . esc_url( $section_link_url ) . '">' . esc_html( $instance['other_section_title'] ) . '</a>';
			} else {
				echo esc_html( $instance['other_section_title'] );
			}
		?>
		</h3>
			<?php
			$items = array();
			foreach ( $this->five_story_block_headlines as $five_story_block_headline => $value ) {
				$items[ $five_story_block_headline ] = array_key_exists( $five_story_block_headline, $article_map ) ? $article_map[ $five_story_block_headline ] : null;
			}
			CST()->frontend->mini_stories_content_block( $items ); ?>
		</div>
		</div>
		<?php if ( get_query_var( 'showads', false ) ) { ?>
			<div class="cst-ad-container"><img src="http://placehold.it/970x90/a0a0d0/130100&amp;text=[nativo]"></div>
		<?php } ?>
		<hr>

	<?php // closing stories in class-cst-homepage-more-headlines-widget
	// Closing div in front-page.php
	}

	/**
	 * @param int $headline
	 * @param array $instance
	 *
	 * Hero story markup generation and display
	 */
	public function homepage_hero_story( $headline, $instance ) {
		$obj = \CST\Objects\Post::get_by_post_id( $headline );
		if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
			$author          = CST()->frontend->hp_get_article_authors( $obj );
		}
		remove_filter( 'the_excerpt', 'wpautop' );
		$story_excerpt = apply_filters( 'the_excerpt', $obj->get_excerpt() );
		add_filter( 'the_excerpt', 'wpautop' );
		?>
		<div class="hero-story">
		<a href="<?php echo esc_url( $obj->the_permalink() ); ?>"  data-on="click" data-event-category="content" data-event-action="navigate-hp-hero-story" >
	<h3 class="hero-title"><?php echo esc_html( $obj->get_title() ); ?></h3>
</a>
	<div class="columns small-12 medium-6 large-12">
		<div class="row">
			<div class="show-for-portrait show-for-touch">
				<a href="<?php echo esc_url( $obj->the_permalink() ); ?>"  data-on="click" data-event-category="content" data-event-action="navigate-hp-hero-story" >
				<span class="image">
				<?php
				$featured_image_id = $obj->get_featured_image_id();
				if ( $featured_image_id ) {
					$attachment = wp_get_attachment_metadata( $featured_image_id );
					if ( $attachment ) {
						$image_markup = get_image_tag( $featured_image_id, $attachment['image_meta']['caption'], '', 'left', 'chiwire-header-medium' );
						echo wp_kses_post( $image_markup );
					}
				}
				?>
				</span></a>
			</div>

	</div>
</div>
<div class="columns small-12 medium-5 medium-offset-1 large-12 large-offset-0">
	<div class="row">
		<a href="<?php echo esc_url( $obj->get_permalink() ); ?>"  data-on="click" data-event-category="content" data-event-action="navigate-hp-hero-story" >
			<p class="excerpt">
				<?php echo wp_kses_post( $story_excerpt ); ?>
			</p>
		</a>
		<p class="authors">By <?php echo wp_kses_post( $author ); ?> - <?php echo esc_html( human_time_diff( strtotime( $obj->get_post_date( 'j F Y g:i a' ) ) ) ); ?> ago</p>
		<div class="show-for-landscape show-for-xlarge-up">
			<?php if ( 1 === $instance['related-posts'] ) {
				$this->handle_related_content( $instance );
			}
			?>
		</div>
	</div>
		<div class="show-for-portrait show-for-large-up">
			<div class="small-12">
				<?php if ( 1 === $instance['related-posts'] ) {
					$this->handle_related_content( $instance );
				} ?>
			</div>
		</div>
</div>
</div>

		<?php
	}

	/**
	 * @param $headline
	 *
	 * The lead stories - each generated by the following function - display below the hero story (see above)
	 */
	public function homepage_lead_story( $headline ) {
		$obj = \CST\Objects\Post::get_by_post_id( $headline );
		if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
			$author          = CST()->frontend->hp_get_article_authors( $obj );
		}
		remove_filter( 'the_excerpt', 'wpautop' );
		$story_excerpt = apply_filters( 'the_excerpt', $obj->get_excerpt() );
		add_filter( 'the_excerpt', 'wpautop' );
		$featured_image_id = $obj->get_featured_image_id();
		if ( $featured_image_id ) {
			$attachment = wp_get_attachment_metadata( $featured_image_id );
			if ( $attachment ) {
				$large_image_markup = get_image_tag( $featured_image_id, $attachment['image_meta']['caption'], '', 'left', 'chiwire-header-medium' );
				$small_image_markup = get_image_tag( $featured_image_id, $attachment['image_meta']['caption'], '', 'left', 'chiwire-small-square' );
			}
		}
		?>
		<div class="lead-story">
<a href="<?php echo esc_url( $obj->the_permalink() ); ?>"  data-on="click" data-event-category="content" data-event-action="navigate-hp-lead-story" >
	<h3 class="title"><?php echo esc_html( $obj->get_title() ); ?></h3>
	<span class="image show-for-landscape hidden-for-medium-up show-for-xlarge-up">
				<?php echo ( false === $attachment ? '' : wp_kses_post( $large_image_markup ) ); ?>
			</span>
	<p class="excerpt">
			<span class="image show-for-large-up show-for-touch">
				<?php echo ( false === $attachment ? '' : wp_kses_post( $small_image_markup ) ); ?>
			</span>
		<?php echo wp_kses_post( $story_excerpt ); ?>
	</p>
</a>
<p class="authors">By <?php echo wp_kses_post( $author ); ?> - <?php echo esc_html( human_time_diff( strtotime( $obj->get_post_date( 'j F Y g:i a' ) ) ) ); ?> ago</p>
		</div>
<?php
	}

	/**
	 * @param $obj
	 * @param $author
	 *
	 * Display the central story, with image and excerpt
	 */
	public function homepage_mini_story_lead( $obj, $author ) {
		remove_filter( 'the_excerpt', 'wpautop' );
		$story_excerpt = apply_filters( 'the_excerpt', $obj->get_excerpt() );
		add_filter( 'the_excerpt', 'wpautop' );
		$featured_image_id = $obj->get_featured_image_id();
		if ( $featured_image_id ) {
			$attachment = wp_get_attachment_metadata( $featured_image_id );
			if ( $attachment ) {
				$large_image_markup = get_image_tag( $featured_image_id, $attachment['image_meta']['caption'], '', 'left', 'secondary-wells' );
			}
		}
?>
<div class="columns small-12">
	<div class="row">
		<div class="columns small-12 medium-6 large-6">
			<a href="<?php echo esc_url( $obj->the_permalink() ); ?>"  data-on="click" data-event-category="content" data-event-action="navigate-hp-lead-mini-story" >
			<span class="image"><?php echo ( false === $attachment ? '' : wp_kses_post( $large_image_markup ) ); ?></span>
			<div class="hide-for-landscape">
				<h3 class="alt-title"><?php echo esc_html( $obj->get_title() ); ?></h3>
			</div>
			</a>
		</div>
		<div class="columns small-12 medium-6 large-6 show-for-landscape">
			<a href="<?php echo esc_url( $obj->the_permalink() ); ?>"  data-on="click" data-event-category="content" data-event-action="navigate-hp-lead-mini-story" >
			<h3 class="alt-title"><?php echo esc_html( $obj->get_title() ); ?></h3>
			</a>
		</div>
		<div class="columns small-12 medium-6 large-6">
			<a href="<?php echo esc_url( $obj->the_permalink() ); ?>"  data-on="click" data-event-category="content" data-event-action="navigate-hp-lead-mini-story" >
			<p class="excerpt"><?php echo wp_kses_post( $story_excerpt ); ?></p>
			</a>
			<p class="authors">By <?php echo wp_kses_post( $author ); ?> - <?php echo esc_html( human_time_diff( strtotime( $obj->get_post_date( 'j F Y g:i a' ) ) ) ); ?> hour ago</p>
		</div>
	</div>
</div>
<?php
	}

	/**
	* @param $instance
	* Determine if any related stories are selected and display in a list
	*/
	public function handle_related_content( $instance ) {
		$related = array_intersect_key( $instance, $this->hero_related );
		$filter_result = array_filter( $related, function( $value ) {
			return 0 !== $value;
		} );
		if ( count( $filter_result ) ) { ?>
		<h3>Related stories:</h3>
		<ul class="related-title">
			<?php foreach( $filter_result as $hero_related => $value ) {
				if ( isset( $instance[$hero_related] ) ) {
					$obj = \CST\Objects\Post::get_by_post_id( $instance[$hero_related] );
					if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) { ?>
						<li><a href="<?php echo esc_url( $obj->get_permalink() ); ?>"  data-on="click" data-event-category="content" data-event-action="navigate-hp-related-story" ><h3><?php echo esc_html( $obj->get_title() ); ?></h3></a>
					<?php } ?>
				<?php } ?>
			<?php } ?>
		</ul>
	<?php }
	}
}
