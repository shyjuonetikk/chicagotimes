<?php

class CST_Homepage_Featured_Story_Widget extends WP_Widget {

	public function __construct() {

		parent::__construct(
			'cst_featured_story',
			esc_html__( 'CST Homepage Featured Story', 'chicagosuntimes' ),
			array(
				'description' => esc_html__( 'Displays the Front & Back Covers.', 'chicagosuntimes' ),
			)
		);

	}

	/*
	 * Return the attachment post id based on the image url
	 *
	 * @param $image_url | string
	 * @return int
	 */
	public function cst_get_image_id( $image_url ) {

		$attachment_id = wpcom_vip_attachment_url_to_postid( $image_url );

		return $attachment_id;

	}

	public function widget( $args, $instance ) {

		global $featured_homepage_story;

		$featured_homepage_story = array();
		$featured_link           = $instance['cst_featured_story_link'];
		$featured_image          = $instance['cst_featured_story_image'];
		$featured_title          = $instance['cst_featured_story_title'];

		if ( empty( $featured_link ) || empty( $featured_image ) || empty( $featured_title ) ) {
			return;
		} else {
			$featured_homepage_story['title'] = $featured_title;
			$featured_homepage_story['link']  = $featured_link;
			$featured_homepage_story['image'] = $featured_image;
			get_template_part( 'parts/homepage/featured-story-wells' );
		}

	}

	public function form( $instance ) {

		isset( $instance['cst_featured_story_link'] ) ? $featured_link = $instance['cst_featured_story_link'] : $featured_link = '';
		isset( $instance['cst_featured_story_image'] ) ? $featured_image = $instance['cst_featured_story_image'] : $featured_image = '';
		isset( $instance['cst_featured_story_title'] ) ? $featured_title = $instance['cst_featured_story_title'] : $featured_title = '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'cst_featured_story_title' ) ); ?>"><?php esc_html_e( 'Story Title:', 'chicagosuntimes' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cst_featured_story_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cst_featured_story_title' ) ); ?>" type="text"
				   value="<?php echo esc_attr( $featured_title ); ?>"/>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'cst_featured_story_link' ) ); ?>"><?php esc_html_e( 'Story URL:', 'chicagosuntimes' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cst_featured_story_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cst_featured_story_link' ) ); ?>" type="text"
				   value="<?php echo esc_attr( $featured_link ); ?>"/>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'cst_featured_story_image' ) ); ?>"><?php esc_html_e( 'Story Image URL:', 'chicagosuntimes' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cst_featured_story_image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cst_featured_story_image' ) ); ?>" type="text"
				   value="<?php echo esc_attr( $featured_image ); ?>"/>
		</p>
		<p>
		<hr/>
		<div id="wp-content-media-buttons" class="wp-media-buttons">
			<button type="button" id="insert-media-button" class="button insert-media add_media" data-editor="content"><span class="wp-media-buttons-icon"></span> <?php esc_html_e( 'Add Media', 'chicagosuntimes' ); ?></button>
		</div>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {

		$instance                             = $old_instance;
		$instance['cst_featured_story_link']  = sanitize_text_field( $new_instance['cst_featured_story_link'] );
		$instance['cst_featured_story_image'] = sanitize_text_field( $new_instance['cst_featured_story_image'] );
		$instance['cst_featured_story_title'] = sanitize_text_field( $new_instance['cst_featured_story_title'] );

		return $instance;

	}

}