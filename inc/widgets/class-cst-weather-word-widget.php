<?php

class CST_Weather_Word_Widget extends WP_Widget {

	protected $defaults = array(
		'cst_weather_word_content'  => '',
		);

	public function __construct() {

		parent::__construct(
			'cst_weather_word',
			esc_html__( 'CST Homepage Weather Word', 'chicagosuntimes' ),
			array(
				'description' => esc_html__( 'Displays the Weather Word.', 'chicagosuntimes' ),
			)
		);

	}

	public function widget( $args, $instance ) {

		$instance = array_merge( $this->defaults, $instance );

		$weather_word = $instance['cst_weather_word_content'];
		?>
		<span class="weather-word"><?php echo $weather_word; ?></span><br/>
		<?php
	}

	public function form( $instance ) {

		$instance = array_merge( $this->defaults, $instance );

		$weather_word = $instance['cst_weather_word_content'];
?>
	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'cst_weather_word_content' ) ); ?>"><?php esc_html_e( 'Weather Word:', 'chicagosuntimes' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cst_weather_word_content' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cst_weather_word_content' ) ); ?>" type="text" value="<?php echo esc_attr( $weather_word ); ?>" />
	</p>
<?php
	}

	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['cst_weather_word_content'] = sanitize_text_field( $new_instance['cst_weather_word_content'] );
		return $instance;

	}

}