<?php

class CST_Newspaper_Cover_Widget extends WP_Widget {

	public function __construct() {

		parent::__construct(
			'cst_newspaper_covers',
			esc_html__( 'CST Newspaper Covers', 'chicagosuntimes' ),
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

		$front_cover = $instance['cst_newspaper_front_cover'];
		if ( ! empty( $front_cover ) ) {
			$front_cover_id      = $this->cst_get_image_id( $front_cover );
			if ( $front_cover_id ) {
				if ( $attachment = \CST\Objects\Attachment::get_by_post_id( $front_cover_id ) ) {
					$front_image_element_markup = wp_get_attachment_image( $front_cover_id, 'newspaper', false, $args );
				}
			}
		}

		$back_cover = $instance['cst_newspaper_back_cover'];
		if ( ! empty( $back_cover ) ) {
			$back_cover_id      = $this->cst_get_image_id( $back_cover );
			if ( $back_cover_id ) {
				if ( $attachment = \CST\Objects\Attachment::get_by_post_id( $back_cover_id ) ) {
					$back_image_element_markup = wp_get_attachment_image( $back_cover_id, 'newspaper', false, $args );
				}
			}
		}
		echo wp_kses_post( $args['before_widget'] );
		?>
		<div class="large-12 small-12 columns widget_cst_todays_paper_widget">
			<div><h2 class="widgettitle"><?php echo esc_html( 'Today\'s Cover', 'chicagosuntimes' ); ?></h2></div>
			<div class="todays-paper-container columns">
				<div class="row">
					<div class="todays-paper-front large-12 medium-6 small-12">
						<a href="">
							<?php echo wp_kses_post( $front_image_element_markup ); ?>
						</a>
					</div>
					<div class="todays-paper-back large-12 medium-6 small-12">
						<div class="todays-paper-links">
							<a href="http://chicago.suntimes.com/subscribe/" target="_blank" class="button tiny radius" data-on="click" data-event-category="newspaper-cover" data-event-action="click-subscribe"><?php esc_html_e( 'Subscribe', 'chicagosuntimes' ); ?></a>
							<a href="http://eedition.suntimes.com/epaper/viewer.aspx" target="_blank" class="button secondary tiny radius" data-on="click" data-event-category="newspaper-cover" data-event-action="click-view-epaper"><?php esc_html_e( 'E-Paper', 'chicagosuntimes' ); ?></a>
						</div>
						<?php echo wp_kses_post( $back_image_element_markup ); ?>
					</div>
				</div>
			</div>
		</div>
		<?php
		echo wp_kses_post( $args['after_widget'] );
	}

	public function form( $instance ) {

		isset( $instance['cst_newspaper_front_cover'] ) ? $front_cover = $instance['cst_newspaper_front_cover'] : $front_cover = '';
		isset( $instance['cst_newspaper_back_cover'] ) ? $back_cover = $instance['cst_newspaper_back_cover'] : $back_cover = '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'cst_newspaper_front_cover' ) ); ?>"><?php esc_html_e( 'Front Cover Image URL:', 'chicagosuntimes' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cst_newspaper_front_cover' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cst_newspaper_front_cover' ) ); ?>" type="text"
				   value="<?php echo esc_attr( $front_cover ); ?>"/>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'cst_newspaper_back_cover' ) ); ?>"><?php esc_html_e( 'Back Cover Image URL:', 'chicagosuntimes' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cst_newspaper_back_cover' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cst_newspaper_back_cover' ) ); ?>" type="text"
				   value="<?php echo esc_attr( $back_cover ); ?>"/>
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

		$instance                              = $old_instance;
		$instance['cst_newspaper_front_cover'] = sanitize_text_field( $new_instance['cst_newspaper_front_cover'] );
		$instance['cst_newspaper_back_cover']  = sanitize_text_field( $new_instance['cst_newspaper_back_cover'] );

		return $instance;

	}

}