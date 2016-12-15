<?php

class CST_Ad_Widget extends WP_Widget {


	protected $ad_units = array(
		'dfp-rr-cube-1' => 'rr cube 1',
		'dfp-rr-cube-2' => 'rr cube 2',
		'dfp-rr-cube-3' => 'rr cube 3',
		'dfp-rr-cube-4' => 'rr cube 4',
		'dfp-rr-cube-5' => 'rr cube 5',
		'dfp-rr-cube-6' => 'rr cube 6',
		'dfp-rr-cube-promo-7' => 'rr cube 7',
		'dfp-polar-8' => 'rr cube 8',
		);

	protected $defaults = array(
		'ad_unit'  => 'dfp-rr-cube-1',
		);

	public function __construct() {

		parent::__construct(
			'cst_ad_widget',
			esc_html__( 'CST Right Rail Ad Widget', 'chicagosuntimes' ),
			array(
				'description' => esc_html__( 'Displays a right rail ad unit.', 'chicagosuntimes' ),
			)
		);

	}

	public function widget( $args, $instance ) {

		$instance = array_merge( $this->defaults, $instance );

		$targeting_name = $this->ad_units[ $instance['ad_unit'] ];
		$widget_number = explode( '-', $this->id );
		$ad_unit_index = (int) $widget_number[1] + 100;
		echo $args['before_widget'];
		echo CST()->dfp_handler->dynamic_unit( $ad_unit_index , 'div-gpt-rr-cube', 'dfp dfp-cube', is_singular() ? 'cube_mapping' : 'sf_mapping', $targeting_name );
		echo $args['after_widget'];

		if ( 'dfp-polar' === $instance['ad_unit'] ) {
			wp_enqueue_script( 'cst-polar-ads', get_template_directory_uri() . '/assets/js/polar.js', array( 'jquery' ) );
		}

	}

	public function form( $instance ) {

		$current_unit = isset( $instance['ad_unit'] ) ? $instance['ad_unit'] : '';

		?>

	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'ad_unit' ) ); ?>"><?php esc_html_e( 'Ad Unit', 'chicagosuntimes' ); ?>:</label>
		<select class="widefat cst-ad-widget" id="<?php echo esc_attr( $this->get_field_id( 'ad_unit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ad_unit' ) ); ?>" data-current-unit="<?php echo esc_attr( $current_unit ); ?>">
		<?php foreach ( $this->ad_units as $ad_unit => $ad_target ) : ?>
			<option value="<?php echo esc_attr( $ad_unit ); ?>" <?php selected( $ad_unit, $current_unit ); ?>><?php echo esc_html( $ad_unit ); ?></option>
		<?php endforeach; ?>
		</select>
	</p>

	<?php }

	public function update( $new_instance, $old_instance ) {

		$instance = array();

		if ( isset( $this->ad_units[ $new_instance['ad_unit'] ] ) ) {
			$instance['ad_unit'] = $new_instance['ad_unit'];
		}

		return $instance;
	}

}