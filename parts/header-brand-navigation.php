<div class="off-canvas-wrap" data-offcanvas>
	<div class="inner-wrap">
		<header id="header" class="masthead">
<div class="row">
	<div class="contain-to-grid columns">
		<nav class="top-bar" data-topbar role="navigation">
			<div class="responsive-logo-wrapper">
				<ul class="title-area">
					<li class="search hide-for-large-up">
						<div class="utility">
							<ul>
								<li class="has-form">
									<div class="search">
										<form class="search-wrap" autocomplete="off" action="<?php echo esc_url( home_url( '/' ) ); ?>">
											<ul class="left">
												<li class="has-form">
													<div class="row collapse search-input-wrapper">
														<div class="large-1 small-1 columns search-icon hide-for-small-only"><i class="fa fa-search"></i></div>
														<div class="large-5 small-5 columns hide-for-small-only">
															<input type="text" id="search-field" class="search-input" placeholder="<?php esc_attr_e( 'SEARCH', 'chicagosuntimes' ); ?>" name="s" value="<?php echo esc_attr( get_search_query() ); ?>"/>
														</div>
														<div class="large-5 small-11 columns">
															<a href="#" class="left-off-canvas-toggle" id="burger-bar">
																<i class="fa fa-bars"></i>
															</a>
														</div>
													</div>
												</li>
											</ul>
										</form>
									</div>
								</li>
							</ul>
						</div>
					</li>
					<li class="name">
						<h1>
							<a class="logo small-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
								<img src="<?php echo esc_url( get_template_directory_uri() . '/cst-amp-logo.svg' ); ?>" alt='Chicago Sun-Times logo' height="45" width="230">
							</a>
						</h1>
					</li>
				</ul>
			</div>

			<section class="top-bar-section">
				<div class="utility">
					<ul>
						<li class="has-form">
					<div class="search">
						<form class="search-wrap" autocomplete="off" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							<ul class="left">
								<li class="has-form">
									<div class="row collapse search-input-wrapper hide-for-medium-down">
										<div class="large-1 small-1 columns search-icon">
											<a href="#" data-reveal-id="search-container">
											<i class="fa fa-search"></i>
											</a>
										</div>
										<div class="large-5 small-5 columns">
											<a href="#" class="left-off-canvas-toggle" id="burger-bar">
												<i class="fa fa-bars"></i>
											</a>
										</div>
									</div>
								</li>
							</ul>
						</form>
					</div>
						</li>
					</ul>
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
						<div id="div-gpt-sponsor-ear-left" class="sponsor-ear left"></div>
						<div id="div-gpt-sponsor-ear-right" class="sponsor-ear right"></div>
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
					'items_wrap' => '<div class="nav-holder"><div class="nav-descriptor"><ul><li>In the news:</li></ul><ul id="%1$s" class="">%3$s</ul></div></div>',
					'walker' => new GC_walker_nav_menu(),
					)
				);
				?>
			</section>
		</nav>
	</div>
</div>
		</header>


<?php get_template_part( 'parts/off-canvas-menu' );

