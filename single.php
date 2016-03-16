<?php get_header(); ?>

	<?php get_sidebar( 'left' ); ?>

	<section id="post-body">

	<div class="row">

		<div id="main" class="columns large-9 large-offset-2 medium-offset-3 end">
			<?php
				if ( is_singular() ) :
					get_template_part( 'parts/dfp/dfp-atf-leaderboard' );
					get_template_part( 'parts/dfp/dfp-mobile-leaderboard' );
				endif;
			?>
			<div class="columns large-11 large-offset-1 end">
				<?php get_template_part( 'parts/images/main-site-logo'); ?>
			</div>

			<?php if ( have_posts() ) : ?>

				<?php while( have_posts() ) :
					the_post(); ?>

					<?php get_template_part( 'sticky-content' ); ?>

				<?php endwhile; ?>

			<?php endif; ?>

			<?php if ( have_posts() ) : ?>

				<?php while( have_posts() ) :
					the_post(); ?>

					<?php get_template_part( 'content' ); ?>

				<?php endwhile; ?>

			<?php endif; ?>

		</div>

	</div>
		<?php get_sidebar( 'right' ); ?>
	</section>


<?php get_footer(); ?>