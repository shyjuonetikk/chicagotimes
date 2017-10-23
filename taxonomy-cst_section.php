<?php get_header(); ?>
<?php
$sports_sf = '';
$content_block_class = 'wire columns medium-8 large-8 small-12' ;
$right_rail_class = 'right-rail columns medium-4 large-4 show-for-medium-up' ;
if ( \CST\CST_Section_Front::get_instance()->is_sports_or_child( get_queried_object_id() ) && is_tax( 'cst_section' ) ) {
	$sports_sf = "section_front_wrapper stories-container";
	$content_block_class = 'wire columns medium-8 large-9 small-12' ;
	$right_rail_class = 'right-rail columns medium-4 large-3 show-for-medium-up' ;
}
?>
	<section class="row grey-background <?php echo esc_attr( $sports_sf ); ?>">
		<div id="main" class="<?php echo esc_attr( $content_block_class ); ?>">
			<div id="fixed-back-to-top" class="hide-back-to-top">
				<a id="back-to-top" href="#">
					<p><i class="fa fa-arrow-circle-up"></i><?php esc_html_e( 'Back To Top', 'chicagosuntimes' ); ?></p>
				</a>
			</div>
			<?php get_template_part( 'parts/section/taxonomy-top' ); ?>
			<?php if ( ! empty( $sports_sf ) ) { ?>
			<div class="row">
				<?php \CST\CST_Section_Front::get_instance()->five_block( get_queried_object()->slug );?>
			</div>
			<? } ?>

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'sticky-content' ); ?>

				<?php endwhile; ?>

			<?php endif; ?>

			<?php if ( have_posts() ) : ?>
				<?php do_action( 'cst_section_head' ); ?>
				<?php $video_position_counter = 1; //@TODO change to key off wp_query->current_post poss with wp_query->in_the_loop ?>
				<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content' ); ?>
					<?php
						$video_position_counter++;
						echo CST()->frontend->cst_section_front_video( $video_position_counter );
					?>
				<?php endwhile; ?>

			<?php endif; ?>

		</div>

		<div class="<?php echo esc_attr( $right_rail_class ); ?>">
			<?php get_sidebar(); ?>
		</div>


	</section>

<?php get_footer();
