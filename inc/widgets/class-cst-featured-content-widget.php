<?php

class CST_Featured_Content_Widget extends WP_Widget {

	public function __construct() {

		parent::__construct(
			'cst_featured_content_widget',
			esc_html__( 'CST Featured Content', 'chicagosuntimes' ),
			array(
				'description' => esc_html__( 'Set Featured Content displayed in the sidebar.', 'chicagosuntimes' ),
			)
		);

		add_action( 'wp_ajax_cst_featured_content_get_posts', array( $this, 'cst_featured_content_get_posts' ) );
		
	}

	/**
	* Get all published posts to display in Select2 dropdown
	*/
	public function cst_featured_content_get_posts() {

		if ( ! wp_verify_nonce( $_GET['nonce'], 'cst-featured-content-widget' )
			|| ! current_user_can( 'edit_others_posts' ) ) {
			wp_send_json_error();
		}

		$term = sanitize_text_field( $_GET['searchTerm'] );

		$search_args = array(
								'post_type'            => CST()->get_post_types(),
								's'					   => $term,
							);
		$search_query = new WP_Query( $search_args );

		$returning = array();
		$posts = array();

		if ( $search_query->have_posts() ):

				while( $search_query->have_posts() ) : $search_query->the_post();
					$obj = \CST\Objects\Post::get_by_post_id( get_the_ID() );
					if($obj) {
						$content_type = str_replace( 'cst_', '', $obj->get_post_type() );
						$posts['id'] = $obj->get_id();
						$posts['text'] = $obj->get_title() . ' [' . $content_type . ']';
						array_push( $returning, $posts );
					}
					
				endwhile;
		endif;

		echo json_encode($returning);
		exit();
		
	}

	public function enqueue_scripts() {

		wp_enqueue_script( 'cst-featured-content-widget', get_template_directory_uri() . '/assets/js/featured-content-widget.js', array( 'jquery' ) );
		wp_localize_script( 'cst-featured-content-widget', 'CSTFeaturedContentWidgetData', array(
			'placeholder_text'       => esc_html__( 'Search for content to feature', 'chicagosuntimes' ),
			'nonce'                  => wp_create_nonce( 'cst-featured-content-widget' ),
		) );
		wp_enqueue_style ( 'select2', get_template_directory_uri() . '/assets/js/vendor/select2/select2.css' );
		wp_enqueue_script( 'select2', get_template_directory_uri() . '/assets/js/vendor/select2/select2.min.js' );

	}

	public function widget( $args, $instance ) {

		if ( empty( $instance['cst_featured_story_id'] ) ) {
			return;
		}

		$featured_story_id    = $instance['cst_featured_story_id'];
		$obj = \CST\Objects\Post::get_by_post_id( $featured_story_id );

		if( !$obj) {
			return;
		}

		$featured_text = str_replace( 'cst_', '', $obj->get_post_type() );

		echo $args['before_widget'];

		?>
		

		<div class="featured-story">
			<?php echo $args['before_title']; ?>
				<?php if( $obj->get_post_type() != 'cst_article' ) { ?><i class="fa fa-<?php echo esc_attr( $obj->get_font_icon() ); ?>"></i><?php } ?> <?php esc_html_e( 'Featured', 'chicagosuntimes' ); ?> <?php echo esc_html( $featured_text ); ?>
			<?php echo $args['after_title']; ?>
			<?php if( $obj->get_featured_image_html() ) : ?>
			<div class="featured-story-image <?php echo ( $obj->get_post_type() != 'cst_article' ? 'hover-state' : 'featured-article' ); ?>">
				<a href="<?php echo $obj->the_permalink(); ?>">
					<?php echo $obj->get_featured_image_html( 'chiwire-featured-content-widget' ); ?>
					<?php if ( $obj->get_post_type() != 'cst_article' ) { ?>
						<i class="fa fa-<?php echo esc_attr( $obj->get_font_icon() ); ?>"></i>
					<?php } ?>
				</a>
			</div>
			<?php endif; ?>
			<div class="featured-story-body">
		 	<?php if ( $section = $obj->get_primary_section() ) : ?>
				<span class="section">
					<a href="<?php echo esc_url( wpcom_vip_get_term_link( $section ) ); ?>"><?php echo esc_html( $section->name ); ?></a> 
				</span><br/>
			<?php endif; ?>
				<h3 class="title">
					<a href="<?php echo $obj->the_permalink(); ?>"><?php echo $obj->the_title(); ?></a>
				</h3>
			</div>
		</div>

		<?php
		
		echo $args['after_widget'];

	}

	public function form( $instance ) {

		$this->enqueue_scripts();

		$featured_story_id = ! empty( $instance['cst_featured_story_id'] ) ? $instance['cst_featured_story_id'] : '';
		$obj = \CST\Objects\Post::get_by_post_id( $featured_story_id );
		if ( $obj ) {
			$content_type = str_replace( 'cst_', '', $obj->get_post_type() );
			$story_title = $obj->get_title() . ' [' . $content_type . ']';
		} else {
			$story_title = '';
		}

		?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'cst_featured_story_id' ) ); ?>">
					<?php esc_html_e( 'Featured Content', 'chicagosuntimes' ); ?>:
				</label>
				<input class="cst-featured-story-id" id="<?php echo esc_attr( $this->get_field_id( 'cst_featured_story_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cst_featured_story_id' ) ); ?>" value="<?php echo esc_attr( $featured_story_id ); ?>" data-story-title="<?php echo esc_attr( $story_title ); ?>" style="width:400px;" />
			</p>
		<?php
	
	}

	public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['cst_featured_story_id'] = intval( $new_instance['cst_featured_story_id'] );

		return $instance;

	}

}
