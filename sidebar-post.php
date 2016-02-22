<aside class="sidebar show-for-large-up" id="post-sidebar" style="display: none !important;">
<?php $current_obj = \CST\Objects\Post::get_by_post_id( get_queried_object()->ID ); ?>
<?php 

$included_section_ids = array();

if( $current_obj ) {
	$section = $current_obj->get_primary_parent_section();

	if ( $section ) {
		$included_section_ids = array( $section->term_id );
		if ( 0 != $section->parent )  {
			array_push( $included_section_ids, $section->parent );
		}
	}
}

?>
<?php
	$latest_args = array(
		'posts_per_page'       => 25,
		'post_type'            => CST()->get_post_types(),
		'tax_query'            => array(
			array(
				'taxonomy'  => 'cst_section',
				'field'     => 'id',
				'terms'     => $included_section_ids,
			)
		)
		);
	if ( is_singular() && $first_post = get_queried_object() ) {
		$latest_args['date_query'] = array(
			'before'           => $first_post->post_date,
			'inclusive'        => true,
			);
	}

	// Check if this is actually the first post
	if ( ! empty( $first_post ) ) {
		$first_post_args = array(
			'posts_per_page'       => 1,
			'post_type'            => CST()->get_post_types(),
			'fields'               => 'ids',
		);
		$first_post_query = new WP_Query( $first_post_args );
		if ( ! empty( $first_post_query->posts ) && $first_post_query->posts[0] != $first_post->ID ) {
			$filtered_results = true;
		}
	}

	$latest_query = new WP_Query( $latest_args );
?>

<div class="load-buttons <?php echo ! empty( $filtered_results ) ? 'filtered' : ''; ?>">
	<span id="latest" class="button"><?php esc_html_e( 'Latest', 'chicagosuntimes' ) ; ?></span>
	<a href="#" id="load-latest" class="button"><i class="fa fa-repeat"></i>&nbsp;&nbsp;<?php esc_html_e( 'Load Latest', 'chicagosuntimes' ) ; ?></a>
</div>

<?php $post_count = 0; ?>
<?php if ( $latest_query->have_posts() ): ?>

	<ul class="latest-posts">

	<?php while( $latest_query->have_posts() ) : $latest_query->the_post();
		$post_count++;
		$obj = \CST\Objects\Post::get_by_post_id( get_the_ID() );
		echo CST()->get_template_part( 'sidebar/post', array( 'obj' => $obj ) );
		if( $post_count == 2 ) {
			echo '<li class="sidebar-ad">' . CST()->get_template_part( 'dfp/dfp-rr-cube-1' ) . '</li>';
		}
		endwhile; ?>

	</ul>

<?php endif;
	wp_reset_query();
	?>


</aside>