<?php global $homepage_more_well_posts;
$classes = array(
	'columns' => array(
		'title' => 'columns small-9 medium-8 title',
		'image' => 'columns small-3 medium-4 image',
	),
	'rows' => array(
		'title' => 'columns small-9 medium-8 large-6 title',
		'image' => 'columns small-3 medium-4 large-6 image',
	),
);
$orientation = 'columns';
$counter = 0;
?>

<div class="stories-list">
	<div class="columns small-12">
		<?php foreach ( $homepage_more_well_posts as $homepage_more_well_post ) { ?>
			<div class="more-story <?php echo esc_attr( 'cst_homepage_more_headlines_' . $counter ); ?>">
				<div class="row">
					<?php
					$obj = \CST\Objects\Post::get_by_post_id( $homepage_more_well_post->ID );
					if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
						if ( $byline = $obj->get_byline() ) {
							$author = $byline;
						} else {
							$authors     = $obj->get_authors();
							$author_data = $authors[0];
							$author      = $author_data->get_display_name();
						}
						?>
						<div class="latest-story">
							<div class="<?php echo esc_attr( $classes[ $orientation ]['title'] ); ?>">
								<a href="<?php echo esc_url( $obj->get_permalink() ); ?>" data-on="click" data-event-category="content" data-event-action="navigate-hp-latest-wells">
									<?php echo esc_html( $obj->get_title() ); ?>
								</a>
							</div>
							<div class="<?php echo esc_attr( $classes[ $orientation ]['image'] ); ?>">
								<a href="<?php echo esc_url( $obj->get_permalink() ); ?>" class="image-right" data-on="click" data-event-category="content" data-event-action="navigate-hp-latest-wells">
									<?php
									$featured_image_id = $obj->get_featured_image_id();
									if ( $featured_image_id ) {
										$attachment = wp_get_attachment_metadata( $featured_image_id );
										if ( $attachment ) {
											$image_markup = get_image_tag( $featured_image_id, $attachment['image_meta']['caption'], '', 'right', 'chiwire-slider-square' );
											echo wp_kses_post( $image_markup );
										}
									}
									?>
								</a>
							</div>
						</div>
					<?php }
					?>
				</div>
			</div>
		<?php $counter++;
} ?>
	</div>
</div>
