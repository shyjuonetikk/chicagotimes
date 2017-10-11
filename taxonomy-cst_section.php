<?php get_header(); ?>
	<section class="section_front_wrapper">
		<div class="row">
		<div id="main" class="wire columns medium-8 large-8 small-12">
			<div id="fixed-back-to-top" class="hide-back-to-top">
				<a id="back-to-top" href="#">
					<p><i class="fa fa-arrow-circle-up"></i><?php esc_html_e( 'Back To Top', 'chicagosuntimes' ); ?></p>
				</a>
			</div>
			<?php get_template_part( 'parts/section/taxonomy-top' ); ?>
			<div class="row">
				<?php \CST\CST_Section_Front::get_instance()->five_block( get_queried_object()->slug );?>
			</div>
			<a id="newsfeed-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php get_template_part( 'parts/images/main-site-logo' ); ?></a>

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

		<div class="right-rail columns medium-4 large-4 show-for-medium-up">
			<h3>Sidebar temporarily disabled due to TCX widget loading lag</h3>
<!--			--><?php //get_sidebar(); ?>
		</div>
		</div>


	</section>

<?php get_footer();
