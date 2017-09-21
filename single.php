<?php get_header(); ?>
<div class="single-wrapper">

	<?php get_sidebar( 'left' ); ?>

	<section id="post-body" class="columns large-10">

	<div class="row">
		<?php if ( is_singular() ) { ?>
			<div class="article-upper-ad-unit">
				<?php echo wp_kses( CST()->dfp_handler->unit( 1, 'div-gpt-atf-leaderboard', 'dfp dfp-leaderboard dfp-centered article-upper-ad-unit' ),
					CST()->dfp_kses
				); ?>
			</div>
		<?php } ?>

		<div id="main" class="columns small-12 medium-7 large-8 end">
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

	<?php get_sidebar( 'right' ); ?>
	</div>

	</section>

</div>

<?php get_footer();
