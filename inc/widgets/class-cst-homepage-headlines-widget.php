<?php

/**
 * Class CST_Homepage_Headlines_Widget
 *
 * Version 3
 *
 */

class CST_Homepage_Headlines_Widget extends WP_Widget {

	private $hero_headlines = array(
		'cst_homepage_headlines_one',
		'cst_homepage_headlines_two',
		'cst_homepage_headlines_three',
	);
	private $mini_headlines = array(
		'cst_homepage_mini_headlines_one',
		'cst_homepage_mini_headlines_two',
		'cst_homepage_mini_headlines_three',
		'cst_homepage_mini_headlines_four',
		'cst_homepage_mini_headlines_five',
	);
	private $hero_titles = array(
		'Main/Top Story',
		'Upper Story',
		'Lower Story',
	);
	private $mini_titles = array(
		'Story 1 - largest',
		'Story 2',
		'Story 3',
		'Story 4',
		'Story 5',
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

		for ( $count = 0; $count < count( $instance ); $count++) {
			if ( $instance[ $count ] ) {
				$widget_posts[] = absint( $instance[ $count ] );
			}
		}

		if ( ! empty( $widget_posts ) ) {

			$homepage_main_well_posts = $this->get_headline_posts( $widget_posts );
			$this->widget_markup( $homepage_main_well_posts );
			// get_template_part( 'parts/homepage/main-wells-v3' );

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
		$instance = wp_parse_args(
			(array) $instance
		);
		$this->enqueue_scripts();
		$count = 0;
		$width = is_customize_preview() ? 'width:250px;' : 'width:400px;';
		?>
		<h3>Hero Story and 2 leads</h3>
		<h4>Featured image included in certain layouts</h4>
		<?php
		foreach ( $this->hero_headlines as $array_member ) {
			$headline = ! empty( $instance[ $count ] ) ? $instance[ $count ] : '';
			$obj = get_post( $headline );
			if ( $obj ) {
				$content_type = get_post_type( $obj->ID );
				$story_title = $obj->post_title . ' [' . $content_type . ']';
			} else {
				$story_title = '';
			}
			$dashed_array_member = preg_replace( '/_/', '-', $array_member );
			?>
				<p class="ui-state-default" id="i<?php echo esc_attr( $count ); ?>">
					<label for="<?php echo esc_attr( $this->get_field_id( $count ) ); ?>">
						<?php esc_html_e( $this->hero_titles[ $count ], 'chicagosuntimes' ); ?>
					</label>
					<input class="<?php echo esc_attr( $dashed_array_member ); ?>" id="<?php echo esc_attr( $this->get_field_id( $count ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $count ) ); ?>" value="<?php echo esc_attr( $headline ); ?>" data-story-title="<?php echo esc_attr( $story_title ); ?>" style="<?php echo esc_attr( $width ); ?>"/>
				</p>
			<?php
			$count++;
		}
		?>
		<h3>Other stories 1 plus 2x2</h3>
		<h4>Featured image in all layouts</h4>
		<?php
		$mini_stories_count = 0;
		foreach ( $this->mini_headlines as $array_member ) {
			$headline = ! empty( $instance[ $count ] ) ? $instance[ $count ] : '';
			$obj = get_post( $headline );
			if ( $obj ) {
				$content_type = get_post_type( $obj->ID );
				$story_title = $obj->post_title . ' [' . $content_type . ']';
			} else {
				$story_title = '';
			}
			$dashed_array_member = preg_replace( '/_/', '-', $array_member );
			?>
				<p class="ui-state-default" id="i<?php echo esc_attr( $count ); ?>">
					<label for="<?php echo esc_attr( $this->get_field_id( $count ) ); ?>">
						<?php esc_html_e( $this->mini_titles[ $mini_stories_count ], 'chicagosuntimes' ); ?>
					</label>
					<input class="<?php echo esc_attr( $dashed_array_member ); ?>" id="<?php echo esc_attr( $this->get_field_id( $count ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $count ) ); ?>" value="<?php echo esc_attr( $headline ); ?>" data-story-title="<?php echo esc_attr( $story_title ); ?>" style="<?php echo esc_attr( $width ); ?>"/>
				</p>
			<?php
			$count++;
			$mini_stories_count++;
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
		$total = count( $new_instance );
		for ( $count = 0; $count < $total; $count++ ) {
			$instance[] = intval( array_shift( $new_instance ) );
		}
		wp_cache_delete( $this->cache_key_stub );
		return $instance;
	}

	public function widget_markup( $headlines ) {
		$hero_story = $headlines[0];
		$sub_lead_story = $headlines[1];
		$sub_sub_lead_story = $headlines[2];
		$mini_story = $headlines[3];
?>
<div class="row stories-container">
	<div class="columns small-12 medium-8 large-9 stories">
		<div class="row" data-equalizer-mq="large-up">
			<div class="columns small-12 large-4 lead-stories">
				<div class="hero-story">
<?php
$obj = \CST\Objects\Post::get_by_post_id( $hero_story->ID );
if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
	$author          = CST()->frontend->get_article_author( $obj );
	$this->homepage_hero_story( $obj, $author );
}
?>
		</div>
		<div class="lead-story">
			<?php
			$obj = \CST\Objects\Post::get_by_post_id( $sub_lead_story->ID );
			if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
				$author          = CST()->frontend->get_article_author( $obj );
				$this->homepage_lead_story( $obj, $author );
			}
			?>
		</div>
		<div class="lead-story">
			<?php
			$obj = \CST\Objects\Post::get_by_post_id( $sub_sub_lead_story->ID );
			if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
				$author          = CST()->frontend->get_article_author( $obj );
				$this->homepage_lead_story( $obj, $author );
			}
			?>
		</div>
		<div class="show-for-large-up">
			<?php CST()->frontend->inject_newsletter_signup( 'news' ); ?>
		</div>
		</div>
		<div class="columns small-12 large-8 other-lead-stories">
			<div class="show-for-medium-only"><h3>In other news</h3></div>
			<div class="row lead-mini-story">
				<?php
				$obj = \CST\Objects\Post::get_by_post_id( $mini_story->ID );
				if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
					$author          = CST()->frontend->get_article_author( $obj );
					$this->homepage_mini_story_lead( $obj, $author );
				}
				?>
			</div>
			<hr>
			<?php
			$query = array(
				'post_type'           => array( 'cst_article' ),
				'ignore_sticky_posts' => true,
				'posts_per_page'      => 4,
				'post_status'         => 'publish',
				'cst_section'         => 'news',
				'orderby'             => 'modified',
			);
			CST()->frontend->cst_mini_stories_content_block( $query ); ?>
			<div class="other-stories show-for-large-up">
				<hr>
				<h2>Trending in the Chicago Sun-Times</h2>
				<div id="root"></div>
				<script type="text/javascript" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/js/main.641bf377.js"></script>
			</div>
		</div>
		<div class="small-12 columns more-stories-container">
			<hr>
			<h3 class="more-sub-head"><a href="<?php echo esc_url( '/' ); ?>">Chicago Sports</a></h3>
			<?php
			$query = array(
				'post_type'           => array( 'cst_article' ),
				'ignore_sticky_posts' => true,
				'posts_per_page'      => 5,
				'post_status'         => 'publish',
				'cst_section'         => 'sports',
				'orderby'             => 'modified',
			);
			CST()->frontend->cst_mini_stories_content_block( $query ); ?>
		</div>
		</div>
		<?php if ( get_query_var( 'showads', false ) ) { ?>
			<div class="cst-ad-container"><img src="http://placehold.it/970x90/a0a0d0/130100&amp;text=[nativo]"></div>
		<?php } ?>
		<hr>
		<div class="row more-stories-container">
			<!-- Pull from Top Stories widget -->
			<?php $section_slug = 'news'; ?>
			<div class="columns small-12">
				<div class="row">
					<div class="columns small-12 medium-6 large-4">
						<h3 class="more-sub-head">More Top Stories</h3>
						<div class="row">
							<div class="stories-list">
								<?php $query = array(
									'post_type'           => array( 'cst_article' ),
									'ignore_sticky_posts' => true,
									'posts_per_page'      => 10,
									'post_status'         => 'publish',
									'cst_section'         => esc_attr( $section_slug ),
									'orderby'             => 'modified',
								);
								CST()->frontend->cst_latest_stories_content_block( $query ); ?>
							</div>
						</div>
					</div>
					<div class="columns small-12 medium-6 large-8">
						<div class="small-12 columns">
							<div class="row">
								<h3 class="more-sub-head"><a href="<?php echo esc_url( home_url( '/' ) ); ?>features/"></a>Featured story</h3>
								<div class="featured-story">
									<a href="http://chicago.suntimes.com/feature/50-years-after-chicago-areas-most-devastating-tornadoes/" target="_blank" data-on="click" data-event-category="navigation" data-event-action="navigate-hp-featured-story">
										<img src="https://suntimesmedia.files.wordpress.com/2017/04/tornado-041617-01_68208979.jpg?w=700" alt="article promo image" class="featured-story-hero">
										<h3>Survivors' stories 50 years after Chicago area's deadliest tornadoes hit Oak Lawn, other towns</h3>
									</a>
								</div>
							</div>
							<div class="row">
								<h3 class="more-sub-head">
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>features/" data-on="click" data-event-category="navigation"
									   data-event-action="navigate-hp-features-column-title">
										More Features</a></h3>
								<div class="columns small-12">
									<div class="row">
										<?php $query = array(
											'post_type'           => array( 'cst_feature' ),
											'ignore_sticky_posts' => true,
											'posts_per_page'      => 4,
											'post_status'         => 'publish',
											'orderby'             => 'modified',
										);
										CST()->frontend->cst_mini_stories_content_block( $query ); ?>
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
						<div class="small-12 columns more-stories-container">
							<hr>
							<h3 class="more-sub-head"><a href="<?php echo esc_url( '/' ); ?>">Entertainment</a></h3>
							<?php
							$query = array(
								'post_type'           => array( 'cst_article' ),
								'ignore_sticky_posts' => true,
								'posts_per_page'      => 5,
								'post_status'         => 'publish',
								'cst_section'         => 'entertainment',
								'orderby'             => 'modified',
							);
							CST()->frontend->cst_mini_stories_content_block( $query ); ?>
						</div>
					</div>

				</div>
			</div>
		</div>
		</div>
		<div class="columns small-12 medium-4 large-3 sidebar homepage-sidebar widgets">
			<?php if ( get_query_var( 'showads', false ) ) { ?>
				<div class="cst-ad-container"><img src="http://placehold.it/300x600&amp;text=[ad-will-be-responsive]"></div>
			<?php } ?>
			<div class="more-stories-container hide-for-large-up">
				<hr>
				<div class="other-stories">
					<h2>Also in the Chicago Sun-Times</h2>
					<ul class="list">
						<li><span class="section-name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="section-link">Chicago News</a></span> <a href="<?php echo esc_url( 'http://chicago.suntimes.com/columnists/wanted-conservative-sports-network-to-compete-with-espn/' ); ?>" class=" magic-link-size">Mentally ill woman gets 22 years for killing husband with poison</a></li>
						<li><span class="section-name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="section-link">Chicago News</a></span> <a href="<?php echo esc_url( 'http://chicago.suntimes.com/columnists/wanted-conservative-sports-network-to-compete-with-espn/' ); ?>" class=" magic-link-size">9 charged with Crystal Lake fight that led to stabbing</a></li>
						<li><span class="section-name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="section-link">Chicago Sports</a></span> <a href="<?php echo esc_url( 'http://chicago.suntimes.com/columnists/wanted-conservative-sports-network-to-compete-with-espn/' ); ?>" class=" magic-link-size">Anthony Swarzak gettung career back on track with White Sox</a></li>
						<li><span class="section-name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="section-link">Entertainment</a></span> <a href="<?php echo esc_url( 'http://chicago.suntimes.com/columnists/wanted-conservative-sports-network-to-compete-with-espn/' ); ?>" class=" magic-link-size">Dear Abby: My friend bullies other kids at school</a></li>
						<li><span class="section-name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="section-link">Chicago Politics</a></span> <a href="<?php echo esc_url( 'http://chicago.suntimes.com/columnists/wanted-conservative-sports-network-to-compete-with-espn/' ); ?>" class=" magic-link-size">Sneed exclusive: City could deal blow to Trump wall contractors</a></li>
					</ul>
				</div>
			</div>
			<div class="row more-stories-container">
				<div class="columns small-12">
					<hr>
					<?php $section_slug = 'opinion'; ?>
					<h3 class="more-sub-head">
						<a href="<?php echo esc_url( home_url( '/' ) . 'section/' . esc_attr( $section_slug ) . '/' ); ?>" data-on="click" data-event-category="navigation"
						   data-event-action="navigate-hp-<?php echo esc_attr( $section_slug ); ?>-column-title">
							<?php esc_html_e( ucfirst( $section_slug ), 'chicagosuntimes' ); ?></a></h3>
					<div class="row">
						<div class="stories-list">
							<?php $query = array(
								'post_type'           => array( 'cst_article' ),
								'ignore_sticky_posts' => true,
								'posts_per_page'      => 7,
								'post_status'         => 'publish',
								'cst_section'         => esc_attr( $section_slug ),
								'orderby'             => 'modified',
							);
							CST()->frontend->cst_latest_stories_content_block( $query ); ?>
						</div>
					</div>
				</div>
			</div>
			<?php if ( get_query_var( 'showads', false ) ) { ?>
				<div class="cst-ad-container">
					<hr>
					<img src="http://placehold.it/300x250/e0e0e0/130100&amp;text=[300x250-ad-will-be-responsive]">
				</div>
			<?php } ?>
			<div class="row more-stories-container hide-for-landscape">
				<div class="small-12 columns">
					<hr>
					<h3 class="more-sub-head"><a href="<?php echo esc_url( '/' ); ?>">Entertainment</a></h3>
					<?php
					$query = array(
						'post_type'           => array( 'cst_article' ),
						'ignore_sticky_posts' => true,
						'posts_per_page'      => 4,
						'post_status'         => 'publish',
						'cst_section'         => 'entertainment',
						'orderby'             => 'modified',
					);
					CST()->frontend->cst_mini_stories_content_block( $query ); ?>
				</div>
			</div>
			<div>
				<hr>
				<?php the_widget( 'CST_Chartbeat_Currently_Viewing_Widget' ); ?>
			</div>
			<div class="show-for-medium-up">
				<hr>
				<?php if ( get_query_var( 'showads', false ) ) { ?>
					<img src="http://placehold.it/300x250/a0d0a0/130100&amp;text=[300x250-ad-will-be-responsive]">
				<?php } ?>
			</div>
			<div class="hide-for-medium-down">
				<hr>
				<div class="row">
					<?php the_widget( 'CST_STNG_Wire_Widget' ); ?>
				</div>
			</div>
		</div>
		</div>
		<?php
	}

	/**
	 * @param $obj
	 * @param $author
	 * @param string $image_size
	 *
	 * Hero story markup generation and display
	 */
	public function homepage_hero_story( $obj, $author, $image_size = 'chiwire-header-medium' ) {
		remove_filter( 'the_excerpt', 'wpautop' );
		$story_excerpt = apply_filters( 'the_excerpt', $obj->get_excerpt() );
		add_filter( 'the_excerpt', 'wpautop' );
		?>
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
						$image_markup = get_image_tag( $featured_image_id, $attachment['image_meta']['caption'], $attachment['image_meta']['caption'], 'left', $image_size );
						echo wp_kses_post( $image_markup );
					}
				}
				?>
				</span></a>
			</div>
		<div class="show-for-portrait show-for-xlarge-up">
			<div class="small-12">
				<h3>Related News.</h3>
				<ul class="related-title">
					<li>Weekend Killings</li>
					<li>CPS budgets</li>
					<li>Rauner pulls funding</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="columns small-12 medium-5 medium-offset-1 large-12 large-offset-0">
	<div class="row">
		<a href="<?php echo esc_url( $obj->the_permalink() ); ?>"  data-on="click" data-event-category="content" data-event-action="navigate-hp-hero-story" >
			<p class="excerpt">
				<?php echo wp_kses_post( $story_excerpt ); ?>
			</p>
		</a>
		<p class="authors">By <?php echo esc_html( $author ); ?> - 2 hours ago</p>
		<ul class="related-title">
			<li><a href="#"><h3>Analysis: When did Trump declare the wall will be built?</h3></a></li>
		</ul>
	</div>
</div>
		<?php
	}

	/**
	 * @param $obj
	 * @param $author
	 *
	 * The lead stories - each generated by the following function - display below the hero story (see above)
	 */
	public function homepage_lead_story( $obj, $author ) {
		remove_filter( 'the_excerpt', 'wpautop' );
		$story_excerpt = apply_filters( 'the_excerpt', $obj->get_excerpt() );
		add_filter( 'the_excerpt', 'wpautop' );
		$featured_image_id = $obj->get_featured_image_id();
		if ( $featured_image_id ) {
			$attachment = wp_get_attachment_metadata( $featured_image_id );
			if ( $attachment ) {
				$large_image_markup = get_image_tag( $featured_image_id, $attachment['image_meta']['caption'], $attachment['image_meta']['caption'], 'left', 'chiwire-header-medium' );
				$small_image_markup = get_image_tag( $featured_image_id, $attachment['image_meta']['caption'], $attachment['image_meta']['caption'], 'left', 'chiwire-small-square' );
			}
		}
		?>
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
<p class="authors">By <?php echo esc_html( $author ); ?> - 1 hour ago</p>
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
				$large_image_markup = get_image_tag( $featured_image_id, $attachment['image_meta']['caption'], $attachment['image_meta']['caption'], 'left', 'secondary-wells' );
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
			<p class="authors">By <?php echo esc_html( $author ); ?> - 1/2 hour ago</p>
		</div>
	</div>
</div>
<?php
	}
}
