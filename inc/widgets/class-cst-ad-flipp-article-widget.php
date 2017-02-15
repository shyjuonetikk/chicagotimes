<?php

class CST_Ad_Flipp_Article_Widget extends WP_Widget {

	public function __construct() {

		parent::__construct(
			'CST_Ad_Flipp_Article_Widget',
			esc_html__( 'CST Ad Flipp Article Widget', 'chicagosuntimes' ),
			array(
				'description' => esc_html__( 'Flipp circular for article pages', 'chicagosuntimes' ),
			)
		);

	}    

    public function enqueue_scripts() {

        wp_enqueue_script( 'cst_ad_flipp_article', '//api.circularhub.com/10382/2e2e1d92cebdcba9/circularhub_module.js' ); 
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

		<div id="circularhub_module_10382" style="background-color: #ffffff; margin-bottom: 10px; padding: 5px 5px 0px 5px;"></div>

		<?php

		echo wp_kses_post( $args['after_widget'] );
        $this->enqueue_scripts();
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

