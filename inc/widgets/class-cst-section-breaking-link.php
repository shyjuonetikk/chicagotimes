<?php

/**
 * Class CST_Breaking_Section_Link_Widget
 *
 * Present a Widget title and area for a url that the title should
 * link to when clicked.
 *
 */
class CST_Breaking_Section_Link_Widget extends WP_Widget {

	public function __construct() {

		parent::__construct(
			'cst_breaking_section_link',
			esc_html__( 'CST Breaking News Section Link', 'chicagosuntimes' ),
			array(
				'description' => esc_html__( 'Craft a section front link displayed breaking news style in the homepage header.', 'chicagosuntimes' ),
			)
		);

	}

	public function widget( $args, $instance ) {

		if ( empty( $instance['cst_breaking_section_url'] ) ) {
			return;
		}
		$title = ! empty( $instance['cst_breaking_section_title'] ) ? $instance['cst_breaking_section_title'] : '';
		$url   = ! empty( $instance['cst_breaking_section_url'] ) ? $instance['cst_breaking_section_url'] : '';
		?>
		<div class="breaking-section-story">
			<h3 class="title">
				<span><i class="fa fa-times-circle-o close-breaking-section"></i> </span> <a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $title ); ?></a>
			</h3>
		</div>

		<?php

	}

	public function form( $instance ) {

		$title = ! empty( $instance['cst_breaking_section_title'] ) ? $instance['cst_breaking_section_title'] : '';
		$url   = ! empty( $instance['cst_breaking_section_url'] ) ? $instance['cst_breaking_section_url'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'cst_breaking_section_title' ) ); ?>"><?php echo esc_html( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cst_breaking_section_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cst_breaking_section_title' ) ); ?>" type="text"
				   value="<?php echo esc_attr( $title ); ?>"/>
			<label for="<?php echo esc_attr( $this->get_field_id( 'cst_breaking_section_url' ) ); ?>"><?php echo esc_html( 'Full url to link to' ); ?>:</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cst_breaking_section_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cst_breaking_section_url' ) ); ?>"
				   value="<?php echo esc_attr( $url ); ?>"/>
		</p>
		<p><em>Please type the link in carefully or copy/paste from a browser and then test.</em></p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {

		$instance                               = array();
		$instance['cst_breaking_section_title'] = sanitize_text_field( $new_instance['cst_breaking_section_title'] );
		$instance['cst_breaking_section_url']   = sanitize_text_field( $new_instance['cst_breaking_section_url'] );

		return $instance;

	}

}
