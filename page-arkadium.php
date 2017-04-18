<?php
  /* 
   * Template Name: Arkadium Template
   */
?>
<?php get_header( 'page' ); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<section>
	<div class="row page-content">
		<div class="small-12 columns">
			<div id="partnercontent">
				<ark:GameBodyContainer />
			</div>
		</div>
	</div>
</section>
<?php endwhile; else : ?>
    <p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>

<?php get_footer( 'page' );
