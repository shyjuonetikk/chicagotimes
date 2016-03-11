<?php

/**
 * Class cst_election_2016_more_headlines_Widget
 *
 * Version 2
 *
 */
class CST_Elections_2016_More_Headlines_Widget extends WP_Widget {

	private $headlines = array(
		'cst_election_2016_more_headlines_one',
		'cst_election_2016_more_headlines_two',
		'cst_election_2016_more_headlines_three',
		'cst_election_2016_more_headlines_four',
		'cst_election_2016_more_headlines_five',
	);

	private $titles = array(
		'Headline One',
		'Headline Two',
		'Headline Three',
		'Headline Four',
		'Headline Five',
	);

	public function __construct() {
		parent::__construct(
			'cst_election_2016_more_headlines',
			esc_html__( 'CST Election 2016 More Headlines', 'chicagosuntimes' ),
			array(
				'description' => esc_html__( 'Displays Election Specific Headlines.', 'chicagosuntimes' ),
			)
		);

		add_action( 'wp_ajax_cst_election_2016_more_headlines_get_posts', array( $this, 'cst_election_2016_more_headlines_get_posts' ) );
	}

	/**
	 * Get all published posts to display in Select2 dropdown
	 */
	public function cst_election_2016_more_headlines_get_posts() {

		if ( ! wp_verify_nonce( $_GET['nonce'], 'cst_election_2016_more_headlines' )
		     || ! current_user_can( 'edit_others_posts' )
		) {
			wp_send_json_error();
		}

		$term = sanitize_text_field( $_GET['searchTerm'] );

		$search_args = array(
			'post_type'     => array( 'cst_article', 'cst_embed', 'cst_link', 'cst_gallery' ),
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

		wp_enqueue_script( 'cst_election_2016_more_headlines', get_template_directory_uri() . '/assets/js/cst-homepage-election-headlines.js', array( 'jquery' ) );
		wp_localize_script( 'cst_election_2016_more_headlines', 'CSTElectionHeadlinesData', array(
			'placeholder_text' => esc_html__( 'Search for content to feature', 'chicagosuntimes' ),
			'nonce'            => wp_create_nonce( 'cst_election_2016_more_headlines' ),
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

		global $homepage_election_well_posts, $election_sections;
		$widget_posts = array();

		for ( $count = 0; $count < 5; $count++ ) {
			if ( $instance[ $count ] ) {
				$widget_posts[] = absint( $instance[ $count ] );
			}
		}

		if ( ! empty( $widget_posts ) ) {

			$homepage_election_well_posts = $this->get_headline_posts( $widget_posts );
			$election_sections['section_id_upper'] = $instance['section_id_upper'];
			$election_sections['section_id_lower'] = $instance['section_id_lower'];
			get_template_part( 'parts/homepage/election-more-wells' );

		}

	}

	/**
	 * @param array $widget_posts Array of integers representing post ids
	 * @return array Of found posts
	 *
	 */
	public function get_headline_posts( $widget_posts ) {

		$widget_posts_query = array(
			'post__in' => $widget_posts,
			'post_type' => 'any',
			'orderby'	=> 'post__in',
		);
		$display_these_posts = new \WP_Query( $widget_posts_query );
		$display_these_posts->have_posts();
		$found = $display_these_posts->get_posts();

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
		$section_names = array(
			'US_Senate' => 'US Senate',
			'States_Attorney' => 'States Attorney',
			'Circuit_Court_Clerk' => 'Circuit Court Clerk',
		);

		$count = 0;
		?>
		<div class="cst-election-2016-headline-sort ui-sortable">
			<?php
			foreach ( $this->headlines as $array_member ) {
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
				<p class="ui-state-default" id=i<?php echo $count; ?>>
					<label for="<?php echo esc_attr( $this->get_field_id( $count ) ); ?>"><span class="dashicons dashicons-sort"></span><?php esc_html_e( $this->titles[ $count ], 'chicagosuntimes' ); ?></label>
					<input class="<?php echo esc_attr( $dashed_array_member ); ?>" id="<?php echo esc_attr( $this->get_field_id( $count ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $count ) ); ?>" value="<?php echo esc_attr( $headline ); ?>" data-story-title="<?php echo esc_attr( $story_title ); ?>" style="width:400px;" />
				</p>
				<?php
				$count++;
			}?>
		</div>
		<div>
		<label for="<?php echo $this->get_field_id( 'section_id_upper' ); ?>"><?php esc_attr_e( 'Right sections upper:' ); ?></label>
		<select name="<?php echo $this->get_field_name( 'section_id_upper' ); ?>" id="<?php echo $this->get_field_id( 'section_id_upper' ); ?>">
			<?php
			foreach ( $section_names as $section_name => $value ) {?>
				<option value="<?php echo esc_attr( $section_name ); ?>" <?php echo esc_attr( $instance['section_id_upper'] === $section_name ? 'selected' : '' ); ?>><?php echo esc_attr( $value ); ?></option>
			<?php } ?>
		</select>
		</div>
		<div>
		<label for="<?php echo $this->get_field_id( 'section_id_lower' ); ?>"><?php esc_attr_e( 'Right sections lower:' ); ?></label>
		<select name="<?php echo $this->get_field_name( 'section_id_lower' ); ?>" id="<?php echo $this->get_field_id( 'section_id_lower' ); ?>">
			<?php
			foreach ( $section_names as $section_name => $value ) {?>
				<option value="<?php echo esc_attr( $section_name ); ?>" <?php echo esc_attr( $instance['section_id_lower'] === $section_name ? 'selected' : '' ); ?>><?php echo esc_attr( $value ); ?></option>
			<?php } ?>
		</select>
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
		for ( $count = 0; $count < 5; $count++ ) {
			$instance[] = intval( array_shift( $new_instance ) );
		}
		$instance['section_id_upper'] = $new_instance['section_id_upper'];
		$instance['section_id_lower'] = $new_instance['section_id_lower'];
		return $instance;
	}
}
