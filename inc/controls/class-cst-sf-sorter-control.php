<?php
if ( class_exists( 'WP_Customize_Control' ) ) {
	class WP_Customize_CST_SF_Sorter_Control extends \WP_Customize_Control {
		// https://github.com/maddisondesigns/customizer-custom-controls/blob/master/js/customizer.js
		/**
		 * Control type.
		 *
		 * @since 3.1.0
		 * @access public
		 * @var string
		 */
		public $type = 'cst_sf_sorter_control';
		/**
		 * Section Sort Order.
		 *
		 * @since 3.1.0
		 * @access public
		 * @var array
		 */
		public $sort_order = [];
		/**
		 * Section order slugs
		 * @since 3.1.0
		 * @access public
		 * @var array
		 */
		public $sort_values = [];
		public function __construct( WP_Customize_Manager $manager, $id, array $args = [] ) {
			parent::__construct( $manager, $id, $args );
			if ( isset( $args['setting']['list'] ) ) {
				$this->sort_values = $args['setting']['list'];
			}
			$this->sort_order = get_theme_mod( $this->id . '-collection' );
			if ( empty( $this->sort_order ) && isset( $args['setting']['defaults'] ) ) {
				$this->sort_order = join( ',', array_keys( $args['setting']['defaults'] ) );
			}
		}
		public function enqueue() {
			parent::enqueue(); // TODO: Change the autogenerated stub
			wp_enqueue_style( 'cst_customizer_sf_sorter_control_styles', esc_url( get_stylesheet_directory_uri() . '/assets/css/cst-customizer-styles.css' ), [], '3.1.0', 'all' );
			wp_enqueue_script( 'cst_customizer_sf_sorter_control', esc_url( get_stylesheet_directory_uri() . '/assets/js/cst-customize-control-sorter.js' ), [ 'customize-controls' ], '3.1.0', true );
		}
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
			$this->json['sortOrder']   = explode( ',', $this->sort_order );
			$this->json['id']          = $this->id;
			$this->json['description'] = $this->description;
			$this->json['sortValues']  = $this->sort_values;
		}
		/**
		 * Generate list item markup for sorter
		 *
		 * Includes hidden field used to collect the options into a comma separated
		 * list that is saved to the Customizer and used to declare the sort
		 * order when a section front is rendered
		 */
		public function content_template() {
			parent::content_template();
			?>
<label for="{{ data.id }}">
	<# if ( data.label ) { #>
		<span class="customize-control-title">{{ data.label }}</span>
	<# } #>
	<# if ( data.description ) { #>
		<span class="description customize-control-description">{{ data.description }}</span>
	<# } #>
</label>
<# if ( ! data.sortOrder ) {
	return;
} #>
<ul id="{{ data.id }}" class="widget-area-select cst-section-sort">
<# for ( slug in data.sortOrder ) { #>
	<li class="ui-state-default cst-item" data-slug="{{ data.sortOrder[slug] }}">{{ data.sortValues[data.sortOrder[slug]] }}</li>
<# } #>
</ul>
<input type="hidden" id="{{ data.id }}-collection" value="{{ data.sortOrder }}" class="cst-customize-control-sorter"/>

			<?php
		}
		/**
		 * Render content just like a normal select control.
		 *
		 * @since 3.1.0
		 * @access public
		 */
		public function render_content() {}
	}
}
