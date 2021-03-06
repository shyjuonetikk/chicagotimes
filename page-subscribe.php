<?php
  /* 
   * Template Name: Subscribe
   */
?>
<?php
if ( isset($_REQUEST['promo-code-input']) && '' !== $_REQUEST['promo-code-input'] ) {
	$check_promo_nonce = wp_verify_nonce( $_REQUEST['_wpnonce'], '_wpnonce_promo_code_request' );
	if ( 1 === $check_promo_nonce ) {
		$offer_code = sanitize_text_field( $_REQUEST['promo-code-input'] );
		$redirect_url = false;
		switch ( $offer_code ) {
			case 'CST Promo 1':
				$redirect_url = 'https://suntiservices.dticloud.com/cgi-bin/cmo_cmo.sh/custservice/web/addrfind.html?siteid=CST&campaign=wbmem1699';
				break;
			case 'CST Promo 2':
				$redirect_url = 'https://suntiservices.dticloud.com/cgi-bin/cmo_cmo.sh/custservice/web/addrfind.html?siteid=CST&campaign=wbmemon295';
				break;
			case 'cityclub':
				$redirect_url = 'https://suntiservices.dticloud.com/cgi-bin/cmo_cmo.sh/custservice/web/addrfind.html?siteid=CST&campaign=wbmem1699';
				break;
			default:
				wp_sanitize_redirect( esc_url( get_permalink() ) );
		}
		if ( $redirect_url ) {
			wp_redirect( $redirect_url );
		}
	}
}
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
			<div class="just-in-wrapper large-12 columns mbox3 lower">
					<div class="small-12 columns">
							<div class="small-12 medium-4 columns">
							<?php if( ! empty( $subscribe_content['content']['top_left'] ) ) { ?>
								<h1><?php esc_html_e( $subscribe_content['content']['top_left'], 'chicagosuntimes' ); ?></h1>
							<?php } ?>
							<?php if( ! empty( $subscribe_content['content']['image'] ) ) { ?>
									<img src="<?php echo esc_url( $obj->get_subscribe_image_url( $subscribe_content['content']['image'] ) ); ?>" />
							<?php } ?>
								<hr>
								<h1>Special Promo</h1>
							</div>
							<div class="small-12 medium-8 columns left-pad">
					<?php if( ! empty( $subscribe_content['content']['top_right'] ) ) { ?>
								<p class="floatiesL"><?php echo apply_filters( 'the_content', $subscribe_content['content']['top_right'] ); ?></p>
					<?php } ?>
								<hr>
								<p>Have a promo code? Enter your code below and be directed to our subscribe service.</p>
								<form method="GET" class="promo-code-wrap" autocomplete="off" action="<?php echo esc_url( get_permalink() ); ?>">
									<div class="small-4 columns promo-code">
										<input class="promo-code-input" placeholder="<?php esc_attr_e( 'Code...', 'chicagosuntimes' ); ?>" name="promo-code-input" value=""/>
									</div>
									<div class="small-8 columns promo-code">
										<button type="submit" class="promo-code-push">
											<span><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/promo-button-selectoffer-yellow.png" class="img-responsive promo-img"></span>
										</button>
									</div>
									<?php wp_nonce_field( '_wpnonce_promo_code_request' ) ?>
								</form>
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
<?php get_footer();
