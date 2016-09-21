<!-- top logos -->
<header id="header">
	<div class="contain-to-grid sticky">
		<nav class="top-bar" data-topbar>
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


			<div class="top-bar-section">
				<div class="logo-wrapper large-logo">
					<div class="logo">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/cst-white-logo.png' ); ?>" alt='Chicago Sun-Times logo'>
						<div class="masthead-date"><?php echo esc_html( date( 'l, F j, Y' ) ); ?></div>
					</div>

				</div>

				<?php
				wp_nav_menu( array(
					'theme_location' => 'homepage-menu',
					'fallback_cb' => false,
					'container' => false,
					'depth' => 2,
					'items_wrap' => '<ul id="%1$s" class="">%3$s</ul>',
					'walker' => new GC_walker_nav_menu(),
					)
				);
				?>
			</div>
		</nav>
	</div>
</header>