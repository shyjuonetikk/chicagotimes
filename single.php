<?php get_header(); ?>

	<?php get_sidebar( 'post' ); ?>

	<section id="post-body">

	<div class="row">

		<div id="main" class="columns large-10 large-offset-2 end">

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

	</section>

<?php get_footer(); ?>