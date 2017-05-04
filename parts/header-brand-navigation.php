<header id="header" class="masthead">
	<div class="contain-to-grid">
		<nav class="top-bar" data-topbar role="navigation" aria-hidden="true">
			<ul class="title-area">
			</ul>
		<section class="top-bar-section">
			<ul class="right">
				<li class="has-form">
					<div class="row collapse">
						<div class="large-2 small-9 columns hide-for-small">
						<?php $weather = CST()->frontend->get_weather(); ?>
						<?php if ( ! empty( $weather ) ) { ?>
							<div class="weather">
								<a href="<?php echo esc_url( home_url( '/' ) . 'weather' ); ?>" class="weather-link">
	<span class="degrees"><i class="wi <?php echo esc_attr( CST()->frontend->get_weather_icon( $weather[0]->WeatherIcon ) ); ?>"></i>
		<?php echo esc_html( $weather[0]->Temperature->Imperial->Value . '&deg;' ); ?></span>
								</a>
							</div>
						<?php } ?>
						</div>
					</div>
				</li>
				<li class="has-form">
					<div class="row collapse">
						<div class="large-2 small-2 columns subscribe-container">
							<a href="<?php echo esc_url( home_url( '/' ) . 'subscribe/' ); ?>" class="subscribe-link">Subscribe</a>
						</div>
					</div>
				</li>
			</ul>
			<ul class="left">
				<li class="has-form">
					<div class="row-collapse search">
						<div class="columns small-1 ">
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
					</div>
				</li>
				<li class="has-form">
					<div class="row-collapse">
						<?php if ( ! CST()->frontend->display_minimal_nav() ) { ?>
							<div class="columns small-1 burger-wrapper-no-fries">
									<a href="#1" class="left-off-canvas-toggle burger-bar">
											<i class="fa fa-bars"></i>
									</a>
							</div>
						<?php } ?>
					</div>
				</li>
				<li class="has-form">
					<div class="row-collapse">
						<?php if ( is_front_page() ) { ?>
							<div class="columns small-12 show-for-small-only small-logo">
								<a href="<?php echo( esc_url( home_url( '/' ) ) ); ?>">
									<img src="<?php echo esc_url( get_template_directory_uri() . '/cst-amp-logo.svg' ); ?>" alt='Chicago Sun-Times logo' height="32" width="167">
								</a>
							</div>
							<div class="columns small-12 small-logo">
								<a href="<?php echo( esc_url( home_url( '/' ) ) ); ?>">
									<img src="<?php echo esc_url( get_template_directory_uri() . '/cst-amp-logo.svg' ); ?>" alt='Chicago Sun-Times logo' height="32" width="167">
								</a>
							</div>
							<div class="columns small-12 show-for-large-up">
								<?php CST()->frontend->masthead_navigation( 'homepage' ); ?>
							</div>
						<?php } else { ?>
							<div class="columns small-12 medium-10 large-2 small-logo">
								<a href="<?php echo( esc_url( home_url( '/' ) ) ); ?>">
									<img src="<?php echo esc_url( get_template_directory_uri() . '/cst-amp-logo.svg' ); ?>" alt='Chicago Sun-Times logo' height="32" width="167">
								</a>
							</div>
							<div class="columns small-10 show-for-large-up">
								<?php CST()->frontend->masthead_navigation( 'homepage' ); ?>
							</div>
						<?php } ?>
					</div>
				</li>
			</ul>
		</section>
		</nav>
	</div>
	<?php if ( is_singular( array( 'cst_article', 'cst_gallery' ) ) ) { ?>
		<section id="headlines-slider">
			<?php echo CST()->get_template_part( 'headlines/headlines-slider' ); ?>
		</section>
	<?php } ?>
</header>
<div class="off-canvas-wrap" data-offcanvas>
	<main class="inner-wrap">
<?php if ( is_front_page() ) { ?>
		<div class="responsive-logo-wrapper row">
			<div class="columns">

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
</div>
<?php } ?>
<?php get_template_part( 'parts/off-canvas-menu' );

