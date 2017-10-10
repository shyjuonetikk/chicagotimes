<?php get_header(); ?>
	<section class="section_front_wrapper">
		<div class="row">
			<div id="main" class="wire columns medium-8 large-8 small-12">
				<div id="fixed-back-to-top" class="hide-back-to-top">
					<a id="back-to-top" href="#">
						<p><i class="fa fa-arrow-circle-up"></i><?php esc_html_e( 'Back To Top', 'chicagosuntimes' ); ?></p>
					</a>
				</div>
				<?php get_template_part( 'parts/section/taxonomy-top' ); ?>
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
						<div class="columns small-12 more-stories-container">
							<h2 class="more-sub-head"><a href="#">What Headline here - new video player below</a></h2>
							<hr>
						</div>
						<div class="columns small-12 large-4 stories">
							<?php \CST\CST_Section_Front::get_instance()->section_hero_story( 'cst_sports_section_five_block_1' ) ?>
							<?php CST()->frontend->homepage_lead_story( 'cst_sports_section_five_block_2' ) ?>
						</div><!-- /hp-main-lead -->
						<div class="columns small-12 large-8 more-stories-container other-lead-stories">
							<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/video-sample-image-01.jpg' ) ; ?>" alt="">
							<div class="show-for-large-up">
								<?php CST()->frontend->inject_newsletter_signup( [ 'newsletter' => 'sports', 'wrapper_class' => 'small-12 newsletter-box' ] ); ?>
							</div>
						</div>
					</div>
				</div>
				<?php foreach ( \CST\CST_Section_Front::get_instance()->chicago_sports_team_slugs as $chicago_sports_team_slug ) {
					$term_link = wpcom_vip_get_term_link( $chicago_sports_team_slug,'cst_section' );
					if ( ! is_wp_error( $term_link ) ) {
						?>
						<div class="row">
							<div class="stories-container">
								<div class="small-12 columns more-stories-container <?php echo esc_attr( $chicago_sports_team_slug); ?>" id="individual-sports-section-<?php echo esc_attr( $chicago_sports_team_slug); ?>">
									<?php \CST\CST_Section_Front::get_instance()->heading( $chicago_sports_team_slug . ' Headlines', $chicago_sports_team_slug ); ?>
									<hr>
									<?php \CST_Frontend::get_instance()->mini_stories_content_block( \CST\CST_Section_Front::get_instance()->create_partials( $chicago_sports_team_slug ) ); ?>
									<hr>
								</div><!-- /individual-sports-section-{sport} -->
							</div>
						</div>

						<hr>
						<h5>Ad injection here perhaps?</h5>
						<hr>
						<?php
					}
				}?>
			</div>

			<div class="right-rail columns medium-4 large-4 show-for-medium-up">
				<h3>Sidebar temporarily disabled due to TCX widget loading lag</h3>
				<?php //get_sidebar(); ?>
			</div>
		</div>


	</section>

<?php get_footer();
