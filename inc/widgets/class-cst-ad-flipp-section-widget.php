<?php

class CST_Ad_Flipp_Section_Widget extends WP_Widget {

	public function __construct() {

		parent::__construct(
			'CST_Ad_Flipp_Section_Widget',
			esc_html__( 'CST Ad Flipp Section Widget', 'chicagosuntimes' ),
			[
				'description'                 => esc_html__( 'Flipp circular for section pages', 'chicagosuntimes' ),
				'customize_selective_refresh' => true,
			]
		);

	}

	public function enqueue_scripts() {

		wp_enqueue_script( 'cst_ad_flipp_section', '//api.circularhub.com/10381/2e2e1d92cebdcba9/circularhub_module.js' );
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

		<div id="circularhub_module_10381" style="background-color: #ffffff; margin: 5px; padding: 5px;"></div>

		<?php

		echo wp_kses_post( $args['after_widget'] );
		$this->enqueue_scripts();
	}

	/**
	 * Outputs the options form on admin
	 *
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

