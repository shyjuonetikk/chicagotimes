<nav class="amp-wp-title-bar">
		<ul class="section-menu">
			<li class="section-heading">&#9776;
				<ul>
					<li class="header">Sections</li>
					<li class="item"><a href="<?php echo esc_url( $this->get( 'home_url' ) ); ?>/section/news/">News</a></li>
					<li class="item"><a href="<?php echo esc_url( $this->get( 'home_url' ) ); ?>/section/crime/">Crime</a></li>
					<li class="item"><a href="<?php echo esc_url( $this->get( 'home_url' ) ); ?>/section/business/">Business</a></li>
					<li class="item"><a href="<?php echo esc_url( $this->get( 'home_url' ) ); ?>/section/chicago/">Chicago</a></li>
					<li class="item"><a href="<?php echo esc_url( $this->get( 'home_url' ) ); ?>/section/the-watchdogs/">The Watchdogs</a></li>
					<li class="item"><a href="<?php echo esc_url( $this->get( 'home_url' ) ); ?>/section/sports/">Sports</a></li>
					<li class="item"><a href="<?php echo esc_url( $this->get( 'home_url' ) ); ?>/section/politics/">Politics</a></li>
					<li class="item"><a href="<?php echo esc_url( $this->get( 'home_url' ) ); ?>/section/entertainment/">Entertainment</a></li>
					<li class="item"><a href="<?php echo esc_url( $this->get( 'home_url' ) ); ?>/section/columnists/">Columnists</a></li>
					<li class="item"><a href="<?php echo esc_url( $this->get( 'home_url' ) ); ?>/section/opinion/">Opinion</a></li>
					<li class="item"><a href="<?php echo esc_url( $this->get( 'home_url' ) ); ?>/section/lifestyles/">Lifestyles</a></li>
					<li class="item"><a href="<?php echo esc_url( $this->get( 'home_url' ) ); ?>/section/dear-abby/">Dear Abby</a></li>
					<li class="item"><a href="<?php echo esc_url( $this->get( 'home_url' ) ); ?>/section/horoscopes/">Horoscopes</a></li>
					<li class="section-break"></li>
					<li class="colophon"><a href="http://wssp.suntimes.com/terms-of-use/">Terms of Use</a></li>
					<li class="colophon"><a href="http://wssp.suntimes.com/privacy-policy/">Privacy Policy</a></li>
					<li class="colophon"><a href="http://wssp.suntimes.com/contact-us/">Contact Us</a></li>
					<li class="copyright"><?php echo esc_html( sprintf( 'Copyright &copy; 2005-%d' , date( 'Y' ) ) ); ?></li>
					<li class="copyright"><?php echo esc_html( "Chicago Sun-Times" ); ?></li>

				</ul>
			</li>
		</ul>
		<div id="closemenu">&#215;</div>
	<div>
		<a class="site-logo" href="<?php echo esc_url( $this->get( 'home_url' ) ); ?>">
			<?php $site_icon_url = $this->get( 'site_icon_url' ); ?>
			<?php if ( $site_icon_url ) : ?>
				<amp-img src="<?php echo esc_url( $site_icon_url ); ?>" width="32" height="32" class="amp-wp-site-icon"></amp-img>
			<?php endif; ?>
			<?php echo esc_html( $this->get( 'blog_name' ) ); ?>
		</a>
	</div>
</nav>
