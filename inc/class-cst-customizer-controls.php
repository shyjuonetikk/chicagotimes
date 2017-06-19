<?php
if ( class_exists( 'WP_Customize_Control' ) ) {
	/**
	 * CST Custom Select2 dropdown controller
	 */
	class WP_Customize_CST_Select_Control extends \WP_Customize_Control {
		public $type = 'cst_select_control'; // the name for the control

		public function __construct( $manager, $id, $args = array(), $options = array() ) {
			parent::__construct( $manager, $id, $args );
			$this->setup_actions();
		}

		public function setup_actions() {
			add_action( 'customize_controls_enqueue_scripts', [ $this, 'custom_control_enqueue' ] );
		}
		public function custom_control_enqueue() {
			wp_enqueue_script( 'cst_customizer_control', esc_url( get_stylesheet_directory_uri() . '/assets/js/cst-customize-control.js' ), array( 'customize-controls', 'select2' ), '1.0', true );
			wp_localize_script( 'cst_customizer_control', 'CSTCustomizerControlData', array(
				'placeholder_text' => esc_html__( '!Choose article', 'chicagosuntimes' ),
				'nonce'            => wp_create_nonce( 'cst_customizer_control_homepage_headlines' ),
			) );
			wp_enqueue_style( 'select2', get_template_directory_uri() . '/assets/js/vendor/select2/select2.css' );
			wp_enqueue_script( 'select2', get_template_directory_uri() . '/assets/js/vendor/select2/select2.min.js' );
		}

		/**
		 * Renders the control within the Customizer Panel
		 *
		 * In the case of this control we setup an input field
		 * in cst-customize-control.js we initialize the field based on this->id naming
		 */
		public function render_content() {
			$headline = get_theme_mod( $this->id );
			$obj      = get_post( $headline );
			if ( $obj ) {
				$content_type = get_post_type( $obj->ID );
				$story_title  = $obj->post_title . ' [' . $content_type . ']';
			} else {
				if ( $headline === $this->id ) {
					$story_title = $this->input_attrs['placeholder'];
				} else {
					$story_title = 'No article found';
				}
			}
			if ( isset( $this->input_attrs['data-related-section'] ) && ! empty( $this->input_attrs['data-related-section'] ) ) {
				$related_section = $this->input_attrs['data-related-section'];
			}
			?>
			<label for="<?php echo esc_attr( $this->id ); ?>">
				<?php esc_html_e( $this->label, 'chicagosuntimes' ); ?>
			</label>
			<input class="widefat <?php echo esc_attr( $this->id ); ?>" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $headline ); ?>"
				   placeholder="<?php echo esc_attr( $this->input_attrs['placeholder'] ); ?>" data-story-title="<?php echo esc_attr( $story_title ); ?>" data-related-section="<?php echo esc_attr( $related_section ); ?>"/>
			<?php
		}
	}
}