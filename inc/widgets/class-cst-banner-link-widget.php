<?php

class CST_Banner_Link_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = [
			'description'                 => esc_html__( 'Display a banner image with article link', 'chicagosuntimes' ),
			'customize_selective_refresh' => true,
		];
		parent::__construct(
			'CST_Banner_Link_Widget',
			esc_html__( 'CST Banner Link Widget', 'chicagosuntimes' ),
			$widget_ops
		);

		add_action( 'sidebar_admin_setup', array( $this, 'admin_setup' ) );

	}

	function admin_setup() {

		wp_enqueue_media();
		wp_register_script(
			'cst-banner-link-js',
			get_template_directory_uri() . '/assets/js/cst-banner-link-widget.js',
			[ 'jquery', 'media-upload', 'media-views' ]
		);
		wp_enqueue_script( 'cst-banner-link-js' );

		add_action( 'admin_enqueue_scripts', [ $this, 'banner_widget_css' ] );

	}

	function banner_widget_css( $hook ) {
		if ( 'widgets.php' !== $hook ) {
			return;
		}

		wp_register_style( 'cst-widget-wp-admin-css', get_template_directory_uri() . '/assets/css/cst-widget-admin-style.css', false, '1.0.0' );
		wp_enqueue_style( 'cst-widget-wp-admin-css' );
	}

	public function widget( $args, $instance ) {
		$img_src    = wp_get_attachment_image_url( $instance['cst_banner_link_id'], 'full-size' );
		$img_srcset = wp_get_attachment_image_srcset( $instance['cst_banner_link_id'], 'medium' );

		?>
		<li class="large-12 banner-link text-center widget">
			<a href="<?php echo esc_url( $instance['cst_banner_link_url'] ); ?>">
				<img src="<?php echo esc_url( $img_src ); ?>"
					srcset="<?php echo esc_attr( $img_srcset ); ?>"
					sizes="(min-width: 40em) 100vw, (min-width: 44em) 100vw, (min-width: 47.3em) 100vw, 767px, (min-width: 64em) 100vw, 970px" alt="<?php echo esc_attr( get_the_title( $instance['cst_banner_link_id'] ) ); ?>">
			</a>
		</li>
		<?php

	}

	public function form( $instance ) {

		$this->admin_setup();

		$cst_banner_link_title = ( isset( $instance['cst_banner_link_title'] ) ) ? $instance['cst_banner_link_title'] : '';
		$cst_banner_link_image = ( isset( $instance['cst_banner_link_image'] ) ) ? $instance['cst_banner_link_image'] : '';
		$cst_banner_link_url   = ( isset( $instance['cst_banner_link_url'] ) ) ? $instance['cst_banner_link_url'] : '';
		$cst_banner_link_id    = ( isset( $instance['cst_banner_link_id'] ) ) ? $instance['cst_banner_link_id'] : '';

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
					type="hidden"
			>
			<button
					id="cst_banner_link_image_button"
					class="button"
					onclick="image_button_click(
							'Choose Title Image',
							'Select Image',
							'image',
							'cst_banner_link_image_preview',
							'<?php echo esc_attr( $this->get_field_id( 'cst_banner_link_image' ) ); ?>',
							'<?php echo esc_attr( $this->get_field_id( 'cst_banner_link_id' ) ); ?>');"
			>Select Image
			</button>
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
			>
			<input
					id="<?php echo esc_attr( $this->get_field_id( 'cst_banner_link_id' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'cst_banner_link_id' ) ); ?>"
					value="<?php echo esc_attr( $cst_banner_link_id ); ?>"
					type="hidden"
			><br/>
		</div>

		<?php
	}

	public function update( $new_instance, $old_instance ) {

		$instance                          = array();
		$instance['cst_banner_link_title'] = ( ! empty( $new_instance['cst_banner_link_title'] ) ) ? strip_tags( $new_instance['cst_banner_link_title'] ) : '';
		$instance['cst_banner_link_url']   = ( ! empty( $new_instance['cst_banner_link_url'] ) ) ? strip_tags( $new_instance['cst_banner_link_url'] ) : '';
		$instance['cst_banner_link_id']    = ( ! empty( $new_instance['cst_banner_link_id'] ) ) ? strip_tags( $new_instance['cst_banner_link_id'] ) : '';
		$instance['cst_banner_link_image'] = ( ! empty( $new_instance['cst_banner_link_image'] ) ) ? strip_tags( $new_instance['cst_banner_link_image'] ) : '';

		return $instance;

	}

}