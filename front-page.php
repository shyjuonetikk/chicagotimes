<?php get_header(); ?>
	<div class="homepage-content">
		<div class="row">
			<div class="columns small-12">
			<?php if ( get_query_var( 'showads', false ) ) { ?>
				<div class="cst-ad-container dfp dfp-centered"><img src="http://placehold.it/970x90/6060e5/130100&amp;text=[ad-will-be-responsive]"></div>
			<?php } ?>
			</div>
		</div>
		<?php
		do_action( 'above-homepage-headlines' );
		if ( is_active_sidebar( 'homepage_headlines' ) ) :
			dynamic_sidebar( 'homepage_headlines' );
		endif;
		?>
		<div class="columns small-12 medium-4 large-3 sidebar homepage-sidebar widgets">
			<?php if ( get_query_var( 'showads', false ) ) { ?>
				<?php if ( is_active_sidebar( 'homepage_sidebar' ) ) {
					dynamic_sidebar( 'homepage_sidebar' );
				} ?>
			<?php } ?>
			<div class="more-stories-container hide-for-large-up">
				<hr>
				<div class="other-stories">
					<h2>Also in the Chicago Sun-Times</h2>
					<ul class="list">
						<li><span class="section-name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="section-link">Chicago News</a></span> <a href="<?php echo esc_url( 'http://chicago.suntimes.com/columnists/wanted-conservative-sports-network-to-compete-with-espn/' ); ?>" class=" magic-link-size">Mentally ill woman gets 22 years for killing husband with poison</a></li>
						<li><span class="section-name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="section-link">Chicago News</a></span> <a href="<?php echo esc_url( 'http://chicago.suntimes.com/columnists/wanted-conservative-sports-network-to-compete-with-espn/' ); ?>" class=" magic-link-size">9 charged with Crystal Lake fight that led to stabbing</a></li>
						<li><span class="section-name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="section-link">Chicago Sports</a></span> <a href="<?php echo esc_url( 'http://chicago.suntimes.com/columnists/wanted-conservative-sports-network-to-compete-with-espn/' ); ?>" class=" magic-link-size">Anthony Swarzak gettung career back on track with White Sox</a></li>
						<li><span class="section-name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="section-link">Entertainment</a></span> <a href="<?php echo esc_url( 'http://chicago.suntimes.com/columnists/wanted-conservative-sports-network-to-compete-with-espn/' ); ?>" class=" magic-link-size">Dear Abby: My friend bullies other kids at school</a></li>
						<li><span class="section-name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="section-link">Chicago Politics</a></span> <a href="<?php echo esc_url( 'http://chicago.suntimes.com/columnists/wanted-conservative-sports-network-to-compete-with-espn/' ); ?>" class=" magic-link-size">Sneed exclusive: City could deal blow to Trump wall contractors</a></li>
					</ul>
				</div>
			</div>
			<?php if ( get_query_var( 'showads', false ) ) { ?>
				<div class="cst-ad-container">
					<hr>
					<img src="http://placehold.it/300x250/e0e0e0/130100&amp;text=[300x250-ad-will-be-responsive]">
				</div>
			<?php } ?>
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
