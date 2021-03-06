<?php global $homepage_main_well_posts; ?>
<div class="row">
	<div class="large-12 content-wrapper">
		<h2 class="mobile-top-news show-for-small-only"><?php esc_html_e( 'Top News', 'chicagosuntimes' ); ?></h2>
		<div class="large-8 medium-7 small-12 columns main-well-container">
			<section id="main-well">
				<div class="row">
					<?php
					$obj = \CST\Objects\Post::get_by_post_id( $homepage_main_well_posts[0]->ID );
					if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
						$primary_section = $obj->get_primary_parent_section();
						$author          = CST()->frontend->get_article_author( $obj );
						?>
						<div class="large-12 medium-12 columns main-article-container">
							<?php CST()->frontend->well_article_markup( $obj, $author, $primary_section, 'chiwire-header-large', 'hp-main-well' ); ?>
						</div>
						<?php
					}
					?>
					<div class="large-12 medium-12 columns left-main-well">
						<?php
						$obj = \CST\Objects\Post::get_by_post_id( $homepage_main_well_posts[1]->ID );
						if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
							$primary_section = $obj->get_primary_parent_section();
							$author          = CST()->frontend->get_article_author( $obj );
							?>
							<div class="large-6 medium-12 columns show-for-portrait">
								<div class="article-container">
									<?php CST()->frontend->well_article_markup( $obj, $author, $primary_section, 'chiwire-header-small', 'hp-main-well' ); ?>
								</div>
							</div>
							<div class="large-6 medium-6 columns show-for-landscape">
								<div class="article-container">
									<?php CST()->frontend->well_article_markup( $obj, $author, $primary_section, 'chiwire-header-small', 'hp-main-well' ); ?>
								</div>
							</div>
							<?php
						}
						$obj = \CST\Objects\Post::get_by_post_id( $homepage_main_well_posts[2]->ID );
						if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
							$primary_section = $obj->get_primary_parent_section();
							$author          = CST()->frontend->get_article_author( $obj );
							?>
							<div class="large-6 medium-12 columns show-for-portrait">
								<div class="article-container">
									<?php CST()->frontend->well_article_markup( $obj, $author, $primary_section, 'chiwire-header-small', 'hp-main-well' ); ?>
								</div>
							</div>
							<div class="large-6 medium-6 columns show-for-landscape">
								<div class="article-container">
									<?php CST()->frontend->well_article_markup( $obj, $author, $primary_section, 'chiwire-header-small', 'hp-main-well' ); ?>
								</div>
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</section>
		</div>
		<div class="large-4 medium-5 small-12 columns homepage-sidebar">
			<?php get_template_part( 'parts/homepage/right-sidebar' ); ?>
		</div>
	</div>
</div>
<?php echo wp_kses( CST()->dfp_handler->sbb( 1 ), CST()->dfp_kses );
