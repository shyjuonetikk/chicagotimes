<?php

/**
 * Class CST_Homepage_More_Headlines_Widget
 *
 * Version 3
 *
 */
class CST_Homepage_More_Headlines_Widget extends WP_Widget {

	private $headlines = array(
		'cst_homepage_more_headlines_1',
		'cst_homepage_more_headlines_2',
		'cst_homepage_more_headlines_3',
		'cst_homepage_more_headlines_4',
		'cst_homepage_more_headlines_5',
		'cst_homepage_more_headlines_6',
		'cst_homepage_more_headlines_7',
		'cst_homepage_more_headlines_8',
		'cst_homepage_more_headlines_9',
		'cst_homepage_more_headlines_10',
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

	private $cache_key_stub;

	public function __construct() {
		parent::__construct(
			'cst_homepage_more_headlines',
			esc_html__( 'CST RR Headlines', 'chicagosuntimes' ),
			array(
				'description' => esc_html__( 'Displays slottable headlines in homepage right rail.', 'chicagosuntimes' ),
				'customize_selective_refresh' => true,
			)
		);
		$this->cache_key_stub = 'homepage-more-headlines-widget';
		// Enqueue style if widget is active (appears in a sidebar) or if in Customizer preview.
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}
		add_action( 'wp_ajax_cst_homepage_more_headlines_get_posts', array( $this, 'cst_homepage_more_headlines_get_posts' ) );
	}

	/**
	 * Get all published posts to display in Select2 dropdown
	 */
	public function cst_homepage_more_headlines_get_posts() {
		if ( isset( $_GET['nonce'] )
			 && empty( $_GET['nonce'] )
			 && ! wp_verify_nonce( sanitize_key( $_GET['nonce'] ), 'cst_homepage_more_headlines' )
			 || ! current_user_can( 'edit_others_posts' )
		) {
			wp_send_json_error( array( 'code' => 'bad_nonce' ), 400 );
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

		echo wp_json_encode( $returning );
		exit();

	}

	public function enqueue_scripts() {

		wp_enqueue_script( 'cst_homepage_more_headlines', esc_url( get_template_directory_uri() . '/assets/js/cst-homepage-more-headlines.js' ), array( 'jquery' ) );
		wp_localize_script( 'cst_homepage_more_headlines', 'CSTMoreHeadlinesData', array(
			'placeholder_text' => esc_html__( 'Search for content to feature', 'chicagosuntimes' ),
			'nonce'            => wp_create_nonce( 'cst_homepage_more_headlines' ),
		) );
		wp_enqueue_style( 'select2', esc_url( get_template_directory_uri() . '/assets/js/vendor/select2/select2.css' ) );
		wp_enqueue_script( 'select2', esc_url( get_template_directory_uri() . '/assets/js/vendor/select2/select2.min.js' ) );
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
		$title = isset( $instance['cst_more_headlines_title'] ) ? $instance['cst_more_headlines_title'] : '';
		for ( $count = 0; $count < count( $instance ); $count++ ) {
			if ( $instance[ $count ] ) {
				$widget_posts[] = absint( $instance[ $count ] );
			}
		}

		if ( ! empty( $widget_posts ) ) {

			$homepage_more_well_posts = $this->get_headline_posts( $widget_posts );
			echo wp_kses_post( $args['before_widget'] );
			?>
			<div class="more-stories-content">
			<div class="row">
			<div class="more-stories-container">
			<?php
			if ( ! empty( $title ) ) {
				echo '<div class="columns"><div class="more-sub-head">' . esc_html( $title ) . '</div></div>';
			}
			get_template_part( 'parts/homepage/more-wells-v3' );
			?>
			</div>
			</div>
			</div>
			<?php
			echo wp_kses_post( $args['after_widget'] );

		}

	}

	/**
	 * @param array $widget_posts Array of integers representing post ids
	 *
	 * @return array Of found posts
	 *
	 */
	public function get_headline_posts( $widget_posts ) {
		if ( false === ( $found = wpcom_vip_cache_get( $this->cache_key_stub . '-' . $this->id ) ) ) {

			$widget_posts_query  = array(
				'post__in'            => $widget_posts,
				'post_type'           => 'any',
				'orderby'             => 'post__in',
				'ignore_sticky_posts' => true,
			);
			$display_these_posts = new \WP_Query( $widget_posts_query );
			$display_these_posts->have_posts();
			$found = $display_these_posts->get_posts();
			wpcom_vip_cache_set( $this->cache_key_stub . '-' . $this->id, $found, '', 1 * HOUR_IN_SECONDS );
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
		$width = is_customize_preview() ? 'width:100%;' : 'width:400px;';
		isset( $instance['cst_more_headlines_title'] ) ? $title = $instance['cst_more_headlines_title'] : $title = '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'cst_more_headlines_title' ) ); ?>"><?php esc_html_e( 'Title:', 'chicagosuntimes' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cst_more_headlines_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cst_more_headlines_title' ) ); ?>" type="text"
				   value="<?php echo esc_attr( $title ); ?>" style="<?php echo esc_attr( $width ); ?>"/>
		</p>
		<div class="cst-headline-sort ui-sortable">
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
			<p class="ui-state-default" id=i<?php echo esc_attr( $count ); ?>>
				<label for="<?php echo esc_attr( $this->get_field_id( $count ) ); ?>"><span class="dashicons dashicons-sort"></span><?php esc_html_e( $this->titles[ $count ], 'chicagosuntimes' ); ?></label>
				<input class="<?php echo esc_attr( $dashed_array_member ); ?>" id="<?php echo esc_attr( $this->get_field_id( $count ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $count ) ); ?>"
					   value="<?php echo esc_attr( $headline ); ?>" data-story-title="<?php echo esc_attr( $story_title ); ?>" style="<?php echo esc_attr( $width ); ?>"/>
			</p>
			<?php
			$count++;
		}?>
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
		$instance['cst_more_headlines_title'] = isset( $new_instance['cst_more_headlines_title'] ) ? $new_instance['cst_more_headlines_title'] : false;
		array_shift( $new_instance );
		$total    = count( $new_instance );
		for ( $count = 0; $count < $total; $count ++ ) {
			$instance[] = intval( array_shift( $new_instance ) );
		}
		wp_cache_delete( $this->cache_key_stub . '-' . $this->id );

		return $instance;
	}
}