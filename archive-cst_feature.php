<?php get_header( 'features' ); ?>
	<section class="row grey-background">
		<div id="main" class="wire columns large-12">
			<div id="fixed-back-to-top" class="hide-back-to-top">
				<a id="back-to-top" href="#">
					<p><i class="fa fa-arrow-circle-up"></i><?php esc_html_e( 'Back To Top', 'chicagosuntimes' ); ?></p>
				</a>
			</div>
			<a id="newsfeed-logo" class="features" href="<?php echo esc_url( get_post_type_archive_link( 'cst_feature' ) ); ?>" data-on="click" data-event-category="navigation" data-event-action="navigate-sf-newsfeed-logo"><?php esc_html_e( 'Featured Stories', 'chicagosuntimes' ); ?></a>
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
