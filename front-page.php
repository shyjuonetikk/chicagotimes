<?php
get_header();
?>
	<div class="homepage-content stories-container">
		<div class="row stories-container">
			<div class="columns small-12 medium-8 large-9 stories">
				<div class="row" data-equalizer-mq="large-up">
					<div class="columns small-12 large-4 lead-stories">
						<?php
						CST()->frontend->homepage_hero_story( 'cst_homepage_headlines_one' );
						?>
						<div class="show-for-landscape show-for-xlarge-up">
							<?php
							CST()->frontend->handle_related_content();
							?>
						</div>
						<div class="show-for-portrait show-for-large-up">
							<div class="small-12">
								<?php CST()->frontend->handle_related_content(); ?>
							</div>
						</div>
						<?php
						CST()->frontend->homepage_lead_story( 'cst_homepage_headlines_two' );
						?>
						<?php
						CST()->frontend->homepage_lead_story( 'cst_homepage_headlines_three' );
						?>
						<div class="show-for-large-up">
							<?php CST()->frontend->inject_newsletter_signup( 'news' ); ?>
						</div>
					</div><!-- /hp-main-lead -->
					<div class="columns small-12 large-8 more-stories-container other-lead-stories">
						<div class="show-for-medium-only"><h3 class="more-sub-head">In other news</h3></div>
						<div id="hp-other-lead-stories">
							<div class="row lead-mini-story js-cst-homepage-other-headlines-1">
								<?php CST()->frontend->homepage_mini_story_lead( 'cst_homepage_other_headlines_1' ); ?>
							</div><!-- /js-cst-homepage-other-headlines-1 -->
							<hr>
							<?php
							$other_stories = CST()->customizer->get_other_headlines_stories();
							array_shift( $other_stories );
							?>
							<div class="section-other-stories" data-equalizer>
								<?php CST()->frontend->mini_stories_content_block( $other_stories ); ?>
							</div>
						</div><!-- hp-other-lead -->
<?php if ( function_exists( 'jetpack_is_mobile' ) && jetpack_is_mobile() ) { ?>
<div class="columns small-12 sidebar homepage-sidebar widgets mobile">
<?php the_widget( 'CST_Ad_Widget', [], 'dfp-rr-cube-1' ); ?>
</div>
<?php } else { ?>
<div class="other-stories show-for-large-up">
	<hr>
	<?php CST()->frontend->render_section_text_title( 'chartbeat_section_title' ); ?>
	<div id="root"></div>
</div>
<?php } ?>
						<div class="other-stories more-stories-container hide-for-xlarge-up" id="hp-sports-section-lead">
							<?php CST()->frontend->sports_heading(); ?>
							<?php CST()->frontend->mini_stories_content_block( CST()->customizer->get_upper_section_stories() ); ?>
						</div>
					</div>
					<div class="small-12 columns more-stories-container show-for-xlarge-up" id="hp-section-lead">
					<hr>
						<?php CST()->frontend->sports_heading(); ?>
						<?php CST()->frontend->mini_stories_content_block( CST()->customizer->get_upper_section_stories() ); ?>
					</div><!-- /#hp-section-lead -->
				</div>
<?php if ( function_exists( 'jetpack_is_mobile' ) && jetpack_is_mobile() ) { ?>
<div class="columns small-12 sidebar homepage-sidebar widgets mobile">
<?php
if ( is_active_sidebar( 'homepage_sidebar' ) ) {
	dynamic_sidebar( 'homepage_sidebar' );
} ?>
</div>
<?php } ?>
				<hr>
				<div class="cst-ad-container" id="nativo-cst-homepage-01"></div>
				<hr>
				<?php CST()->frontend->more_stories_content(); ?>
				<div class="lower-section-stories">
					<hr>
					<div class="row">
						<div class="columns small-12">
							<?php
							echo wp_kses( CST()->dfp_handler->unit( 3, 'div-gpt-super-leaderboard', 'dfp dfp-super-leaderboard dfp-centered' ),
								CST()->dfp_kses
							);
							?>
						</div>
					</div>
					<div class="row">
						<div class="small-12 columns more-stories-container" id="top-stories-section-lead">
							<hr>
							<?php CST()->frontend->render_section_title( 'lower_section_section_title' ); ?>
							<?php CST()->frontend->mini_stories_content_block( CST()->customizer->get_lower_section_stories() ); ?>
						</div>
					</div>
				</div><!-- /.lower-section-stories -->
				<div class="entertainment-section-stories more-stories-container" id="hp-entertainment-section-lead">
					<div class="row">
						<?php if ( function_exists( 'jetpack_is_mobile' ) && jetpack_is_mobile() ) { ?>
							<div class="columns small-12 sidebar homepage-sidebar widgets">
								<?php
								if ( is_active_sidebar( 'homepage_sidebar_three' ) ) {
									dynamic_sidebar( 'homepage_sidebar_three' );
								}
								if ( is_active_sidebar( 'homepage_sidebar_four' ) ) {
								?>
									<hr>
								<?php
									dynamic_sidebar( 'homepage_sidebar_four' );
								}
								?>
							</div>
						<?php } ?>
						<div class="small-12 columns more-stories-container">
							<hr>
							<?php CST()->frontend->render_section_title( 'entertainment_section_section_title' ); ?>
							<?php CST()->frontend->mini_stories_content_block( CST()->customizer->get_entertainment_stories() ); ?>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="columns small-12">
							<?php
							echo wp_kses( CST()->dfp_handler->unit( 4, 'div-gpt-super-leaderboard', 'dfp dfp-super-leaderboard dfp-centered' ),
								CST()->dfp_kses
							);
							?>
						</div>
					</div>
				</div>
				<div class="featured-obits-section-stories more-stories-container" id="hp-featured-obits-section-lead">
					<div class="row">
						<div class="small-12 columns more-stories-container">
							<hr>
							<?php CST()->frontend->render_section_title( 'featured_obit_section_section_title' ); ?>
							<?php CST()->frontend->mini_stories_content_block( CST()->customizer->get_featured_obits_section_stories() ); ?>
						</div>
					</div>
				</div>
				<div class="podcast-section-stories more-stories-container" id="hp-podcasts-section-lead">
					<div class="row">
						<div class="small-12 columns more-stories-container">
							<hr>
							<h2 class="more-sub-head"><?php CST()->frontend->render_term_link( 'Podcasts' ); ?></h2>
							<?php CST()->frontend->mini_stories_content_block( CST()->customizer->get_podcast_section_stories() ); ?>
						</div>
					</div>
				</div>
			</div><!-- /.stories -->
<?php if ( function_exists( 'jetpack_is_mobile' ) && ! jetpack_is_mobile() ) { ?>
			<div class="columns small-12 medium-4 large-3 sidebar homepage-sidebar widgets">
				<ul>
					<?php the_widget( 'CST_Ad_Widget', [], 'dfp-rr-cube-1' ); ?>
					<?php
					if ( is_active_sidebar( 'homepage_sidebar' ) ) {
						dynamic_sidebar( 'homepage_sidebar' );
					}
					?>
				<li class="more-stories-container two">
					<hr>
					<?php
					if ( is_active_sidebar( 'homepage_sidebar_two' ) ) {
						dynamic_sidebar( 'homepage_sidebar_two' );
					}
					?>
				</li>
				<li class="show-for-medium-up three">
					<hr>
					<?php
					if ( is_active_sidebar( 'homepage_sidebar_three' ) ) {
						dynamic_sidebar( 'homepage_sidebar_three' );
					}
?>
				</li>
				<li class="show-for-medium-up four">
					<hr>
					<?php
					if ( is_active_sidebar( 'homepage_sidebar_four' ) ) {
						dynamic_sidebar( 'homepage_sidebar_four' );
					}
					?>
				</li>
				<li class="hide-for-small-down">
					<hr>
					<?php the_widget( 'CST_STNG_Wire_Widget' ); ?>
				</li>
				</ul>
			</div>
			<!-- /.widgets -->
<?php } ?>
		</div>
		<?php
		do_action( 'above_homepage_headlines' );
		if ( is_active_sidebar( 'homepage_headlines' ) ) :
			dynamic_sidebar( 'homepage_headlines' );
		endif;
		?>

		<!-- circular flipp -->
		<div class="row">
			<div class="columns">
				<hr>
			</div>
			<?php
			if ( is_active_sidebar( 'undermorefrom' ) ) :
				dynamic_sidebar( 'undermorefrom' );
			endif;
			?>
		</div>
		<div class="row">
			<div class="large-12 columns content-wrapper cw">
			<hr>
				<?php get_template_part( 'parts/homepage/column-wells' ); ?>
			</div>
		</div>
	</div><!-- /stories-container -->
	<div class="row">
		<div class="large-12 columns foo">
			<?php
			echo wp_kses( CST()->dfp_handler->unit( 5, 'div-gpt-super-leaderboard', 'dfp dfp-super-leaderboard dfp-centered' ),
				CST()->dfp_kses
			);
			?>
		</div>
	</div>
</div>
<?php
get_footer();
