<?php
if( class_exists( 'WP_Customize_Control' ) ) {
	class WP_Customize_Hero_Select_Control extends WP_Customize_Control {
		public $type = 'cst_select_control';

		public function __construct( $manager, $id, $args = array(), $options = array() ) {
			parent::__construct( $manager, $id, $args );
			add_action( 'wp_ajax_cst_customizer_control_homepage_headlines', [ $this, 'get_posts' ] );
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
			?>
			<label for="js-<?php echo esc_attr( $this->id ); ?>">
				<?php esc_html_e( $this->label, 'chicagosuntimes' ); ?>
			</label>
			<input class="widefat <?php echo esc_attr( $this->id ); ?>" id="js-<?php echo esc_attr( $this->id ); ?>" name="js-<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $headline ); ?>"
				   placeholder="<?php echo esc_attr( $this->input_attrs['placeholder'] ); ?>" data-story-title="<?php echo esc_attr( $story_title ); ?>"/>
			<?php
		}
		/**
		 * Get all published posts to display in Select2 dropdown
		 */
		public function get_posts() {
			global $wp_customize;
			while ( 0 !== ob_get_level() ) {
				ob_end_clean();
			}
			if ( ! wp_verify_nonce( $_GET['nonce'], 'cst_customizer_control_homepage_headlines' )
				 || ! current_user_can( 'edit_others_posts' )
			) {
				wp_send_json_error( array( 'code' => 'bad_nonce' ), 400 );
			}

			$term = sanitize_text_field( $_GET['searchTerm'] );

			if ( '' !== $term && strlen( $term ) >= 3 ) {
				$search_args = array(
					'post_type'     => array( 'cst_article', 'cst_feature', 'cst_embed', 'cst_link', 'cst_gallery' ),
					's'             => $term,
					'post_status'   => 'publish',
					'no_found_rows' => true,
				);

				$search_query = new WP_Query( $search_args );

				$returning = array();
				$posts     = array();

				if ( '' !== $term && strlen( $term ) >= 3 && $search_query->have_posts() ) {

					while ( $search_query->have_posts() ) : $search_query->the_post();
						$obj = get_post( get_the_ID() );
						if ( $obj ) {
							$content_type  = get_post_type( $obj->ID );
							$posts['id']   = get_the_ID();
							$posts['text'] = $obj->post_title . ' [' . $content_type . ']';
							array_push( $returning, $posts );
						}

					endwhile;
					if ( ! empty( $wp_customize ) ) {
						foreach ( $wp_customize->settings() as $setting ) {
							/**
							 * Setting.
							 *
							 * @var \WP_Customize_Setting $setting
							 */
							$setting->preview();
						}
					}
				}
				if ( is_wp_error( $returning ) ) {
					wp_send_json_error( array(
						'code' => $returning->get_error_code(),
						'message' => $returning->get_error_message(),
						'data' => $returning->get_error_data(),
					), 400 );
				} else {
					//wp_send_json_success( $returning ); sends array vs object (that json_encode sends)
					echo json_encode( $returning );
					exit();
				}
			}
		}
	}
}