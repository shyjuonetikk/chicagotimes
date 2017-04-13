<?php

class CST_Shia_Kapos_Categories_Widget extends WP_Widget {

	public function __construct() {

		parent::__construct(
			'cst_shia_kapos_categories',
			esc_html__( 'CST Shia Kapos Categories', 'chicagosuntimes' ),
			array(
				'description' => esc_html__( 'Displays Shia Kapos\'s Categories.', 'chicagosuntimes' ),
			)
		);

	}

	public function widget( $args, $instance ) {

		$title = $instance['cst_shia_kapos_category_title'];

		$latest_args  = array(
			'posts_per_page' => 15,
			'post_type'      => CST()->get_post_types(),
			'cst_section'    => 'shia-kapos',
		);
		$latest_query = new WP_Query( $latest_args );

		echo $args['before_widget'];

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		}

		?>
		<ul class="widget-recent-posts">
			<?php if ( $latest_query->have_posts() ):
				while ( $latest_query->have_posts() ) : $latest_query->the_post();
					$obj        = \CST\Objects\Post::get_by_post_id( get_the_ID() );
					$topics     = $obj->get_topics();
					$categories = array();
					foreach ( $topics as $topic ) {
						array_push( $categories, $topic->name );
					}
				endwhile;
				$category_list = array_unique( $categories );
				foreach ( $category_list as $cat ) {
					?>
					<li>
						<span class='title'><a href="<?php echo esc_url( wpcom_vip_get_term_link( $cat, 'cst_topic' ) ); ?>"><?php esc_html_e( $cat ); ?></a></span>
					</li>
				<?php } ?>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</ul>
		<?php
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		isset( $instance['cst_shia_kapos_category_title'] ) ? $title = $instance['cst_shia_kapos_category_title'] : $title = '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'cst_shia_kapos_category_title' ) ); ?>"><?php esc_html_e( 'Title:', 'chicagosuntimes' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cst_shia_kapos_category_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cst_shia_kapos_category_title' ) ); ?>" type="text"
				   value="<?php echo esc_attr( $title ); ?>"/>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {

		$instance                                  = $old_instance;
		$instance['cst_shia_kapos_category_title'] = sanitize_text_field( $new_instance['cst_shia_kapos_category_title'] );

		return $instance;

	}

}