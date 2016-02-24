<?php get_header(); ?>
	
	<section class="row grey-background">
		<div id="main" class="wire columns large-8">
			<div id="fixed-back-to-top" class="hide-back-to-top">
				<a id="back-to-top" href="#">
					<p><i class="fa fa-arrow-circle-up"></i><?php esc_html_e( 'Back To Top', 'chicagosuntimes' ); ?></p>
				</a>
			</div>
			<?php if ( is_tax() ): ?>
				<?php get_template_part( 'parts/section/taxonomy-top' ); ?>
			<?php elseif ( is_author() ): ?>
				<?php get_template_part( 'parts/section/author-top' ); ?>
			<?php else: ?>
				<a id="newsfeed-logo" href="<?php echo home_url('/'); ?>"><?php get_template_part( 'parts/images/main-site-logo'); ?></a>
			<?php endif; ?>

			<?php if ( have_posts() ) : ?>

				<?php while( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'sticky-content' ); ?>

				<?php endwhile; ?>

			<?php endif; ?>

			<?php if ( have_posts() ) : ?>

				<?php while( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content' ); ?>

				<?php endwhile; ?>

			<?php endif; ?>

		</div>

		<div class="columns large-4">
			<?php get_sidebar(); ?>
		</div>

	</section>

<?php get_footer(); ?>