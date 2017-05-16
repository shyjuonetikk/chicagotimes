<?php

/**
 * Class CST_Homepage_More_Headlines_Widget
 *
 * Version 2
 *
 */
class CST_Homepage_More_Headlines_Widget extends WP_Widget {

	private $headlines = array(
		'cst_homepage_more_headlines_one',
		'cst_homepage_more_headlines_two',
		'cst_homepage_more_headlines_three',
		'cst_homepage_more_headlines_four',
		'cst_homepage_more_headlines_five',
		'cst_homepage_more_headlines_six',
		'cst_homepage_more_headlines_seven',
		'cst_homepage_more_headlines_eight',
		'cst_homepage_more_headlines_nine',
		'cst_homepage_more_headlines_ten',
	);

	private $titles = array(
		'Headline One',
		'Headline Two',
		'Headline Three',
		'Headline Four',
		'Headline Five',
		'Headline Six',
		'Headline Seven',
		'Headline Eight',
		'Headline Nine',
		'Headline Ten',
	);
	private $five_story_block_headlines = array(
		'cst_homepage_story_block_headlines_one' => true,
		'cst_homepage_story_block_headlines_two' => true,
		'cst_homepage_story_block_headlines_three' => true,
		'cst_homepage_story_block_headlines_four' => true,
		'cst_homepage_story_block_headlines_five' => true,
	);
	private $featured_story_block_headlines = array(
		'featured_story_block_headlines_one' => true,
		'featured_story_block_headlines_two' => true,
		'featured_story_block_headlines_three' => true,
		'featured_story_block_headlines_four' => true,
		'featured_story_block_headlines_five' => true,
	);
	private $cache_key_stub;

	public function __construct() {
		parent::__construct(
			'cst_homepage_more_headlines',
			esc_html__( 'CST! Homepage/RR More Headlines', 'chicagosuntimes' ),
			array(
				'description' => esc_html__( 'Displays More Headlines - homepage/sidebar.', 'chicagosuntimes' ),
				'customize_selective_refresh' => true,
			)
		);
		$this->cache_key_stub = 'homepage-more-headlines-widget';
		add_action( 'wp_ajax_cst_homepage_more_headlines_get_posts', array( $this, 'cst_homepage_more_headlines_get_posts' ) );
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}
	}

	/**
	 * Get all published posts to display in Select2 dropdown
	 */
	public function cst_homepage_more_headlines_get_posts() {

		if ( ! wp_verify_nonce( $_GET['nonce'], 'cst_homepage_more_headlines' )
			 || ! current_user_can( 'edit_others_posts' )
		) {
			wp_send_json_error();
		}

		$term = sanitize_text_field( $_GET['searchTerm'] );

		$search_args = array(
			'post_type'     => array( 'cst_article', 'cst_embed', 'cst_link', 'cst_gallery', 'cst_feature' ),
			's'             => $term,
			'post_status'   => 'publish',
			'no_found_rows' => true,
		);

		$search_query = new WP_Query( $search_args );

		$returning = array();
		$posts     = array();

		if ( $search_query->have_posts() ) :

			while ( $search_query->have_posts() ) : $search_query->the_post();
				$obj = get_post( get_the_ID() );
				if ( $obj ) {
					$content_type  = get_post_type( $obj->ID );
					$posts['id']   = get_the_ID();
					$posts['text'] = $obj->post_title . ' [' . $content_type . ']';
					array_push( $returning, $posts );
				}

			endwhile;
		endif;

		echo json_encode( $returning );
		exit();

	}

	public function enqueue_scripts() {

		wp_enqueue_script( 'cst_homepage_more_headlines', get_template_directory_uri() . '/assets/js/cst-homepage-more-headlines.js', array( 'jquery' ) );
		wp_localize_script( 'cst_homepage_more_headlines', 'CSTMoreHeadlinesData', array(
			'placeholder_text' => esc_html__( 'Search for content to feature', 'chicagosuntimes' ),
			'nonce'            => wp_create_nonce( 'cst_homepage_more_headlines' ),
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

		global $homepage_more_well_posts;
		$widget_posts = array();
		$article_map = array();

		foreach ( $this->headlines as $headline => $value ) {
			$article_id = isset( $instance[$headline] ) ? intval( $instance[$headline] ) : 0;
			if ( $article_id ) {
				$widget_posts[] = $article_id;
				$article_map[$headline] = $article_id;
			}
		}
		foreach ( $this->five_story_block_headlines as $five_story_block_headlines => $value ) {
			$article_id = isset( $instance[$five_story_block_headlines] ) ? intval( $instance[$five_story_block_headlines] ) : 0;
			if ( $article_id ) {
				$widget_posts[] = $article_id;
				$article_map[$five_story_block_headlines] = $article_id;
			}
		}
		foreach ( $this->featured_story_block_headlines as $featured_story_block_headlines => $value ) {
			$article_id = isset( $instance[$featured_story_block_headlines] ) ? intval( $instance[$featured_story_block_headlines] ) : 0;
			if ( $article_id ) {
				$widget_posts[] = $article_id;
				$article_map[$featured_story_block_headlines] = $article_id;
			}
		}
		if ( ! empty( $widget_posts ) ) {

			$query  = array(
				'post__in'            => $widget_posts,
				'post_type'           => 'any',
				'orderby'             => 'post__in',
				'ignore_sticky_posts' => true,
				'no_found_rows'       => true,
			);
			$sidebar_style = isset( $instance[ 'sidebar-style' ] ) ? intval( $instance[ 'sidebar-style' ] ) : 0;
			if ( $sidebar_style ) {
				$this->more_top_stories_block( $query, $instance['title'], 'sidebar-style' );
			} else {
				$this->more_stories_content( $query, $article_map, $instance );
			}
		}

	}

	/**
	 * @param array $widget_posts Array of integers representing post ids
	 *
	 * @return array Of found posts
	 *
	 */
	public function get_headline_posts( $widget_posts ) {

		if ( false === ( $found = wpcom_vip_cache_get( $this->cache_key_stub ) ) ) {

			$widget_posts_query  = array(
				'post__in'            => $widget_posts,
				'post_type'           => 'any',
				'orderby'             => 'post__in',
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
	 *
	 * @return array
	 */
	public function form( $instance ) {

		$this->enqueue_scripts();
		$width = is_customize_preview() ? 'width:250px;' : 'width:400px;';
		if ( ! isset( $instance['sidebar-style'] ) ) {
			$instance['sidebar-style'] = 0;
		}
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_name( 'sidebar-style' ) ); ?>">
				<h4>Check to use as Right Rail version&nbsp;(will only show ten slottable stories)
				<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'sidebar-style' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'sidebar-style' ) ); ?>"
					   value="1" <?php checked( $instance['sidebar-style'], 1 ); ?>/>
				</h4>
			</label>
		</p>
		<?php if ( 1 === $instance['sidebar-style'] ) { ?>
			<p>
			<label for="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>">
				<h4>Please enter a title?&nbsp;
				<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
					   value="<?php echo esc_attr( $instance['title'] ); ?>" placeholder="Type custom title"/>
				</h4>
			</label>
			</p><?php
		} else {
			?><h3>More Top Stories</h3><?php
		}?>
		<h4>Choose ten slottable stories</h4>
		<p class="cst-headline-sort ui-sortable">
			<?php
			foreach ( $this->headlines as $key => $array_member ) {
				$headline = ! empty( $instance[ $key ] ) ? $instance[ $key ] : '';
				$obj      = get_post( $headline );
				if ( $obj ) {
					$content_type = get_post_type( $obj->ID );
					$story_title  = $obj->post_title . ' [' . $content_type . ']';
				} else {
					$story_title = '';
				}
				$dashed_key = preg_replace( '/_/', '-', $array_member );
				?>
				<p class="ui-state-default" id=<?php echo esc_attr( $key ); ?>>
					<label for="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>"><span class="dashicons dashicons-sort"></span><?php esc_html_e( $this->titles[ $key ], 'chicagosuntimes' ); ?></label>
					<input class="<?php echo esc_attr( $dashed_key ); ?>" id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>"
						   value="<?php echo esc_attr( $headline ); ?>" data-story-title="<?php echo esc_attr( $story_title ); ?>" style="<?php echo esc_attr( $width ); ?>"/>
				</p>
				<?php
			}?>
		</p>
		<?php if ( isset( $instance['sidebar-style'] ) && 0 === $instance['sidebar-style'] ) { ?>
			<hr>
			<h3>Featured story block</h3>
			<small>5 slottable stories - featured image included</small>
			<?php foreach ( $this->featured_story_block_headlines as $key => $array_member ) {
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
			<hr>
			<h3>Other section stories 1 beside 2x2</h3>
			<small>5 slottable stories - featured image included</small>
			<h4>Choose section heading:</h4>
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
		}

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
		// @TODO caching
		$instance['sidebar-style'] = isset( $new_instance['sidebar-style'] ) ? 1 : 0;
		$instance['title'] = isset( $new_instance['title'] ) ? $new_instance['title'] : false;
		foreach ( $this->headlines as $headline => $value ) {
			$instance[$headline] = isset( $new_instance[$headline] ) ? intval( $new_instance[$headline] ) : 0;
		}
		foreach ( $this->five_story_block_headlines as $five_story_block_headline => $value ) {
			$instance[$five_story_block_headline] = isset( $new_instance[$five_story_block_headline] ) ? intval( $new_instance[$five_story_block_headline] ) : 0;
		}
		foreach ( $this->featured_story_block_headlines as $featured_story_block_headline => $value ) {
			$instance[$featured_story_block_headline] = isset( $new_instance[$featured_story_block_headline] ) ? intval( $new_instance[$featured_story_block_headline] ) : 0;
		}
		$temp_section = isset( $new_instance['other_section_title'] ) ? $new_instance['other_section_title'] : '';
		$section_info = explode( ':', $temp_section );
		$instance['other_section_title'] = isset( $section_info[0] ) ? $section_info[0] : '';
		$instance['other_section_id'] = isset( $section_info[1] ) ? $section_info[1] : '';
		wp_cache_delete( $this->cache_key_stub );

		return $instance;
	}

	/**
	 * @param $query
	 * @param $article_map
	 * @param $instance
	 *
	 * Display full widget top stories link, Featured Story and featured stories block too
	 * And display a section with slotted content below
	 */
	public function more_stories_content( $query, $article_map, $instance ) {
		add_filter( 'get_image_tag_class', function( $class ) {
			$class .= ' featured-story-hero';
			return $class;
		} );
		?>
		<div class="row more-stories-container">
			<div class="columns small-12">
				<div class="row">
					<?php $this->more_top_stories_block( $query, 'More Top Stories', 'normal-style' ); ?>
					<div class="columns small-12 medium-6 large-8">
						<div class="small-12 columns" id="featured-stories">
							<div class="row">
								<h3 class="more-sub-head"><a href="<?php echo esc_url( home_url( '/' ) ); ?>features/"></a>Featured story</h3>
								<div class="featured-story">
									<?php
									$obj = \CST\Objects\Post::get_by_post_id( $article_map['featured_story_block_headlines_one'] );
									if ( $obj ) {
										$this->featured_story_lead( $obj );
									}
									?>
								</div>
							</div>
							<div class="row">
								<h3 class="more-sub-head">
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>features/" data-on="click" data-event-category="navigation"
									   data-event-action="navigate-hp-features-column-title">
										More Features</a></h3>
								<div class="columns small-12">
									<div class="row">
										<?php
										$items = array();
										foreach ( $this->featured_story_block_headlines as $featured_story_block_headline => $value ) {
											$items[ $featured_story_block_headline ] = array_key_exists( $featured_story_block_headline, $article_map ) ? $article_map[ $featured_story_block_headline ] : null;
										}
										array_shift( $items );
										CST()->frontend->mini_stories_content_block( $items, 'vertical' ); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="columns small-12">
						<?php if ( get_query_var( 'showads', false ) ) { ?>
							<div class="cst-ad-container dfp dfp-centered"><img src="http://placehold.it/970x90/6060e5/130100&amp;text=[ad-will-be-responsive]"></div>
						<?php } ?>
					</div>
					<div class="show-for-large-up hide-for-portrait">
						<div class="small-12 columns more-stories-container" id="top-stories-section-lead">
							<hr>
							<h3 class="more-sub-head">
								<?php
								$section_link_url = wpcom_vip_get_term_link( intval( $instance['other_section_id'] ) );
								if ( ! is_wp_error( $section_link_url ) ) {
									echo '<a href="' . esc_url( $section_link_url ) . '" data-on="click" data-event-category="navigation" data-event-action="navigate-hp-section-link">' . esc_html( $instance['other_section_title'] ) . '</a>';
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

				</div>
			</div>
		</div>
		</div><!-- /stories -->
		<?php
	}

	/**
	 * @param $query
	 * @param $title string  Title of the content block
	 * @param $style string 'sidebar-style' | 'normal-style' to determine markup
	 * List of stories - title -> image
	 *
	 */
	public function more_top_stories_block( $query, $title, $style = 'sidebar-style' ) {
		$widget_style = array(
			'sidebar-style' => array(
				'wrapper-open' => 'row more-stories-container',
				'container-open' => 'columns small-12',
			),
			'normal-style' => array(
				'wrapper-open' => 'more-stories-container',
				'container-open' => 'columns small-12 medium-6 large-4',
			),
		);
		?>
		<div class="<?php echo esc_attr( $widget_style[$style]['wrapper-open'] ); ?>">
			<div class="<?php echo esc_attr( $widget_style[$style]['container-open'] ); ?>">
				<h3 class="more-sub-head"><?php echo esc_html( $title ); ?></h3>
				<div class="row">
					<div class="stories-list">
						<?php CST()->frontend->cst_latest_stories_content_block( $query ); ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * @param $obj
	 *
	 * Display Featured Story - lead, large image
	 */
	public function featured_story_lead( $obj ) {
		?>
<a href="<?php echo esc_url( $obj->the_permalink() ); ?>" title="<?php echo esc_html( $obj->get_title() ); ?>" target="_blank" data-on="click" data-event-category="navigation" data-event-action="navigate-hp-featured-story">
	<?php
	$featured_image_id = $obj->get_featured_image_id();
	if ( $featured_image_id )  {
		$attachment = wp_get_attachment_metadata( $featured_image_id );
		if ( $attachment ) {
			$image_markup = get_image_tag( $featured_image_id, $attachment['image_meta']['caption'], '', 'none', 'cst-article-featured');
			echo wp_kses_post( $image_markup );
		}
	}
	?>
	<h3><?php echo esc_html( $obj->get_title() ); ?></h3>
</a>
<?php
	}
}
