<?php get_header(); ?>
<div class="single-wrapper">

	<?php get_sidebar( 'left' ); ?>

	<section id="post-body">

	<div class="row">


		<div id="main" class="columns small-12 medium-7 large-10 end">
			<?php if ( is_singular() ) { ?>
				<div class="article-upper-ad-unit">
					<?php echo CST()->dfp_handler->unit( 1, 'div-gpt-atf-leaderboard', 'dfp dfp-leaderboard dfp-centered article-upper-ad-unit' ); ?>
				</div>
			<?php } ?>
			<div class="small-12 end">
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

	<?php get_sidebar( 'right' ); ?>
</div>

<?php get_footer(); ?>
