<header id="header" class="masthead">
	<div class="contain-to-grid">
		<nav class="top-bar" data-topbar role="navigation" aria-hidden="true">
			<ul class="title-area">
				<li class="has-form hide-for-large-up">
					<a href="#0" class="left-off-canvas-toggle burger-bar">
						<i class="fa fa-bars"></i>
					</a>
				</li>
				<?php if ( is_front_page() ) { ?>
					<li class="has-form section-navigation hide-for-large-up">
						<?php CST()->frontend->masthead_navigation( 'homepage' ); ?>
					</li>
				<?php } else { ?>
				<li class="name hide-for-large-up">
					<div class="medium-2 small-3 columns logo-container">
						<div class="small-logo">
							<a href="<?php echo( esc_url( home_url( '/' ) ) ); ?>">
								<img src="<?php echo esc_url( get_template_directory_uri() . '/cst-amp-logo.svg' ); ?>" alt='Chicago Sun-Times logo' height="32" width="167">
							</a>
						</div>
					</div>
					<div class="medium-8 small-7 columns nav-container">
						<?php CST()->frontend->masthead_navigation( 'homepage' ); ?>
					</div>
				</li>
				<?php } ?>
			</ul>
			<section class="top-bar-section">
				<ul class="left">
					<li class="has-form">
						<div class="search">
							<form class="search-wrap" autocomplete="off" action="<?php echo esc_url( home_url( '/' ) ); ?>">
								<div class="row collapse search-input-wrapper">
									<div class="large-1 small-1 columns search-icon">
										<a href="#" data-reveal-id="search-container">
											<i class="fa fa-search"></i>
										</a>
									</div>
								</div>
							</form>
						</div>
					</li>
					<li class="has-form">
						<a href="#0" class="left-off-canvas-toggle burger-bar">
							<i class="fa fa-bars"></i>
						</a>
					</li>
					<?php if ( is_front_page() ) {?>
					<li class="has-form">
						<?php CST()->frontend->masthead_navigation( 'homepage' ); ?>
					</li>
					<?php } else { ?>
						<li class="has-form">
							<div class="row">
								<div class="small-12 small-centered columns">
									<div class="logo">
										<a href="<?php echo( esc_url( home_url( '/' ) ) ); ?>">
											<img src="<?php echo esc_url( get_template_directory_uri() . '/cst-amp-logo.svg' ); ?>" alt='Chicago Sun-Times logo' height="38" width="200">
										</a>
									</div>
								</div>
							</div>
						</li>
						<li class="has-form">
							<div class="row">
								<div class="small-12 columns">
									<?php CST()->frontend->masthead_navigation( 'homepage' ); ?>
								</div>
							</div>
						</li>
					<?php } ?>
				</ul>

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
			</section>
		</nav>
	</div>
	<?php if ( is_singular() ) { ?>
		<section id="headlines-slider">
			<?php echo CST()->get_template_part( 'headlines/headlines-slider' ); ?>
		</section>
	<?php } ?>
</header>
<div class="off-canvas-wrap" data-offcanvas>
	<main class="inner-wrap">
<?php if ( is_front_page() ) { ?>
		<div class="responsive-logo-wrapper row">
	<?php if ( ! is_page_template( 'page-monster.php' ) ) { ?>
			<div id="div-gpt-sponsor-ear-left" class="sponsor-ear left"></div>
			<div id="div-gpt-sponsor-ear-right" class="sponsor-ear right"></div>
	<?php } ?>
		<div class="logo-wrapper large-logo">
			<div class="logo">
				<a href="<?php echo( esc_url( home_url( '/' ) ) ); ?>">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/cst-masthead.svg' ); ?>" alt='Chicago Sun-Times logo'>
				</a>
				<div class="date"><?php echo esc_html( date_i18n( 'l, F j, Y' ) ); ?></div>
			</div>
		</div>
	<?php CST()->frontend->masthead_navigation( 'homepage-itn' ); ?>
</div>
<?php } ?>
<?php get_template_part( 'parts/off-canvas-menu' );

