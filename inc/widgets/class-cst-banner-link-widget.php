<?php
class CST_Banner_Link_Widget extends WP_Widget {

	function __construct() {

		parent::__construct(
			'CST_Banner_Link_Widget',
			__( 'CST Banner Link Widget', 'lagoon' ),
			array( 'description' => __( 'Display a banner image with article link', 'chicagosuntimes' ) ) // Args
		);

		add_action( 'sidebar_admin_setup', array( $this, 'admin_setup' ) );

	}

	function admin_setup() {

		wp_enqueue_media();
		wp_register_script(
			'cst-banner-link-js',
			get_template_directory_uri() . '/assets/js/cst-banner-link-widget.js',
			array( 'jquery', 'media-upload', 'media-views' )
		);
		wp_enqueue_script( 'cst-banner-link-js' );

		add_action( 'admin_enqueue_scripts', [ $this, 'my_enqueue' ] );

	}

	function my_enqueue( $hook ) {
		if ( 'widgets.php' !== $hook ) {
			return;
		}

		wp_register_style( 'cst-widget-wp-admin-css', get_template_directory_uri() . '/assets/css//cst-widget-admin-style.css', false, '1.0.0' );
		wp_enqueue_style( 'cst-widget-wp-admin-css' );
	}
	public function widget( $args, $instance ) {

		$upload_dir = wp_upload_dir();


		?>
		<div class="row">
			<a href="<?php echo esc_url( $instance['cst_sponsored_tag_url'] ); ?>">
				<img src="<?php echo esc_url( $instance['cst_sponsored_tag_image'] ); ?>" />
			</a>
		</div>
		<?php

	}

	public function form( $instance ) {

		$this->admin_setup();

		$cst_sponsored_tag_title = ( isset( $instance['cst_sponsored_tag_title'] ) ) ? $instance['cst_sponsored_tag_title'] : '';
		$cst_sponsored_tag_image = ( isset( $instance['cst_sponsored_tag_image'] ) ) ? $instance['cst_sponsored_tag_image'] : '';
		$cst_sponsored_tag_url   = ( isset( $instance['cst_sponsored_tag_url'] ) ) ? $instance['cst_sponsored_tag_url'] : '';

		?>

		<div class="cst_sponsored_tag_widget">
			<p>Choose an image the click through url for that image.</p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'cst_sponsored_tag_image' ) ); ?>">
					<?php esc_html_e( 'Image :' ); ?>
				</label>
				<input
					class="cst_sponsored_tag_image widefat"
					id="<?php echo esc_attr( $this->get_field_id( 'cst_sponsored_tag_image' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'cst_sponsored_tag_image' ) ); ?>"
					value="<?php echo esc_attr( $cst_sponsored_tag_image ); ?>"
					type="text"
				>
				<button
					id="cst_sponsored_tag_image_button"
					class="button"
					onclick="image_button_click( 'Choose Title Image', 'Select Image', 'image', 'cst_sponsored_tag_image_preview', '<?php echo esc_attr( $this->get_field_id( 'cst_sponsored_tag_image' ) ); ?>');"
				>Select Image</button>
			<div id="cst_sponsored_tag_image_preview" class="preview_placholder">
				<?php
				if ( '' !== $cst_sponsored_tag_image ) {
					echo '<img src="' . esc_url( $cst_sponsored_tag_image ) . '">';
				}
				?>
			</div>
			<hr/>
				<label for="<?php echo esc_attr( $this->get_field_id( 'cst_sponsored_tag_url' ) ); ?>"><?php esc_html_e( 'Click thru URL:' ); ?></label>
				<input
					class="cst_sponsored_tag_url widefat"
					id="<?php echo esc_attr( $this->get_field_id( 'cst_sponsored_tag_url' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'cst_sponsored_tag_url' ) ); ?>"
					value="<?php echo esc_attr( $cst_sponsored_tag_url ); ?>"
					type="text"
				><br/>
		</div>

		<?php
	}

	public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['cst_sponsored_tag_title'] = ( ! empty( $new_instance['cst_sponsored_tag_title'] ) ) ? strip_tags( $new_instance['cst_sponsored_tag_title'] ) : '';
		$instance['cst_sponsored_tag_url'] = ( ! empty( $new_instance['cst_sponsored_tag_url'] ) ) ? strip_tags( $new_instance['cst_sponsored_tag_url'] ) : '';
		$instance['cst_sponsored_tag_image'] = ( ! empty( $new_instance['cst_sponsored_tag_image'] ) ) ? strip_tags( $new_instance['cst_sponsored_tag_image'] ) : '';
		return $instance;

	}

}