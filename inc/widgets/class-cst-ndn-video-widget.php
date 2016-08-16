<?php

class CST_Inform_Video_Widget extends WP_Widget {

	private $inform_video_options = array(
		'Homepage' => array(
			'data-config-widget-id' => '32311',
			'data-config-type' => 'VideoLauncher/Slider300x250',
			'data-config-tracking-group' => '58285',
			'data-config-site-section' => 'chicagosun_hom_non_non',
		),
		'Section_fronts' => array(
			'data-config-widget-id' => '25916',
			'data-config-type' => 'VideoLauncher/Slider300x250',
			'data-config-tracking-group' => '58285',
			'data-config-site-section' => 'suntimes_section',
		),
		'Article_page_slider' => array(
			'data-config-widget-id' => '25915',
			'data-config-type' => 'VideoLauncher/Slider300x250',
			'data-config-tracking-group' => '58285',
			'data-config-site-section' => 'suntimes_nws_non_sty',
		),
	);
	private $format = '<div class="ndn_embed" 
data-config-widget-id="%1$s" 
data-config-type="%2$s"
data-config-tracking-group="%3$s"
data-config-site-section="%4$s"
></div>';

	public function __construct() {

		parent::__construct(
			'cst_inform_video',
			esc_html__( 'CST Inform Video', 'chicagosuntimes' ),
			array(
				'description' => esc_html__( 'Choose and display the Inform Video.', 'chicagosuntimes' ),
			)
		);

	}

	public function widget( $args, $instance ) {
		$script_url = get_stylesheet_directory_uri() . '/assets/js/cst-inform.js';
		wp_enqueue_script( 'cst-inform', esc_url( $script_url ), array( 'jquery' ), null, true );
		?>
			<div class="large-12 medium-6 small-6 columns">
				<div class="row">
					<?php
					$inform_markup = sprintf( $this->format,
						esc_attr( $this->inform_video_options[ $instance['inform_video_option'] ]['data-config-widget-id'] ),
						esc_attr( $this->inform_video_options[ $instance['inform_video_option'] ]['data-config-type'] ),
						esc_attr( $this->inform_video_options[ $instance['inform_video_option'] ]['data-config-tracking-group'] ),
						esc_attr( $this->inform_video_options[ $instance['inform_video_option'] ]['data-config-site-section'] )
					);
					echo wp_kses( $inform_markup, array(
						'div' => array(
						'class' => array(),
						'data-config-widget-id' => array(),
						'data-config-type' => array(),
						'data-config-tracking-group' => array(),
						'data-config-site-section' => array(),
						),
						)
					);
					?>
				</div>
			</div>
		<?php
	}

	public function form( $instance ) {
		$current_inform_option = isset( $instance['inform_video_option'] ) ? $instance['inform_video_option'] : '' ;
	?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'inform_video_option' ) ); ?>"><?php echo esc_html( 'Choose video player option', 'chicagosuntimes' ); ?>:</label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'inform_video_option' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'inform_video_option' ) ); ?>" data-current-unit="<?php echo esc_attr( $current_inform_option ); ?>">
				<?php foreach ( $this->inform_video_options as $inform_video_option => $inform_option_name ) { ?>
					<option value="<?php echo esc_attr( $inform_video_option ); ?>" <?php selected( $inform_video_option, $current_inform_option ); ?>><?php echo esc_html( str_replace( '_', '-', $inform_video_option ) ); ?></option>
				<?php } ?>
			</select>
		</p>
	<?php

	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['inform_video_option'] = ( ! empty( $new_instance['inform_video_option'] ) ) ? esc_attr( $new_instance['inform_video_option'] ) : '';
		return $instance;
	}

}