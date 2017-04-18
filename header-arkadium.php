<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/apple-touch-icon-152x152.png">
	<link rel="icon" type="image/png" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/favicon-32x32.png" sizes="32x32" />
	<link rel="icon" type="image/png" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/favicon-16x16.png" sizes="16x16" />
	<meta name="msapplication-TileColor" content="#282828" />
	<meta name="msapplication-TileImage" content="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/mstile-144x144.png" />
	<meta name="msapplication-square70x70logo" content="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/mstile-70x70.png" />
	<meta name="msapplication-square150x150logo" content="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/mstile-150x150.png" />
	<meta name="msapplication-wide310x150logo" content="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/mstile-310x150.png" />
	<meta name="msapplication-square310x310logo" content="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/mstile-310x310.png" />
	<meta name="apple-itunes-app" content="app-id=930568136">
	<?php get_template_part( 'parts/analytics/google' ); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'body_start' ); ?>
<div id="ie8-user" style="display:none;"></div>
<div class="page_wrapper">
	<header id="header" class="masthead">
		<div class="contain-to-grid">
			<nav class="top-bar" data-topbar="" role="navigation" aria-hidden="true">
				<ul class="title-area">
				</ul>

				<section class="top-bar-section">
					<ul class="right">
						<li class="has-form">
							<div class="row collapse">
								<div class="large-2 small-9 columns hide-for-small">
									<div class="weather">
									</div>
								</div>
							</div>
						</li>
						<li class="has-form">
							<div class="row collapse">
								<div class="large-2 small-2 columns">
									<a href="http://chicago.suntimes.com/subscribe" class="subscribe-link">Subscribe</a>
								</div>
							</div>
						</li>
					</ul>
					<ul class="left">
						<li class="has-form">
							<div class="row-collapse search">
								<div class="columns small-1 ">
								</div>
							</div>
						</li>
						<li class="has-form">
							<div class="row-collapse">
								<div class="columns small-1 burger-wrapper-no-fries">
								</div>
							</div>
						</li>
						<li class="has-form">
							<div class="row-collapse">
								<div class="columns small-12 show-for-small-only small-logo">
									<a href="http://chicago.suntimes.com/">
										<img src="https://s0.wp.com/wp-content/themes/vip/chicagosuntimes/cst-amp-logo.svg" alt="Chicago Sun-Times logo" height="32" width="167">
									</a>
								</div>
								<div class="columns small-12 show-for-small-device-landscape small-logo">
									<a href="http://chicago.suntimes.com/">
										<img src="https://s0.wp.com/wp-content/themes/vip/chicagosuntimes/cst-amp-logo.svg" alt="Chicago Sun-Times logo" height="32" width="167">
									</a>
								</div>
								<div class="columns small-12 show-for-large-up">
									<div class="masthead-sections columns small-12 show-for-medium-up show-for-landscape"><div class="homepage-nav-holder columns"><ul id="menu-homepage-left" class="homepage"><li id="menu-item-579" class="news-menu menu-item menu-item-type-taxonomy menu-item-object-cst_section menu-item-has-children menu-item-579"><a href="http://chicago.suntimes.com/section/news/">Chicago News</a></li>
												<li id="menu-item-581" class="sports-menu menu-item menu-item-type-taxonomy menu-item-object-cst_section menu-item-has-children menu-item-581"><a href="http://chicago.suntimes.com/section/sports/">Sports</a></li>
												<li id="menu-item-599" class="politics-menu menu-item menu-item-type-taxonomy menu-item-object-cst_section menu-item-has-children menu-item-599"><a href="http://chicago.suntimes.com/section/politics/">Politics</a></li>
												<li id="menu-item-640" class="entertainment-menu menu-item menu-item-type-taxonomy menu-item-object-cst_section menu-item-has-children menu-item-640"><a href="http://chicago.suntimes.com/section/entertainment/">Entertainment</a></li>
												<li id="menu-item-607" class="columnists-menu menu-item menu-item-type-taxonomy menu-item-object-cst_section menu-item-has-children menu-item-607"><a href="http://chicago.suntimes.com/section/columnists/">Columnists</a></li>
												<li id="menu-item-613" class="opinion-menu menu-item menu-item-type-taxonomy menu-item-object-cst_section menu-item-has-children menu-item-613"><a href="http://chicago.suntimes.com/section/opinion/">Opinion</a></li>
												<li id="menu-item-616" class="lifestyles-menu menu-item menu-item-type-taxonomy menu-item-object-cst_section menu-item-has-children menu-item-616"><a href="http://chicago.suntimes.com/section/lifestyles/">Lifestyles</a></li>
												<li id="menu-item-373361" class="menu-item menu-item-type-taxonomy menu-item-object-cst_section menu-item-has-children menu-item-373361"><a href="http://chicago.suntimes.com/section/autos/">Autos</a></li>
												<li id="menu-item-165639" class="obit-external menu-item menu-item-type-taxonomy menu-item-object-cst_section menu-item-165639"><a href="http://chicago.suntimes.com/section/obituaries/">Local Obits</a></li>
												<li id="menu-item-622" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-622"><a href="http://marketplace.suntimes.com/">Classifieds</a></li>
												<li id="menu-item-623" class="jobs-navigation-links menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-623"><a href="http://career-advice.local-jobs.monster.com/?wt.mc_n=hjnpcaradvcovlet&amp;ch=NEWSCHISUN">Jobs</a></li>
												<li id="menu-item-624" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-624"><a href="http://suntimes.com/subscribe/">Subscribe</a></li>
												<li id="menu-item-625" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-home menu-item-has-children menu-item-625"><a href="http://chicago.suntimes.com">More</a></li>
											</ul></div></div>
								</div>
							</div>
						</li>
					</ul>
				</section>
			</nav>
		</div>
	</header>