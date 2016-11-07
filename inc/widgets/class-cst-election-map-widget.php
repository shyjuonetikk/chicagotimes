<?php

/**
 * Class cst_election_2016_more_headlines_Widget
 *
 * Version 2
 *
 */
class CST_Elections_2016_Map_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'cst_election_2016_map',
			esc_html__( 'CST Election AP map', 'chicagosuntimes' ),
			array(
				'description' => esc_html__( 'Displays Election AP Map.', 'chicagosuntimes' ),
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

		if ( shortcode_exists( 'election-2016-nov' ) ) {
			echo do_shortcode( '[election-2016-nov page="general-election" height="491px"]' );
		}

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
