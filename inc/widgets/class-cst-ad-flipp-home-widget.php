<?php

class CST_Ad_Flipp_Home_Widget extends WP_Widget {

	public function __construct() {
		$widget_options = array(
			'classname'   => 'Flipp_Home_Widget',
			'description' => 'Flipp for home page',
		);
		parent::__construct( 'CST_Ad_Flipp_Home_Widget', 'CST Ad Flipp Home Widget', $widget_options );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		?>

		<div id="circularhub_module_10380" style="background-color: #ffffff; margin-bottom: 10px; padding: 5px 5px 0px 5px;"></div>
		<script src="//api.circularhub.com/10380/2e2e1d92cebdcba9/circularhub_module.js"></script>

		<?php
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
