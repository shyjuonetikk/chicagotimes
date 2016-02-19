<?php
  /* 
   * Template Name: Generic Page
   */
?>
<?php get_header(); ?>
<?php get_template_part( 'parts/homepage/navigation' ); ?>
  <div id="dfp-top-placement" class="dfp">
    <?php get_template_part( 'parts/dfp/homepage/dfp-sbb' ); ?>
  </div>
<div>
	<section id="subscribe">
		<div class="row">
			<div class="just-in-wrapper large-12 columns mbox3">
				<div class="small-12 columns">
					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						<?php the_content(); ?>
					<?php endwhile; else : ?>
						<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
					<?php endif; ?>	
				</div>
			</div>
		</div>
	</section>
</div>
  <?php get_template_part( 'parts/dfp/homepage/dfp-homepage-mobile-wire-cube-2' ); ?>
  <?php get_template_part( 'parts/dfp/homepage/dfp-btf-leaderboard' ); ?>
<?php get_template_part( 'parts/homepage/footer' ); ?>
<?php get_footer(); ?>