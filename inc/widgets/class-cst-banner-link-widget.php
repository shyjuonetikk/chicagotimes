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

		add_action( 'admin_enqueue_scripts', [ $this, 'banner_widget_css' ] );

	}

	function banner_widget_css( $hook ) {
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
			<div class="large-12 banner-link show-for-large-up">
				<a href="<?php echo esc_url( $instance['cst_banner_link_url'] ); ?>">
					<img src="<?php echo esc_url( $instance['cst_banner_link_image'] ); ?>" />
				</a>
			</div>
		</div>
		<?php

	}

	public function form( $instance ) {

		$this->admin_setup();

		$cst_banner_link_title = ( isset( $instance['cst_banner_link_title'] ) ) ? $instance['cst_banner_link_title'] : '';
		$cst_banner_link_image = ( isset( $instance['cst_banner_link_image'] ) ) ? $instance['cst_banner_link_image'] : '';
		$cst_banner_link_url   = ( isset( $instance['cst_banner_link_url'] ) ) ? $instance['cst_banner_link_url'] : '';

		?>

		<div class="cst_banner_link_widget">
			<p>Choose an image for your banner, enter the url to goto when the banner is clicked.</p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'cst_banner_link_image' ) ); ?>">
					<?php esc_html_e( 'Image to use for the banner:' ); ?>
				</label>
				<input
					class="cst_banner_link_image widefat"
					id="<?php echo esc_attr( $this->get_field_id( 'cst_banner_link_image' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'cst_banner_link_image' ) ); ?>"
					value="<?php echo esc_attr( $cst_banner_link_image ); ?>"
					type="text"
				>
			<button
					id="cst_banner_link_image_button"
					class="button"
					onclick="image_button_click( 'Choose Title Image', 'Select Image', 'image', 'cst_banner_link_image_preview', '<?php echo esc_attr( $this->get_field_id( 'cst_banner_link_image' ) ); ?>');"
			>Select Image</button>
			<hr>
			<div id="cst_banner_link_image_preview" class="preview_placeholder">
				<?php
				if ( '' !== $cst_banner_link_image ) {
					echo '<img src="' . esc_url( $cst_banner_link_image ) . '">';
				}
				?>
			</div>
			<hr>
				<label for="<?php echo esc_attr( $this->get_field_id( 'cst_banner_link_url' ) ); ?>">
					<?php esc_html_e( 'Click thru URL for the above banner:' ); ?>
				</label>
				<input
					class="cst_banner_link_url widefat"
					id="<?php echo esc_attr( $this->get_field_id( 'cst_banner_link_url' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'cst_banner_link_url' ) ); ?>"
					value="<?php echo esc_url( $cst_banner_link_url ); ?>"
					type="text"
				><br/>
		</div>

		<?php
	}

	public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['cst_banner_link_title'] = ( ! empty( $new_instance['cst_banner_link_title'] ) ) ? strip_tags( $new_instance['cst_banner_link_title'] ) : '';
		$instance['cst_banner_link_url'] = ( ! empty( $new_instance['cst_banner_link_url'] ) ) ? strip_tags( $new_instance['cst_banner_link_url'] ) : '';
		$instance['cst_banner_link_image'] = ( ! empty( $new_instance['cst_banner_link_image'] ) ) ? strip_tags( $new_instance['cst_banner_link_image'] ) : '';
		return $instance;

	}

}