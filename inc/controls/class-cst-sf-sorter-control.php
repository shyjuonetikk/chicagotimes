<?php
class WP_Customize_CST_SF_Sorter_Control extends \WP_Customize_Control {

	/**
	 * Control type.
	 *
	 * @since 3.1.0
	 * @access public
	 * @var string
	 */
	public $type = 'cst_sf_sorter';

	/**
	 * Section Sort Order.
	 *
	 * @access public
	 * @var array
	 */
	public $sort_order = [];

	/**
	 * Refresh the parameters passed to JavaScript via JSON.
	 *
	 * @since 3.1.0
	 * @access public
	 *
	 * @see WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();
		$this->json['sortOrder'] = $this->sort_order;
	}

	/**
	 * Render content just like a normal select control.
	 *
	 * @since 3.1.0
	 * @access public
	 */
	public function render_content() {
		if ( empty( $this->choices ) ) {
			return;
		}
		?>
		<label>
			<?php if ( ! empty( $this->label ) ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo $this->description; ?></span>
			<?php endif; ?>

			<select <?php $this->link(); ?>>
				<?php
				foreach ( $this->choices as $value => $label ) :
					echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->value(), $value, false ) . '>' . $label . '</option>';
				endforeach;
				?>
			</select>
		</label>
		<button type="button" class="button-link edit-menu<?php if ( ! $this->value() ) { echo ' hidden'; } ?>" aria-label="<?php esc_attr_e( 'Edit selected menu' ); ?>"><?php _e( 'Edit Menu' ); ?></button>
		<?php
	}
}