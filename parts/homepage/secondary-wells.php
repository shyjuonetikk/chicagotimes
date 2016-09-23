<?php global $homepage_secondary_well_posts; ?>
<div class="row">
	<div class="large-12 content-wrapper">
		<div class="large-8 columns secondary-well-container">
			<section id="secondary-wells">
				<div class="secondary-well-lower">
					<div class="large-12 medium-12">
						<?php
						$obj = \CST\Objects\Post::get_by_post_id( $homepage_secondary_well_posts[0]->ID );
						if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
							$primary_section = $obj->get_primary_parent_section();
							$author          = CST()->frontend->get_article_author( $obj );
							?>
							<div class="large-6 medium-6 small-12 columns">
								<?php CST()->frontend->well_article_container_markup( $obj, $author, $primary_section, 'chiwire-header-small' ); ?>
							</div>
							<?php
						}
						$obj = \CST\Objects\Post::get_by_post_id( $homepage_secondary_well_posts[1]->ID );
						if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
							$primary_section = $obj->get_primary_parent_section();
							$author          = CST()->frontend->get_article_author( $obj );
							?>
							<div class="large-6 medium-6 small-12 columns">
								<?php CST()->frontend->well_article_container_markup( $obj, $author, $primary_section, 'chiwire-header-small' ); ?>
							</div>
							<?php
						}
						?>
					</div>
				</div>
				<hr class="before-ad">
				<div class="large-6 medium-6 small-12 columns dfp-cube cube-left">
					<?php echo CST()->dfp_handler->unit( 2, 'div-gpt-rr-cube', 'dfp dfp-cube' ); ?>
				</div>
				<div class="large-6 medium-6 small-12 columns dfp-cube cube-right">
					<?php echo CST()->dfp_handler->unit( 3, 'div-gpt-rr-cube', 'dfp dfp-cube' ); ?>
				</div>
				<hr class="after-ad">
				<div class="secondary-well-bottom">
					<div class="large-12 medium-12">
						<?php
						$obj = \CST\Objects\Post::get_by_post_id( $homepage_secondary_well_posts[2]->ID );
						if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
							$primary_section = $obj->get_primary_parent_section();
							$author          = CST()->frontend->get_article_author( $obj );
							?>
							<div class="large-6 medium-6 small-12 columns c">
								<?php CST()->frontend->well_article_container_markup( $obj, $author, $primary_section, 'chiwire-header-small' ); ?>
							</div>
							<?php
						}
						?>
						<?php
						$obj = \CST\Objects\Post::get_by_post_id( $homepage_secondary_well_posts[3]->ID );
						if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
							$primary_section = $obj->get_primary_parent_section();
							$author          = CST()->frontend->get_article_author( $obj );
							?>
							<div class="large-6 medium-6 small-12 columns d">
								<?php CST()->frontend->well_article_container_markup( $obj, $author, $primary_section, 'chiwire-header-small' ); ?>
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</section>
