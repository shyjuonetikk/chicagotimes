<?php
  /* 
   * Template Name: Monster Jobs
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
					<iframe width="100%" height="900px" align="middle" frameborder="0" src="http://www.suntimes.com/csp/cms/sites/STM/assets/includes/monsterSearch/suntimes.html"></iframe>
				</div>
			</div>
		</div>
	</section>
</div>
  <?php get_template_part( 'parts/dfp/homepage/dfp-homepage-mobile-wire-cube-2' ); ?>
  <?php get_template_part( 'parts/dfp/homepage/dfp-btf-leaderboard' ); ?>
<?php get_template_part( 'parts/homepage/footer' ); ?>
<?php get_footer(); ?>