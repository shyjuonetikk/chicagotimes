<header id="header" class="masthead">

	<div class="contain-to-grid sticky">
		<nav class="top-bar" data-topbar role="navigation">
			<div class="responsive-logo-wrapper">
				<ul class="title-area">
					<li class="name">
						<h1>
							<a class="logo small-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
								<?php get_template_part( 'parts/images/company-logo' ); ?>
							</a>
						</h1>
					</li>
					<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
				</ul>
			</div>

			<section class="top-bar-section">
				<div class="utility row">
					<div class="search">
						<form class="search-wrap" autocomplete="off" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							<ul class="left">
								<li class="has-form">
									<div class="row collapse search-input-wrapper">
										<div class="large-8 small-9 columns">
											<input type="text" id="search-field" class="search-input" placeholder="<?php esc_attr_e( 'Search', 'chicagosuntimes' ); ?>" name="s" value="<?php echo esc_attr( get_search_query() ); ?>"/>
										</div>
										<div class="large-4 small-3 columns">
											<label for="search-field" class="search-icon"><i class="fa fa-search"></i></label>
										</div>
									</div>
								</li>
							</ul>
						</form>
					</div>
					<div class="nav-tools">
						<ul class="right">
							<li class="has-form">
								<?php $weather = CST()->frontend->get_weather(); ?>
								<?php if ( ! empty( $weather ) ) { ?>
									<div class="weather">
										<a href="<?php echo esc_url( home_url( '/' ) . 'weather' ); ?>" class="weather-link">
					<span class="degrees"><i class="wi <?php echo esc_attr( CST()->frontend->get_weather_icon( $weather[0]->WeatherIcon ) ); ?>"></i>
						<?php echo esc_html( $weather[0]->Temperature->Imperial->Value . '&deg;' ); ?></span>
										</a>
									</div>
								<?php } ?>
							</li>
							<li class="has-form">
								<span class="subscribe-link"><a href="#" data-reveal-id="subscribe-modal">Subscribe</a></span>
							</li>
						</ul>
					</div>
				</div>
				<?php if ( ! is_page_template( 'page-monster.php' ) ) { ?>
					<div class="sponsor-wrapper">
						<div id="div-gpt-sponsor-ear-left" class="sponsor-ear left hide-for-large-down"></div>
						<div id="div-gpt-sponsor-ear-right" class="sponsor-ear right hide-for-large-down"></div>
					</div>
				<?php } ?>
				<div class="logo-wrapper large-logo">
					<div class="logo">
						<a href="<?php echo ( esc_url( home_url( '/' ) ) ); ?>">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/cst-masthead.svg' ); ?>" alt='Chicago Sun-Times logo'>
						</a>
						<div class="date"><?php echo esc_html( date_i18n( 'l, F j, Y' ) ); ?></div>
					</div>
				</div>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'homepage-menu',
					'fallback_cb' => false,
					'depth' => 2,
					'container_class' => 'cst-navigation-container',
					'items_wrap' => '<ul id="%1$s" class="">%3$s</ul>',
					'walker' => new GC_walker_nav_menu(),
					)
				);
				?>
			</section>
		</nav>
	</div>
</header>
