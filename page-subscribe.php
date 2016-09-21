<?php
  /* 
   * Template Name: Subscribe
   */
?>
<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<?php $obj = \CST\Objects\Page::get_by_post_id( get_the_ID() ); ?>
<?php if( $obj ) : ?>
	<?php 
		$subscribe_content = $obj->get_subscribe_title_content();
		$subscribe_print_content = $obj->get_subscribe_print_package();
		$subscribe_digital_content = $obj->get_subscribe_digital_package();
	?>
<div>
	<section id="subscribe">
		<div class="row">
			<div class="just-in-wrapper large-12 columns mbox3">
					<div class="small-12 columns">
							<div class="small-12 medium-4 columns">
							<?php if( ! empty( $subscribe_content['content']['top_left'] ) ) { ?>
								<h1><?php esc_html_e( $subscribe_content['content']['top_left'], 'chicagosuntimes' ); ?></h1>
							<?php } ?>
							<?php if( ! empty( $subscribe_content['content']['image'] ) ) { ?>
									<img src="<?php echo esc_url( $obj->get_subscribe_image_url( $subscribe_content['content']['image'] ) ); ?>" />
							<?php } ?>
							</div>
							<div class="small-12 medium-8 columns left-pad">
					<?php if( ! empty( $subscribe_content['content']['top_right'] ) ) { ?>
								<p class="floatiesL"><?php echo apply_filters( 'the_content', $subscribe_content['content']['top_right'] ); ?></p>
					<?php } ?>
							</div>
					</div>
			</div>
			<div class="mbox3 mcontent mclearfix">

				<div class="small-12 columns back">
					<div class="medium-4 columns right-border">
						<div class="small-centered large-uncentered columns">
							<?php 
							if ( $obj->get_featured_image_id() ) {
								echo $obj->get_featured_image_html(); 
							}
							?>
						</div>
					</div>

					<div class="medium-8 columns left-pad">
		<?php if( ! empty( $subscribe_print_content['print_package_1']['package_title'] ) ) { ?>
						<div class="small-12 columns lower">
							<div class="small-12 medium-8 columns details">
								<h3><?php esc_html_e( $subscribe_print_content['print_package_1']['package_title'], 'chicagosuntimes' ); ?></h3>
								<p><?php echo apply_filters( 'the_content', $subscribe_print_content['print_package_1']['package_description'] ); ?></p>
							</div>
							<div class="small-12 medium-4 columns pricing">
								<div>
									<h2><?php esc_html_e( $subscribe_print_content['print_package_1']['package_price'], 'chicagosuntimes' ); ?></h2>
									<span><a href="<?php esc_html_e( $subscribe_print_content['print_package_1']['package_url'], 'chicagosuntimes' ); ?>" target="_blank"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/promo-button-selectoffer-yellow.png" ></a></span>
								</div>
							</div>
						</div>
		<?php } ?>

		<?php if( ! empty( $subscribe_print_content['print_package_2']['package_title'] ) ) { ?>
						<div class="small-12 columns lower">
							<div class="small-12 medium-8 columns details">
								<h3><?php esc_html_e( $subscribe_print_content['print_package_2']['package_title'], 'chicagosuntimes' ); ?></h3>
								<p><?php echo apply_filters( 'the_content', $subscribe_print_content['print_package_2']['package_description'] ); ?></p>
							</div>
							<div class="small-12 medium-4 columns pricing">
								<div>
									<h2><?php esc_html_e( $subscribe_print_content['print_package_2']['package_price'], 'chicagosuntimes' ); ?></h2>
									<span><a href="<?php esc_html_e( $subscribe_print_content['print_package_2']['package_url'], 'chicagosuntimes' ); ?>" target="_blank"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/promo-button-selectoffer-yellow.png" ></a></span>
								</div>
							</div>
						</div>
		<?php } ?>

		<?php if( ! empty( $subscribe_print_content['print_package_3']['package_title'] ) ) { ?>
						<div class="small-12 columns">
							<div class="small-12 medium-8 columns details">
								<h3><?php esc_html_e( $subscribe_print_content['print_package_3']['package_title'], 'chicagosuntimes' ); ?></h3>
								<p><?php echo apply_filters( 'the_content', $subscribe_print_content['print_package_3']['package_description'] ); ?></p>
							</div>
							<div class="small-12 medium-4 columns pricing">
								<div class="last-price">
									<h2><?php esc_html_e( $subscribe_print_content['print_package_3']['package_price'], 'chicagosuntimes' ); ?></h2>
									<span><a href="<?php esc_html_e( $subscribe_print_content['print_package_3']['package_url'], 'chicagosuntimes' ); ?>" target="_blank"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/promo-button-selectoffer-yellow.png" ></a></span>
								</div>
							</div>
						</div>
		<?php } ?>
					</div>
				</div>
				<div class="small-12 columns back">
			<?php if( ! empty( $subscribe_content['content']['benefits'] ) ) { ?>
					<p class="benefit"><i><?php esc_html_e( $subscribe_content['content']['benefits'] ); ?></i></p>
			<?php } ?>
				</div>
				<div class="small-12 columns spacer">

				</div>

		<?php if( ! empty( $subscribe_digital_content['digital_package_1']['package_title'] ) ) { ?>
				<div class="small-12 columns back">
					<div class="small-12 medium-4 columns right-border">
						<h2 class="subscribe-product">Digital</h2>
						<?php if( ! empty( $subscribe_digital_content['digital_package_1']['image'] ) ) { ?>
								<img src="<?php echo esc_url( $obj->get_subscribe_image_url( $subscribe_digital_content['digital_package_1']['image'] ) ); ?>" />
						<?php } ?>
					</div>
					<div class="small-12 medium-8 columns left-pad">
						<div class="small-12 columns">
							<div class="small-12 medium-8 columns details">

								<h3><?php esc_html_e( $subscribe_digital_content['digital_package_1']['package_title'], 'chicagosuntimes' ); ?></h3>
								<p><?php echo apply_filters( 'the_content', $subscribe_digital_content['digital_package_1']['package_description'] ); ?></p>

							</div>
							<div class="small-12 medium-4 columns">
								<h2><?php esc_html_e( $subscribe_digital_content['digital_package_1']['package_price'], 'chicagosuntimes' ); ?></h2>
								<span><a href="<?php esc_html_e( $subscribe_digital_content['digital_package_1']['package_url'], 'chicagosuntimes' ); ?>" target="_blank"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/promo-button-selectoffer-yellow.png"></a></span>
							</div>
						</div>
					</div>
				</div>
		<?php } ?>

		<?php if( ! empty( $subscribe_digital_content['digital_package_2']['package_title'] ) ) { ?>
				<div class="small-12 columns back">
					<div class="small-12 medium-8 columns left-pad">
						<div class="small-12 columns">
							<div class="small-12 medium-8 columns details">

								<h3><?php esc_html_e( $subscribe_digital_content['digital_package_2']['package_title'], 'chicagosuntimes' ); ?></h3>
								<p><?php echo apply_filters( 'the_content', $subscribe_digital_content['digital_package_2']['package_description'] ); ?></p>

							</div>
							<div class="small-12 medium-4 columns">
								<h2><?php esc_html_e( $subscribe_digital_content['digital_package_2']['package_price'], 'chicagosuntimes' ); ?></h2>
								<span><a href="<?php esc_html_e( $subscribe_digital_content['digital_package_2']['package_url'], 'chicagosuntimes' ); ?>" target="_blank"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/promo-button-selectoffer-yellow.png"></a></span>
							</div>
						</div>
					</div>
				</div>
		<?php } ?>

		<?php if( ! empty( $subscribe_digital_content['digital_package_3']['package_title'] ) ) { ?>
				<div class="small-12 columns back">
					<div class="small-12 medium-8 columns left-pad">
						<div class="small-12 columns">
							<div class="small-12 medium-8 columns details">

								<h3><?php esc_html_e( $subscribe_digital_content['digital_package_3']['package_title'], 'chicagosuntimes' ); ?></h3>
								<p><?php echo apply_filters( 'the_content', $subscribe_digital_content['digital_package_3']['package_description'] ); ?></p>

							</div>
							<div class="small-12 medium-4 columns">
								<h2><?php esc_html_e( $subscribe_digital_content['digital_package_3']['package_price'], 'chicagosuntimes' ); ?></h2>
								<span><a href="<?php esc_html_e( $subscribe_digital_content['digital_package_3']['package_url'], 'chicagosuntimes' ); ?>" target="_blank"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/promo-button-selectoffer-yellow.png"></a></span>
							</div>
						</div>
					</div>
				</div>
		<?php } ?>

			</div>

		</div>
	</section>
</div>
<?php endif; ?>
<?php endwhile; else : ?>
						<p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
					<?php endif; ?>
<?php get_footer(); ?>