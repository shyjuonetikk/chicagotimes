<?php global $homepage_more_well_posts; ?>
<hr class="before">
<h2 class="section-title"><span><?php esc_html_e( 'More Top Stories', 'chicagosuntimes' ); ?></span></h2>
<hr>
<?php if ( is_array( $homepage_more_well_posts ) && ! empty( $homepage_more_well_posts ) ) { ?>
	<section id="more-stories-wells">
		<div class="row">
			<div class="columns">
		<?php foreach ( $homepage_more_well_posts as $homepage_more_well_post ) { ?>
			<div class="more-story">
				<div class="row">
				<?php
				$obj = \CST\Objects\Post::get_by_post_id( $homepage_more_well_post->ID );
				if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
					$primary_section = $obj->get_primary_parent_section();
					if ( $byline = $obj->get_byline() ) {
						$author = $byline;
					} else {
						$authors     = $obj->get_authors();
						$author_data = $authors[0];
						$author      = $author_data->get_display_name();
					}
					?>
					<div
						class="large-4 medium-4 small-5 columns article-image <?php esc_attr_e( strtolower( $primary_section->name ), 'chicagosuntimes' ); ?>-triangle">
						<a href="<?php echo esc_url( $obj->the_permalink() ); ?>" data-on="click" data-event-category="navigation" data-event-action="navigate-hp-more-wells">
							<?php
							if ( $featured_image_id = $obj->get_featured_image_id() ) {
								if ( $attachment = \CST\Objects\Attachment::get_by_post_id( $featured_image_id ) ) {
									echo $attachment->get_html( 'homepage-columns' );
								}
							}
							?>
						</a>
					</div>
					<div class="large-8 medium-8 small-7 columns article-headline">
						<a href="<?php echo esc_url( $obj->the_permalink() ); ?>" data-on="click" data-event-category="content" data-event-action="navigate-hp-more-wells">
							<h3><?php esc_html_e( $obj->the_title(), 'chicagosuntimes' ); ?></h3>
						</a>
						<?php esc_html_e( $obj->the_excerpt(), 'chicagosuntimes' ); ?>
						<span
							class="author">By <?php echo esc_html( $author ); ?></span>
					</div>
					<?php
				}
				?>
				</div>
			</div>
		<?php } ?>
		<?php get_template_part( 'parts/vendors/nativo-home-1' ); ?>
		</div>
		</div>
	</section>
<?php } ?>
</div>
<div class="large-4 columns homepage-sidebar">
	<div class="row">
		<?php if ( dynamic_sidebar( 'homepage_sidebar_two' ) ) {
		} ?>
		<?php if ( dynamic_sidebar( 'homepage_sidebar_three' ) ) {
		} ?>
		<div class="large-12 medium-6 small-12 columns dfp-cube">
			<?php echo wp_kses( CST()->dfp_handler->unit( 7, 'div-gpt-rr-cube', 'dfp dfp-cube', 'hp_cube_mapping', 'rr cube 7' ), CST()->dfp_kses ); ?>
		</div>
	</div>
</div>
