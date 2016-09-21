<?php

class CST_Gracenote_Sports_Widget extends WP_Widget {

	private $gracenote_sports_options = array(
		'MLB' => array(
			'order' => 'MLB;NFL;NBA;NCAAF;NCAAB',
		),
		'NFL' => array(
			'order' => 'NFL;MLB;NBA;NCAAF;NCAAB',
		),
		'NBA' => array(
			'order' => 'NBA;NFL;MLB;NCAAF;NCAAB',
		),
		'NCAAF' => array(
			'order' => 'NCAAF;NFL;MLB;NBA;NCAAB',
		),
		'NCAAB' => array(
			'order' => 'NCAAB;NFL;MLB;NBA;NCAAF',
		),
	);
	private $format = '<iframe frameborder="0" src="http://scores.suntimes.com/sports-scores/score-carousel.aspx?Leagues=%1$s&amp;numVisible=5&amp;isVertical=true" style="border:none; width:100%%; height:520px;" allowtransparency="true" scrolling="no">Live Scores</iframe>';

	public function __construct() {

		parent::__construct(
			'cst_gracenote_sports',
			esc_html__( 'CST Gracenote Sports', 'chicagosuntimes' ),
			array(
				'description' => esc_html__( 'Choose and display the Gracenote.', 'chicagosuntimes' ),
			)
		);

	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		?>
			<div class="small-12 columns">
				<?php
				$inform_markup = sprintf( $this->format,
					esc_attr( $this->gracenote_sports_options[ $instance['gracenote_sports_options'] ]['order'] )
				);
				echo $inform_markup;
				?>
			</div>
		<?php
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$current_inform_option = isset( $instance['gracenote_sports_options'] ) ? $instance['gracenote_sports_options'] : '' ;
	?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'gracenote_sports_options' ) ); ?>"><?php echo esc_html( 'Choose Gracenote option', 'chicagosuntimes' ); ?>:</label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'gracenote_sports_options' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'gracenote_sports_options' ) ); ?>" data-current-unit="<?php echo esc_attr( $current_inform_option ); ?>">
				<?php foreach ( $this->gracenote_sports_options as $gracenote_sport_option => $inform_option_name ) { ?>
					<option value="<?php echo esc_attr( $gracenote_sport_option ); ?>" <?php selected( $gracenote_sport_option, $current_inform_option ); ?>><?php echo esc_html( str_replace( '_', '-', $gracenote_sport_option ) ); ?></option>
				<?php } ?>
			</select>
		</p>
	<?php

	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['gracenote_sports_options'] = ( ! empty( $new_instance['gracenote_sports_options'] ) ) ? esc_attr( $new_instance['gracenote_sports_options'] ) : '';
		return $instance;
	}

}