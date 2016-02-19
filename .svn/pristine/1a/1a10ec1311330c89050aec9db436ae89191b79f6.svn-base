<?php
class CST_Sports_Headlines_Widget extends WP_Widget {
	protected $defaults = array(
		'cst_sports_headline_one'  => '',
		'cst_sports_headline_two' => '',
		'cst_sports_headline_three' => '',
		'cst_sports_headline_four' => '',
		'cst_sports_headline_five' => '',
		'cst_sports_headline_six' => '',
		'cst_sports_headline_seven' => '',
		'cst_sports_headline_eight' => '',
		'cst_sports_headline_nine' => '',
		'cst_sports_headline_ten' => '',
		);
	public function __construct() {
		parent::__construct(
			'cst_sports_headlines',
			esc_html__( 'CST Sports Headline Posts', 'chicagosuntimes-homepage' ),
			array(
				'description' => esc_html__( 'Displays The Sports Top Headlines.', 'chicagosuntimes-homepage' ),
			)
		);
	}
	public function widget( $args, $instance ) {
		$instance = array_merge( $this->defaults, $instance );
		$sport_headlines = array();
		foreach( $instance as $headline ) {
			if ( $headline ) {
				array_push( $sport_headlines, $headline );
			}
		}
		foreach( $sport_headlines as $sport_headline ) {
			$obj = \CST\Objects\Post::get_by_post_id( $sport_headline );
			if ( $obj ) {
				?>
				<div class="slide">
					<div class="slide-inner">
						<?php if ( $obj->get_featured_image_url() ) : ?>
							<a href="<?php esc_url( $obj->the_permalink() ); ?>">
								<div class="slide-image" style="background-image: url('<?php echo esc_url( $obj->get_featured_image_url() ); ?>')">
									<div class="gradient-overlay"></div>
								</div>
							</a>
						<?php endif; ?>
					</div>
					<div class="slide-text">
						<?php if ( $section = $obj->get_primary_section() ) : ?>
							<h4><?php echo esc_html( $section->name ); ?></h4>
						<?php endif; ?>
						<h3><a href="<?php esc_url( $obj->the_permalink() ); ?>"><?php esc_html( $obj->the_title() ); ?></a></h3>
					</div>
				</div>
			<?php }
			}
	}
	public function form( $instance ) {
		$instance = array_merge( $this->defaults, $instance );
		
		$latest_args = array(
				'posts_per_page'       => 50,
				'post_type'			   => CST()->get_post_types(),
				'cst_section'		   => 'sports',
				'post_status'		   => 'publish',
				);
		$latest_query = new WP_Query( $latest_args );
		$input_block_args = array(
			'cst_sports_headline_one',
			'cst_sports_headline_two',
			'cst_sports_headline_three',
			'cst_sports_headline_four',
			'cst_sports_headline_five',
			'cst_sports_headline_six',
			'cst_sports_headline_seven',
			'cst_sports_headline_eight',
			'cst_sports_headline_nine',
			'cst_sports_headline_ten',
		);
		foreach( $input_block_args as $input_block ) {
			$title_parts = explode( '_', $input_block );
			array_shift( $title_parts );
			$label_title = ucwords( implode( ' ', $title_parts ) );
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( $input_block ) ); ?>"><?php esc_html_e( $label_title , 'chicagosuntimes' ); ?></label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( $input_block ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $input_block ) ); ?>">
					<option value="<?php esc_html__( 'All', 'chicagosuntimes' ); ?>">-Select-</option>
					<?php
					if( $latest_query->have_posts() ) : while( $latest_query->have_posts() ) : $latest_query->the_post(); ?>
						<?php $obj = \CST\Objects\Post::get_by_post_id( get_the_ID() ); ?>
						<?php $section = $obj->get_primary_parent_section(); ?>
						<option <?php selected( get_the_ID() == $instance[$input_block] ) ?> value="<?php echo get_the_ID(); ?>">[<?php echo esc_html( $section->slug ); ?>] <?php echo esc_html( $obj->the_title() ); ?></option>
					<?php endwhile; endif; ?>
					?>
				</select>
			</p>
		<?php }
		
	}
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['cst_sports_headline_one'] 	= $new_instance['cst_sports_headline_one'];
		$instance['cst_sports_headline_two'] 	= $new_instance['cst_sports_headline_two'];
		$instance['cst_sports_headline_three']  = $new_instance['cst_sports_headline_three'];
		$instance['cst_sports_headline_four'] 	= $new_instance['cst_sports_headline_four'];
		$instance['cst_sports_headline_five'] 	= $new_instance['cst_sports_headline_five'];
		$instance['cst_sports_headline_six'] 	= $new_instance['cst_sports_headline_six'];
		$instance['cst_sports_headline_seven']  = $new_instance['cst_sports_headline_seven'];
		$instance['cst_sports_headline_eight']  = $new_instance['cst_sports_headline_eight'];
		$instance['cst_sports_headline_nine'] 	= $new_instance['cst_sports_headline_nine'];
		$instance['cst_sports_headline_ten'] 	= $new_instance['cst_sports_headline_ten'];
		return $instance;
	}
}