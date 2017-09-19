<?php

class CST_Recent_Posts extends WP_Widget {

	protected $defaults = array(
		'cst_recent_posts_title'  => 'Latest',
		'cst_recent_posts_section' => 'All',
		);

	public function __construct() {

		parent::__construct(
			'cst_recent_posts',
			esc_html__( 'CST Recent Posts', 'chicagosuntimes' ),
			array(
				'description' => esc_html__( 'Displays The Wires recent posts.', 'chicagosuntimes' ),
			)
		);

	}

	public function widget( $args, $instance ) {

		$instance = array_merge( $this->defaults, $instance );

		$title = $instance['cst_recent_posts_title'];

		$latest_args = array(
				'posts_per_page'       => 5,
				'post_type'            => CST()->get_post_types(),
				'cst_section'		   => $instance['cst_recent_posts_section'],
				);
		$latest_query = new WP_Query( $latest_args );

		echo $args['before_widget'];

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		}

		?>
		<ul class="widget-recent-posts">
			<?php if ( $latest_query->have_posts() ):
				while( $latest_query->have_posts() ) : $latest_query->the_post();
					$obj = \CST\Objects\Post::get_by_post_id( get_the_ID() ); ?>
			<li>
				<a href="<?php $obj->the_permalink(); ?>">
				<?php if ( $section = $obj->get_primary_section() ) : ?>
					<span class='section'><?php echo esc_html( $section->name ) ?></span>
				<?php endif; ?>
				<span class='time'><?php echo human_time_diff( $obj->get_post_date_gmt() ); ?></span><br />
				<span class='title'><?php $obj->the_title(); ?></span>
				</a>
			</li>
			<?php endwhile; endif; ?>
		</ul>
		<?php
		echo $args['after_widget'];
	}

	public function form( $instance ) {

		$instance = array_merge( $this->defaults, $instance );

		$title = $instance['cst_recent_posts_title'];
		// The get_sections function cannot be used since a post object cannot be created
		$sections = get_terms( 'cst_section', array( 'parent'	=> 0 ) );
?>
	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'cst_recent_posts_section' ) ); ?>"><?php esc_html_e( 'Section:', 'chicagosuntimes' ); ?></label>
		<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cst_recent_posts_section' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cst_recent_posts_section' ) ); ?>">
			<option value="<?php esc_html__( 'All', 'chicagosuntimes' ); ?>">All</option>
		<?php if ( ! empty( $sections ) && ! is_wp_error( $sections ) ) : ?>
		<?php foreach( $sections as $section ) : ?>
				<option <?php selected( $section->slug == $instance['cst_recent_posts_section'] ) ?> value="<?php echo esc_attr( $section->slug ); ?>"><?php echo esc_html( $section->name ); ?></option>
		<?php endforeach; ?>
		<?php endif; ?>
		</select>
		<label for="<?php echo esc_attr( $this->get_field_id( 'cst_recent_posts_title' ) ); ?>"><?php esc_html_e( 'Title:', 'chicagosuntimes' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cst_recent_posts_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cst_recent_posts_title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>
<?php
	}

	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['cst_recent_posts_section'] = $new_instance['cst_recent_posts_section'];
		$instance['cst_recent_posts_title'] = sanitize_text_field( $new_instance['cst_recent_posts_title'] );
		return $instance;

	}

}