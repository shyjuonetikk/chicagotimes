<?php

class CST_Drive_Chicago_Widget extends WP_Widget {

	protected $drive_chicago_images = array(
		'lease-image'  => 'Drive Chicago Lease',
		'search-image' => 'Drive Chicago Search',
	);

	private $template = '<a href="%1$s" target="_blank">
	<img src="%2$s" alt="%3$s" />
	</a>';

	public function __construct() {

		parent::__construct(
			'cst_drive_chicago',
			esc_html__( 'CST Drive Chicago', 'chicagosuntimes' ),
			array(
				'description' => esc_html__( 'Display a Drive Chicago Ad.', 'chicagosuntimes' ),
			)
		);

	}

	public function widget( $args, $instance ) {
		$url = 'http://www.drivechicago.com';
		$available_images = array(
			'lease-image' => get_template_directory_uri() . '/assets/images/drive-chicago-lease-cube.png',
			'search-image' => get_template_directory_uri() . '/assets/images/drive-chicago-search-cube.png',
		);
		$image = $available_images[ $instance['chicago_drive_widget'] ];
		echo $args['before_widget'];
		?>
		<div class="row">
			<div class="large-12 medium-6 small-6 columns">
				<?php
				echo sprintf( $this->template,
					esc_url( $url ),
					esc_url( $image ),
					esc_attr( 'Drive Chicago' )
				);
				?>
			</div>
		</div>
		<?php
		echo $args['after_widget'];

	}

	public function form( $instance ) {

		$current_drive = isset( $instance['chicago_drive_widget'] ) ? $instance['chicago_drive_widget'] : '';
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'chicago_drive_widget' ) ); ?>"><?php esc_html_e( 'Chicago Drive Widget', 'chicagosuntimes' ); ?>:</label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'chicago_drive_widget' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'chicago_drive_widget' ) ); ?>"
					data-current-unit="<?php echo esc_attr( $current_drive ); ?>">
				<?php foreach ( $this->drive_chicago_images as $index => $drive_widget ) { ?>
					<option value="<?php echo esc_attr( $index ); ?>" <?php selected( $index, $current_drive ); ?>><?php echo esc_html( $drive_widget ); ?></option>
				<?php } ?>
			</select>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {

		$instance = array();
		if ( array_key_exists( $new_instance['chicago_drive_widget'], $this->drive_chicago_images ) ) {
			$instance['chicago_drive_widget'] = $new_instance['chicago_drive_widget'];
		}

		return $instance;
	}

}