<?php
  /* 
   * Template Name: Flipp Template
   */
?>

<!-- -->
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Chicago Sun-Times | Circular</title>
</head>

<body>


<!-- -->

<?php //get_header(); ?>

	<?php get_sidebar( 'left' ); ?>

	<section id="post-body">

	<div class="row">

		<div id="main" class="columns large-10 end">
			<?php
			//	if ( is_singular() ) :
			//		echo CST()->dfp_handler->unit( 1, 'div-gpt-atf-leaderboard', 'dfp dfp-leaderboard dfp-centered' );
			//	endif;
			?>
			<div class="columns large-11 large-offset-1 end">
				<?php // get_template_part( 'parts/images/main-site-logo'); ?>
			</div>

			<?php if ( have_posts() ) : ?>

				<?php while( have_posts() ) :
					the_post(); ?>

					<?php // get_template_part( 'sticky-content' ); ?>

				<?php endwhile; ?>

			<?php endif; ?>

			<?php //if ( have_posts() ) : ?>

				<?php //while( have_posts() ) :
					//the_post(); ?>

					<?php //get_template_part( 'content' ); ?>

				<?php //endwhile; ?>

			<?php //endif; ?>

                  <div id='circ-container'></div>
      <script src="http://circulars.chicago.suntimes.com/distribution_services/iframe.js" type="text/javascript"></script>
      <script>
      var pageSizing = 'WINDOW';
      var minHeight = 550;
      var initialHeight = 1000;
      var extraPadding = 70;
      var queryParameters = '';
       new wishabi.distributionservices.iframe.decorate(
         'circ-container',    /* This is the div created above */
          'suntimesmedia', /* Your name identifier */
         wishabi.distributionservices.iframe.Sizing[pageSizing],
         {
            minHeight: minHeight,
            initialHeight: initialHeight,
            extraPadding: extraPadding,
            queryParameters: queryParameters
       });
    </script>
            
		</div>

	</div>
	</section>

	<?php // get_sidebar( 'right' ); ?>

<?php get_footer(); ?>