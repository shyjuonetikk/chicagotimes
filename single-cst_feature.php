<?php get_header( 'features' ); ?>

	<section id="post-body">

	<div class="">

		<div id="main" class="columns small-12 end">

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

<?php get_footer();
