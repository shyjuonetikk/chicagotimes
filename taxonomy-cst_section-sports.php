<?php
get_header();
?>
	<section class="section_front_wrapper stories-container sports">
		<div class="row">
			<div id="main" class="wire columns medium-8 large-9 small-12">
				<div id="fixed-back-to-top" class="hide-back-to-top">
					<a id="back-to-top" href="#">
						<p><i class="fa fa-arrow-circle-up"></i><?php esc_html_e( 'Back To Top', 'chicagosuntimes' ); ?></p>
					</a>
				</div>
				<?php get_template_part( 'parts/section/taxonomy-top' ); ?>
				<div class="row">
					<div class="small-12 columns more-stories-container" id="sf-section-lead">
						<h2 class="more-sub-head">&nbsp;</h2>
						<?php \CST_Frontend::get_instance()->mini_stories_content_block( \CST_Customizer::get_instance()->get_upper_section_stories() ); ?>
					</div><!-- /#sf-section-lead -->
				</div>
				<?php if ( function_exists( 'jetpack_is_mobile' ) && jetpack_is_mobile() ) { ?>
				<hr>
					<div class="columns small-12 sidebar sf-inline-sidebar widgets mobile">
						<?php
						the_widget( 'CST_Ad_Widget', [], [
							'slot'    => 'dfp-rr-cube-1',
							'mapping' => 'sports_sf_mobile',
						] );
						?>
					</div>
				<hr>
				<?php } ?>
				<div class="row">
					<div class="columns small-12 more-stories-container">
						<h2 class="more-sub-head"><a href="#">Featured Sports Stories</a></h2>
					</div>
					<div class="columns small-12 medium-12 large-4 three-block stories">
						<?php CST()->frontend->homepage_lead_story( 'cst_sports_section_three_block_two_one_1' ); ?>
						<?php CST()->frontend->homepage_lead_story( 'cst_sports_section_three_block_two_one_2' ); ?>
					</div><!-- /hp-main-lead -->
					<div class="columns small-12 large-8 more-stories-container other-lead-stories sf-video-container">
						<div class="js-cst-sports-section-three-block-two-one-3">
							<?php
							CST_Customizer::get_instance()->send_to_news_render_callback( 'cst_sports_section_three_block_two_one_3' );
							?>
						</div>
						<div class="show-for-large-up">
							<?php
							CST()->frontend->inject_newsletter_signup( [
								'newsletter'    => 'sports',
								'wrapper_class' => 'small-12 newsletter-box',
							] );
							?>
						</div>
					</div>
				</div>
				<?php if ( function_exists( 'jetpack_is_mobile' ) && jetpack_is_mobile() && is_active_sidebar( 'sports_sf_sidebar' ) ) { ?>
					<div class="small-12 sidebar widgets mobile">
						<ul class="widgets">
						<?php dynamic_sidebar( 'sports_sf_sidebar' ); ?>
						</ul>
					</div>
				<?php } ?>
				<hr>
				<div class="cst-ad-container" id="nativo-cst-homepage-01"></div>
				<hr>
				<div class="team-stories">
				<?php
				$current_obj = get_queried_object();
				\CST\CST_Section_Front::get_instance()->render_section_blocks( $current_obj->slug . '_section_sorter-collection' );
				?>
				</div>
				<?php if ( function_exists( 'jetpack_is_mobile' ) && jetpack_is_mobile() && is_active_sidebar( 'sports_sf_bottom_sidebar' ) ) { ?>
					<div class="small-12 sidebar widgets mobile">
						<ul class="widgets">
						<?php dynamic_sidebar( 'sports_sf_bottom_sidebar' ); ?>
						</ul>
					</div>
				<?php } ?>
			</div>
			<?php if ( function_exists( 'jetpack_is_mobile' ) && ! jetpack_is_mobile() ) { ?>
				<div class="right-rail columns medium-4 large-3 show-for-medium-up">
					<?php
						get_sidebar();
					?>
				</div>
			<?php } ?>
		</div>


	</section>

<?php
get_footer();
