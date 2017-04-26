<?php
/*
 * Template Name: Arkadium Template
 */
?>
<?php get_header( 'arkadium' ); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<section>
		<div class="row page-content">
			<div id="partnercontent">
				<ark:GameBodyContainer />
			</div>
		</div>
	</section>
<?php endwhile; else : ?>
	<p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>

<?php get_footer( 'page' );