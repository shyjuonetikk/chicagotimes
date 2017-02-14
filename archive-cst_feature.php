<?php get_header( 'features' ); ?>
	<section class="row sf-head">
		<div id="main" class="wire columns large-12">
			<div id="fixed-back-to-top" class="hide-back-to-top">
				<a id="back-to-top" href="#">
					<p><i class="fa fa-arrow-circle-up"></i><?php esc_html_e( 'Back To Top', 'chicagosuntimes' ); ?></p>
				</a>
			</div>
			<a id="newsfeed-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php get_template_part( 'parts/images/main-site-logo' ); ?></a>

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'sticky-content' ); ?>

				<?php endwhile; ?>

			<?php endif; ?>

			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content' ); ?>

				<?php endwhile; ?>

			<?php endif; ?>

		</div>


	</section>

<?php get_footer( 'features' );
