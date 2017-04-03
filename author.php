<?php get_header(); ?>
	
	<section class="row grey-background index">
		<?php get_template_part( 'parts/section/author-top' ); ?>
		<div id="main" class="wire columns medium-8 large-8 small-12">
			<div id="fixed-back-to-top" class="hide-back-to-top">
				<a id="back-to-top" href="#">
					<p><i class="fa fa-arrow-circle-up"></i><?php esc_html_e( 'Back To Top', 'chicagosuntimes' ); ?></p>
				</a>
			</div>
			<?php if ( have_posts() ) : ?>

				<?php while( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'sticky-content' ); ?>

				<?php endwhile; ?>

			<?php endif; ?>

			<?php if ( have_posts() ) : ?>
				<?php do_action( 'cst_section_head' ); ?>
				<?php while( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content' ); ?>

				<?php endwhile; ?>

			<?php endif; ?>

		</div>

		<div class="right-rail columns medium-4 large-4 show-for-medium-up">
			<?php get_sidebar(); ?>
		</div>

	</section>

<?php get_footer(); ?>