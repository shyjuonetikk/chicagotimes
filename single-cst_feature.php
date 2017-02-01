<?php get_header( 'features' ); ?>

	<section id="post-body">

	<div class="">

		<div id="main" class="columns small-12 end">
			<div class="columns large-11 large-offset-1 end">
				<?php get_template_part( 'parts/images/main-site-logo' ); ?>
			</div>

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) :
					the_post(); ?>

					<?php get_template_part( 'sticky-content' ); ?>

				<?php endwhile; ?>

			<?php endif; ?>

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) :
					the_post(); ?>

					<?php get_template_part( 'content' ); ?>

				<?php endwhile; ?>

			<?php endif; ?>

		</div>

	</div>

	</section>

<?php get_footer( 'features' );
