<?php

class CST_CB_Trending_Widget extends WP_Widget {

	public function __construct() {

		parent::__construct(
			'CST_CB_Trending_Widget',
			esc_html__( 'CST Chartbeat', 'chicagosuntimes' ),
			array(
				'description' => esc_html__( 'Displays Chartbeat live trending content.', 'chicagosuntimes' ),
			)
		);

	}

	public function widget( $args, $instance ) {
		if ( is_front_page() ) {
			echo wp_kses_post( '<div class="small-12 content-wrapper"><hr class="before"><h2 class="section-title"><span>Currently trending:</span></h2><hr>' );
		} else {
			echo wp_kses_post( $args['before_widget'] );
			echo wp_kses_post( $args['before_title'] . 'Currently Trending (live and retaining)' . $args['after_title'] );
		}
		?>
		<div id="root"></div>
		<?php if ( is_front_page() ) {
			echo wp_kses_post( '</div>' );
		}else if ( is_singular() || is_tax() || is_post_type_archive() ) {
			echo wp_kses_post( $args['after_widget'] );
		}
		wp_enqueue_script( 'cb-stats-js', esc_url(( get_stylesheet_directory_uri() . '/assets/static/js/main.e86ee534.js' ) ) );
		wp_enqueue_style( 'cb-stats-css', esc_url( get_stylesheet_directory_uri() . '/assets/static/css/main.1eccd2fd.css' ) );
	}

	public function form( $instance ) {
	}

	public function update( $new_instance, $old_instance ) {
	}

}