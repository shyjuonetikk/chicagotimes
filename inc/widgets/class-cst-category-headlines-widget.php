<?php

/**
 * Class CST_Category_Headlines_Widget
 *
 * Version 2
 *
 */
class CST_Category_Headlines_Widget extends WP_Widget {

	private $headlines = array(
		'cst_category_headlines_one',
		'cst_category_headlines_two',
		'cst_category_headlines_three',
		'cst_category_headlines_four',
		'cst_category_headlines_five',
		'cst_category_headlines_six',
		'cst_category_headlines_seven',
		'cst_category_headlines_eight',
		'cst_category_headlines_nine',
		'cst_category_headlines_ten',
	);

	private $titles = array(
		'Slide',
		'Slide',
		'Slide',
		'Slide',
		'Slide',
		'Slide',
		'Slide',
		'Slide',
		'Slide',
		'Slide',
	);

	private $cache_key_stub;

	public function __construct() {
		parent::__construct(
			'cst_category_headlines',
			esc_html__( 'CST Category Main Headline Posts', 'chicagosuntimes' ),
			array(
				'description' => esc_html__( 'Displays Section Headlines.', 'chicagosuntimes' ),
			),
			array( 'width' => '400' )
		);
		$this->cache_key_stub = 'category-headlines-slider';
		add_action( 'wp_ajax_cst_category_headlines_get_posts', array( $this, 'cst_category_headlines_get_posts' ) );
	}

	/**
	 * Get all published posts to display in Select2 dropdown
	 */
	public function cst_category_headlines_get_posts() {

		if ( ! wp_verify_nonce( $_GET['nonce'], 'cst_category_headlines' )
			 || ! current_user_can( 'edit_others_posts' )
		) {
			wp_send_json_error();
		}

		$term = sanitize_text_field( $_GET['searchTerm'] );

		$search_args = array(
			'post_type'     => array( 'cst_article', 'cst_embed', 'cst_link' ),
			's'             => $term,
			'post_status'   => 'publish',
			'no_found_rows' => true,
		);

		$search_query = new WP_Query( $search_args );

		$returning = array();
		$posts     = array();

		if ( $search_query->have_posts() ) {

			while ( $search_query->have_posts() ) : $search_query->the_post();
				$obj = get_post( get_the_ID() );
				if ( $obj ) {
					$content_type  = get_post_type( $obj->ID );
					$posts['id']   = get_the_ID();
					$posts['text'] = $obj->post_title . ' [' . $content_type . ']';
					array_push( $returning, $posts );
				}

			endwhile;
		}

		echo json_encode( $returning );
		exit();

	}

	public function enqueue_scripts() {

		wp_enqueue_script( 'cst_category_headlines', get_template_directory_uri() . '/assets/js/category-headlines-widget.js', array( 'jquery-ui-sortable', 'jquery' ) );
		wp_localize_script( 'cst_category_headlines', 'CSTSectionHeadlinesData', array(
			'placeholder_text' => esc_html__( 'Search for content to feature', 'chicagosuntimes' ),
			'nonce'            => wp_create_nonce( 'cst_category_headlines' ),
			'widget_id'        => esc_attr( $this->id ),
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

		global $category_headline_posts;
		$widget_posts = array();

		for ( $count = 0; $count < count( $instance ); $count ++ ) {
			if ( $instance[ $count ] ) {
				$widget_posts[] = absint( $instance[ $count ] );
			}
		}

		if ( ! empty( $widget_posts ) ) {

			$category_headline_posts = $this->get_headline_posts( $widget_posts );
			foreach ( $category_headline_posts as $headline ) {
				$obj = \CST\Objects\Post::get_by_post_id( $headline );
				if ( $obj ) {
					?>
					<div class="slide">
						<div class="slide-inner">
							<?php if ( $obj->get_featured_image_url() ) : ?>
								<a href="<?php echo esc_url( $obj->the_permalink() ); ?>" data-on="click" data-event-category="slider" data-event-action="navigate-slider-image">
									<div class="slide-image" style="background-image: url('<?php echo esc_url( $obj->get_featured_image_url( 'chiwire-header-medium' ) ); ?>')">
										<div class="gradient-overlay"></div>
									</div>
								</a>
							<?php endif; ?>
						</div>
						<div class="slide-text">
							<?php if ( $section = $obj->get_primary_section() ) : ?>
								<h4><?php echo esc_html( $section->name ); ?></h4>
							<?php endif; ?>
							<h3><a href="<?php echo esc_url( $obj->the_permalink() ); ?>" data-on="click" data-event-category="slider" data-event-action="navigate-slider-text"><?php esc_html( $obj->the_title() ); ?></a></h3>
						</div>
					</div>
				<?php }
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

		if ( false === ( $found = wp_cache_get( $this->cache_key_stub . '-' . $this->id ) ) ) {
			$use_sticky_option   = is_singular() ? false : true;
			$widget_posts_query  = array(
				'post__in'            => $widget_posts,
				'post_type'           => 'any',
				'orderby'             => 'post__in',
				'ignore_sticky_posts' => $use_sticky_option,
			);
			$display_these_posts = new \WP_Query( $widget_posts_query );
			$display_these_posts->have_posts();
			$found = $display_these_posts->get_posts();
			wp_cache_set( $this->cache_key_stub . '-' . $this->id, $found, '', 1 * HOUR_IN_SECONDS );
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
		$count = 0;
		$classes = join( ' ', array( 'cst-headline-sort', 'ui-sortable', $this->id ) );
		?>
		<div class="<?php echo esc_attr( $classes ); ?>">
			<?php
			foreach ( $this->headlines as $array_member ) {
				$headline = ! empty( $instance[ $count ] ) ? $instance[ $count ] : '';
				$obj      = get_post( $headline );
				if ( $obj ) {
					$content_type = get_post_type( $obj->ID );
					$story_title  = $obj->post_title . ' [' . $content_type . ']';
				} else {
					$story_title = '';
				}
				$dashed_array_member = preg_replace( '/_/', '-', $array_member );
				?>
				<p class="ui-state-default" id=i<?php echo intval( $count ); ?>>
					<label for="<?php echo esc_attr( $this->get_field_id( $count ) ); ?>"><span class="dashicons dashicons-sort"></span><?php esc_html_e( $this->titles[ $count ], 'chicagosuntimes' ); ?></label>
					<input class="<?php echo esc_attr( $dashed_array_member ); ?>" id="<?php echo esc_attr( $this->get_field_id( $count ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $count ) ); ?>"
							value="<?php echo esc_attr( $headline ); ?>" data-story-title="<?php echo esc_attr( $story_title ); ?>" style="width:400px;"/>
				</p>
				<?php
				$count ++;
			}
			?>
		</div>
		<?php

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
		$total    = count( $new_instance );
		for ( $count = 0; $count < $total; $count ++ ) {
			$instance[] = intval( array_shift( $new_instance ) );
		}
		wp_cache_delete( $this->cache_key_stub . '-' . $this->id );
		return $instance;
	}
}
