<aside class="menu-footer-fixed menu-footer-fixed-bottom">
	<div id="menu-footer-container">
		<div id="menu-footer-fixed">
			<div class="menu-footer-more-info">
			<span class="follow_us"><?php esc_html_e( 'Follow Us', 'chicagosuntimes' ); ?>
			<a href="<?php echo esc_url( sprintf( 'https://twitter.com/%s', CST_TWITTER_USERNAME ) ); ?>" target="_blank"><i class="fa fa-twitter"></i></a> 
			<a href="http://www.facebook.com/thechicagosuntimes" target="_blank"><i class="fa fa-facebook"></i></a> 
			<a href="http://www.youtube.com/user/chicagosuntimestv" target="_blank"><i class="fa fa-youtube-play"></i></a></span>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php get_template_part( 'parts/images/menu-fixed-footer-company-logo' ); ?>
				</a>
				<?php get_template_part( 'parts/images/menu-fixed-footer-site-logo' ); ?>
				<ul>
					<li><a href="<?php echo esc_url( "http://advertising.suntimes.com/" ); ?>"><?php esc_html_e( 'Advertise', 'chicagosuntimes' ); ?></a> |</li>
					<li><a href="<?php echo esc_url( "http://wssp.suntimes.com/privacy-policy/" ); ?>"><?php esc_html_e( 'Privacy Policy', 'chicagosuntimes' ); ?></a> |</li>
					<li><a href="<?php echo esc_url( "http://wssp.suntimes.com/terms-of-use/" ); ?>"><?php esc_html_e( 'Terms', 'chicagosuntimes' ); ?></a> |</li>
					<li><a href="<?php echo esc_url( "http://wssp.suntimes.com/aboutus/" ); ?>"><?php esc_html_e( 'About Us', 'chicagosuntimes' ); ?></a> |</li>
					<li><a href="<?php echo esc_url( "http://wssp.suntimes.com/about-our-ads/" ); ?>"><?php esc_html_e( 'About Our Ads', 'chicagosuntimes' ); ?></a> |</li>
					<li><a href="<?php echo esc_url( "http://wssp.suntimes.com/about-sponsored-content/" ); ?>"><?php esc_html_e( 'About Sponsored Content', 'chicagosuntimes' ); ?></a></li>
				</ul>
				<span class="copyright">Copyright &copy; <?php echo date( 'Y' ); ?>. Sun-Times Media, LLC All Rights Reserved.</span>
				<p class="vip-text"><a href="http://vip.wordpress.com" target="_blank">Powered by WordPress.com VIP</a></p>
			</div>
		</div>
	</div>
</aside>
