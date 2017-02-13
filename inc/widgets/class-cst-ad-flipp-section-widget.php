<?php

class CST_Ad_Flipp_Section_Widget extends WP_Widget {

	public function __construct() {

		parent::__construct(
			'CST_Ad_Flipp_Section_Widget',
			esc_html__( 'CST Ad Flipp Section Widget', 'chicagosuntimes' ),
			array(
				'description' => esc_html__( 'Flipp circular for section pages', 'chicagosuntimes' ),
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
		echo $args['before_widget'];
		?>

		<div id="circularhub_module_10381" style="background-color: #ffffff; margin: 5px; padding: 5px;"></div>
		<script src="//api.circularhub.com/10381/2e2e1d92cebdcba9/circularhub_module.js"></script>

		<?php
		echo $args['after_widget'];

	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
	}
}

