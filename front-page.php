<?php get_header(); ?>
	<div class="homepage-content stories-container">
		<div class="row">
			<div class="columns small-12">
			<?php if ( get_query_var( 'showads', false ) ) { ?>
				<div class="cst-ad-container dfp dfp-centered"><img src="http://placehold.it/970x90/6060e5/130100&amp;text=[ad-will-be-responsive]"></div>
			<?php } ?>
			</div>
		</div>
		<div class="row stories-container">
			<div class="columns small-12 medium-8 large-9 stories">
				<div class="row" data-equalizer-mq="large-up">
					<div class="columns small-12 large-4 lead-stories">
						<?php CST()->frontend->homepage_hero_story( 'cst_homepage_headlines_one' ) ?>
						<?php CST()->frontend->handle_related_content(); ?>
						<?php CST()->frontend->homepage_lead_story( 'cst_homepage_headlines_two' ) ?>
						<?php CST()->frontend->homepage_lead_story( 'cst_homepage_headlines_three' ) ?>
						<div class="show-for-large-up">
							<?php CST()->frontend->inject_newsletter_signup( 'news' ); ?>
						</div>
					</div><!-- /hp-main-lead -->
					<div class="columns small-12 large-8 other-lead-stories">
						<div class="show-for-medium-only"><h3>In other news</h3></div>
						<div id="hp-other-lead">
							<div class="row lead-mini-story" id="js-cst-homepage-other-headlines-1">
								<?php
								$obj = \CST\Objects\Post::get_by_post_id( get_theme_mod( 'cst_homepage_other_headlines_1' ) );
								if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
									$author          = CST()->frontend->hp_get_article_authors( $obj );
									CST()->frontend->homepage_mini_story_lead( $obj, $author );
								}
								?>
							</div><!-- /js-cst-homepage-other-headlines-1 -->
							<hr>
							<div class="row mini-stories" data-equalizer>
							<?php
								$obj = \CST\Objects\Post::get_by_post_id( get_theme_mod( 'cst_homepage_other_headlines_2' ) );
								if ( $obj ) {
									CST()->frontend->single_mini_story( $obj, 'regular', 'cst_homepage_other_headlines_2' );
								}
								$obj = \CST\Objects\Post::get_by_post_id( get_theme_mod( 'cst_homepage_other_headlines_3' ) );
								if ( $obj ) {
									CST()->frontend->single_mini_story( $obj, 'regular', 'cst_homepage_other_headlines_3' );
								}
								$obj = \CST\Objects\Post::get_by_post_id( get_theme_mod( 'cst_homepage_other_headlines_4' ) );
								if ( $obj ) {
									CST()->frontend->single_mini_story( $obj, 'regular', 'cst_homepage_other_headlines_4' );
								}
								$obj = \CST\Objects\Post::get_by_post_id( get_theme_mod( 'cst_homepage_other_headlines_5' ) );
								if ( $obj ) {
									CST()->frontend->single_mini_story( $obj, 'regular', 'cst_homepage_other_headlines_5' );
								}
?>
							</div><!-- /mini-stories -->
						</div><!-- hp-other-lead -->
						<div class="other-stories show-for-large-up">
							<?php if ( 1 ) { // @TODO Selective display / render as this seems to trip up customizer ?>
								<hr>
								<h2>Trending in the Chicago Sun-Times (Chartbeat)</h2>
								<div id="root"></div>
								<script type="text/javascript" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/js/main.641bf377.js"></script>
							<?php } ?>
						</div>
						<div class="other-stories hide-for-xlarge-up">
							<h3>Hello</h3>
							<ul>
								<li>Please</li>
								<li>Fill</li>
								<li>me</li>
								<li>up</li>
								<li>with content</li>
							</ul>
						</div>
					</div>
					<div class="small-12 columns more-stories-container" id="hp-section-lead">
						<?php CST()->frontend->mini_stories_content_block( array(
							'cst_homepage_section_headlines_1',
							'cst_homepage_section_headlines_2',
							'cst_homepage_section_headlines_3',
							'cst_homepage_section_headlines_4',
							'cst_homepage_section_headlines_5',
						) ); ?>
					</div>
				</div>
				<?php if ( get_query_var( 'showads', false ) ) { ?>
					<div class="cst-ad-container"><img src="http://placehold.it/970x90/a0a0d0/130100&amp;text=[nativo]"></div>
				<?php } ?>
				<hr>
			</div>
			<div class="columns small-12 medium-4 large-3 sidebar homepage-sidebar widgets">
				<?php if ( get_query_var( 'showads', false ) ) { ?>
					<?php if ( is_active_sidebar( 'homepage_sidebar' ) ) {
						dynamic_sidebar( 'homepage_sidebar' );
					} ?>
				<?php } ?>
				<?php if ( get_query_var( 'showads', false ) ) { ?>
					<div class="cst-ad-container">
						<hr>
						<img src="http://placehold.it/300x250/e0e0e0/130100&amp;text=[300x250-ad-will-be-responsive]">
					</div>
				<?php } ?>
				<div class="more-stories-container hide-for-xlarge-up">
					<hr>
					<?php if ( is_active_sidebar( 'homepage_sidebar_two' ) ) {
						dynamic_sidebar( 'homepage_sidebar_two' );
					} ?>
				</div>
				<div class="row more-stories-container hide-for-landscape">
					<div class="small-12 columns">
						<hr>
						<h3 class="more-sub-head"><a href="<?php echo esc_url( '/' ); ?>">Entertainment</a></h3>
						<?php
						$query = array(
							'post_type'           => array( 'cst_article' ),
							'ignore_sticky_posts' => true,
							'posts_per_page'      => 4,
							'post_status'         => 'publish',
							'cst_section'         => 'entertainment',
							'orderby'             => 'modified',
						);
						CST()->frontend->cst_mini_stories_content_block( $query ); ?>
					</div>
				</div>
				<div>
					<hr>
					<?php the_widget( 'CST_Chartbeat_Currently_Viewing_Widget' ); ?>
				</div>
				<div class="show-for-medium-up">
					<hr>
					<?php if ( get_query_var( 'showads', false ) ) { ?>
						<img src="http://placehold.it/300x250/a0d0a0/130100&amp;text=[300x250-ad-will-be-responsive]">
					<?php } ?>
				</div>
				<div class="hide-for-medium-down">
					<hr>
					<div class="row">
						<?php //the_widget( 'CST_STNG_Wire_Widget' ); ?>
					</div>
				</div>
			</div>
		</div>
		<?php
		do_action( 'above-homepage-headlines' );
		if ( is_active_sidebar( 'homepage_headlines' ) ) :
			dynamic_sidebar( 'homepage_headlines' );
		endif;
		?>


	</div><!-- /stories-container -->
		<!-- circular flipp -->
		<div class="row">
			<div class="columns">
				<hr>
			</div>
	<?php if ( get_query_var( 'showads', false ) ) { ?>
			<?php
			if ( is_active_sidebar( 'undermorefrom' ) ) :
				dynamic_sidebar( 'undermorefrom' );
			endif;
			?>
	<?php } ?>
		</div>
		<div class="row">
			<div class="large-12 columns content-wrapper cw">
			<hr>
				<?php get_template_part( 'parts/homepage/column-wells' ); ?>
			</div>
		</div>
	</div><!-- /homepage-content -->
	<div class="row">
		<div class="large-12 columns foo">
			<?php if ( get_query_var( 'showads', false ) ) { ?>
				<?php echo wp_kses( CST()->dfp_handler->unit( 5, 'div-gpt-super-leaderboard', 'dfp dfp-super-leaderboard dfp-centered' ),
					CST()->dfp_kses
				); ?>
			<?php } ?>
		</div>
	</div>
<?php get_footer();
