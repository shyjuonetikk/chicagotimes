<?php get_header(); ?>
	<section class="section_front_wrapper">
		<div class="row">
			<div id="main" class="wire columns medium-8 large-8 small-12">
				<div id="fixed-back-to-top" class="hide-back-to-top">
					<a id="back-to-top" href="#">
						<p><i class="fa fa-arrow-circle-up"></i><?php esc_html_e( 'Back To Top', 'chicagosuntimes' ); ?></p>
					</a>
				</div>
				<?php if ( is_tax() ) : ?>
					<?php get_template_part( 'parts/section/taxonomy-top' ); ?>
				<?php elseif ( is_author() ) : ?>
					<?php get_template_part( 'parts/section/author-top' ); ?>
				<?php else : ?>
					<a id="newsfeed-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php get_template_part( 'parts/images/main-site-logo' ); ?></a>
				<?php endif; ?>
				<div class="row">
					<div class="stories-container">
						<div class="small-12 columns more-stories-container" id="sf-section-lead">
							<?php \CST\CST_Section_Front::get_instance()->heading( 'Chicago Sports Headlines', 'sports' ); ?>
							<hr>
							<?php \CST_Frontend::get_instance()->mini_stories_content_block( \CST_Customizer::get_instance()->get_upper_section_stories() ); ?>
							<hr>
						</div><!-- /#sf-section-lead -->
					</div>
				</div>
				<div class="row">
					<div class="stories-container">
						<div class="columns small-12 large-4 stories">
							<?php CST()->frontend->homepage_hero_story( 'cst_sports_section_five_block_1' ) ?>
							<?php CST()->frontend->homepage_lead_story( 'cst_sports_section_five_block_2' ) ?>
							<div class="show-for-large-up">
								<?php CST()->frontend->inject_newsletter_signup( 'sports' ); ?>
							</div>
						</div><!-- /hp-main-lead -->
						<div class="columns small-12 large-8 more-stories-container other-lead-stories">
							<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/video-sample-image-01.jpg' ) ; ?>" alt="">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="stories-container">
						<div class="small-12 columns more-stories-container" id="sf-section-lead">
							<?php \CST\CST_Section_Front::get_instance()->heading( 'Chicago Cubs Headlines', 'cubs' ); ?>
							<hr>
							<?php \CST_Frontend::get_instance()->mini_stories_content_block( \CST\CST_Section_Front::get_instance()->create_partials( 'cubs' ) ); ?>
							<hr>
						</div><!-- /#sf-section-lead -->
					</div>
				</div>
				<hr>
				<h3>Ad injection here perhaps?</h3>
				<hr>
				<div class="row">
					<div class="stories-container">
						<div class="small-12 columns more-stories-container" id="sf-section-lead">
							<?php \CST\CST_Section_Front::get_instance()->heading( 'Chicago Bulls Headlines', 'bulls' ); ?>
							<hr>
							<?php \CST_Frontend::get_instance()->mini_stories_content_block( \CST\CST_Section_Front::get_instance()->create_partials( 'bulls' ) ); ?>
							<hr>
						</div><!-- /#sf-section-lead -->
					</div>
				</div>
				<hr>
				<h3>Ad injection here perhaps?</h3>
				<hr>
			</div>

			<div class="right-rail columns medium-4 large-4 show-for-medium-up">
				<?php get_sidebar(); ?>
			</div>
		</div>


	</section>

<?php get_footer();
