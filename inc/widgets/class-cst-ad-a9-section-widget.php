<?php

class CST_Ad_A9_Section_Widget extends WP_Widget {

	public function __construct() {

		parent::__construct(
			'CST_Ad_A9_Section_Widget',
			esc_html__( 'CST Ad A9 Section Widget', 'chicagosuntimes' ),
			array(
				'description' => esc_html__( 'A9 for section pages', 'chicagosuntimes' ),
			)
		);

	}
    
	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
    
	public function widget( $args, $instance ) {
		echo wp_kses_post( $args['before_widget'] );
		?>

		<div id="div-gpt-test-a9-right-rail"></div>

		<?php

		echo wp_kses_post( $args['after_widget'] );
	}

	/**
	 * Outputs the options form on admin
	 * @param array $instance
	 *
	 * @return string
	 */
	public function form( $instance ) {
		// outputs the options form on admin
		return 'noform';
	}

	/**
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		return $new_instance;
	}
}

