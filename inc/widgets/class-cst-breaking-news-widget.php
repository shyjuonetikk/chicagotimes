<?php

class CST_Breaking_News_Widget extends WP_Widget {

	public function __construct() {

		parent::__construct(
			'cst_breaking_news_widget',
			esc_html__( 'CST Homepage Breaking News', 'chicagosuntimes' ),
			array(
				'description'                 => esc_html__( 'Set Breaking News displayed in the header.', 'chicagosuntimes' ),
				'customize_selective_refresh' => true,
			)
		);
		// Enqueue style if widget is active (appears in a sidebar) or if in Customizer preview.
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}
		add_action( 'wp_ajax_cst_breaking_news_get_posts', array( $this, 'cst_breaking_news_get_posts' ) );

	}

	/**
	 * Get all published posts to display in Select2 dropdown
	 */
	public function cst_breaking_news_get_posts() {

		if ( isset( $_GET['nonce'] )
			 && empty( $_GET['nonce'] )
			 && ! wp_verify_nonce( sanitize_key( $_GET['nonce'] ), 'cst_breaking_news_widget' )
			 || ! current_user_can( 'edit_others_posts' )
		) {
			wp_send_json_error( array( 'code' => 'bad_nonce' ), 400 );
		}

		$term = sanitize_text_field( $_GET['searchTerm'] );

		$search_args  = array(
			'post_type' => CST()->get_post_types(),
			's'         => $term,
		);
		$search_query = new WP_Query( $search_args );

		$returning = array();
		$posts     = array();

		if ( $search_query->have_posts() ) :

			while ( $search_query->have_posts() ) : $search_query->the_post();
				$obj = \CST\Objects\Post::get_by_post_id( get_the_ID() );
				if ( $obj ) {
					$content_type  = str_replace( 'cst_', '', $obj->get_post_type() );
					$posts['id']   = $obj->get_id();
					$posts['text'] = $obj->get_title() . ' [' . $content_type . ']';
					array_push( $returning, $posts );
				}

			endwhile;
		endif;

		echo wp_json_encode( $returning );
		exit();

	}

	public function enqueue_scripts() {

		wp_enqueue_script( 'cst-breaking-news-widget', get_template_directory_uri() . '/assets/js/cst-breaking-news-widget.js', array( 'jquery' ) );
		wp_localize_script( 'cst-breaking-news-widget', 'CSTBreakingNewsWidgetData', array(
			'placeholder_text' => esc_html__( 'Search for content to feature', 'chicagosuntimes' ),
			'nonce'            => wp_create_nonce( 'cst_breaking_news_widget' ),
		) );
		wp_enqueue_style( 'select2', get_template_directory_uri() . '/assets/js/vendor/select2/select2.css' );
		wp_enqueue_script( 'select2', get_template_directory_uri() . '/assets/js/vendor/select2/select2.min.js' );

	}

	public function widget( $args, $instance ) {

		if ( empty( $instance['cst_breaking_news_story_id'] ) ) {
			return;
		}

		$breaking_news_story_id = $instance['cst_breaking_news_story_id'];
		$obj                    = \CST\Objects\Post::get_by_post_id( $breaking_news_story_id );

		if ( ! $obj ) {
			return;
		}
		echo wp_kses_post( $args['before_widget'] );
		?>
		<div class="breaking-news-story">
			<h3 class="title">
				<span><i class="fa fa-times-circle-o close-breaking-news"></i>&nbsp;<?php esc_html_e( 'Breaking News:  ', 'chicagosuntimes' ); ?></span><a href="<?php echo esc_url( $obj->get_permalink() ); ?>"
																																						   class="breaking-news-link"><?php echo esc_html( $obj->get_title() ); ?></a>
				<a href="https://r1.surveysandforms.com/062jcp97-8a19pw1c" target="_blank" class="button tiny breaking-news-button"><?php echo esc_html( 'Sign-Up for Breaking News Alerts' ); ?></a>
			</h3>
		</div>
		<?php
		echo wp_kses_post( $args['after_widget'] );
	}

	public function form( $instance ) {

		$this->enqueue_scripts();
		$width                  = is_customize_preview() ? 'width:100%;' : 'width:400px;';
		$breaking_news_story_id = ! empty( $instance['cst_breaking_news_story_id'] ) ? $instance['cst_breaking_news_story_id'] : '';
		$obj                    = \CST\Objects\Post::get_by_post_id( $breaking_news_story_id );
		if ( $obj ) {
			$content_type = str_replace( 'cst_', '', $obj->get_post_type() );
			$story_title  = $obj->get_title() . ' [' . $content_type . ']';
		} else {
			$story_title = '';
		}

		?>
		<p class="ui-state-default">
			<label for="<?php echo esc_attr( $this->get_field_id( 'cst_breaking_news_story_id' ) ); ?>">
				<?php esc_html_e( 'Breaking News Content', 'chicagosuntimes' ); ?>:
			</label>
			<input class="cst-breaking-news-story-id" id="<?php echo esc_attr( $this->get_field_id( 'cst_breaking_news_story_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cst_breaking_news_story_id' ) ); ?>"
				   value="<?php echo esc_attr( $breaking_news_story_id ); ?>" data-story-title="<?php echo esc_attr( $story_title ); ?>" style="<?php echo esc_attr( $width ); ?>"/>
		</p>
		<?php

	}

	public function update( $new_instance, $old_instance ) {

		$instance                               = array();
		$instance['cst_breaking_news_story_id'] = intval( $new_instance['cst_breaking_news_story_id'] );

		return $instance;

	}

}
