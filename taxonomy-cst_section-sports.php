<?php get_header(); ?>
	<section class="section_front_wrapper sports">
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
							<?php \CST_Frontend::get_instance()->mini_stories_content_block( \CST_Customizer::get_instance()->get_upper_section_stories() ); ?>
						</div><!-- /#sf-section-lead -->
					</div>
				</div>
				<div class="row">
					<div class="stories-container">
						<div class="columns small-12 more-stories-container">
							<h2 class="more-sub-head"><a href="#">Slottable Sports Section Front Stories and Video Player</a></h2>
						</div>
						<div class="columns small-12 large-4 stories">
							<?php \CST\CST_Section_Front::get_instance()->section_hero_story( 'cst_sports_section_three_block_two_one_1' ) ?>
							<?php CST()->frontend->homepage_lead_story( 'cst_sports_section_three_block_two_one_2' ) ?>
						</div><!-- /hp-main-lead -->
						<div class="columns small-12 large-8 more-stories-container other-lead-stories">
							<?php $obj = \CST\Objects\Post::get_by_post_id( get_theme_mod( 'cst_sports_section_three_block_two_one_3' ) );
							\CST_Frontend::get_instance()->single_mini_story( [
									'story' => $obj,
									'partial_id' => 'cst_sports_section_three_block_two_one_3',
									'custom_image_size' => 'chiwire-header-large',
							]); ?>
							<div class="show-for-large-up">
								<?php CST()->frontend->inject_newsletter_signup( [ 'newsletter' => 'sports', 'wrapper_class' => 'small-12 newsletter-box' ] ); ?>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<div class="cst-ad-container" id="nativo-cst-homepage-01">Nativo position here</div>
				<hr>
				<?php $current_obj = get_queried_object();
				\CST\CST_Section_Front::get_instance()->render_section_blocks( $current_obj->slug . '_section_sorter-collection' ); ?>
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
			</div>

			<div class="right-rail columns medium-4 large-4 show-for-medium-up">
				<h3>Sidebar temporarily disabled due to TCX widget loading lag</h3>
				<?php //get_sidebar(); ?>
			</div>
		</div>


	</section>

<?php get_footer();
