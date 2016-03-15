<?php

/**
 * Class cst_election_2016_more_headlines_Widget
 *
 * Version 2
 *
 */
class CST_Elections_2016_More_Headlines_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'cst_election_2016_more_headlines',
			esc_html__( 'CST Election AP content', 'chicagosuntimes' ),
			array(
				'description' => esc_html__( 'Displays Election AP Widgets.', 'chicagosuntimes' ),
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

		get_template_part( 'parts/homepage/election-more-wells' );

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
	}
}
