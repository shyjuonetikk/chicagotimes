<footer>

<hr>
<div class="row footer-upper">
	<div class="small-12 medium-3 columns">
		<a id="suntimes-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php get_template_part( 'parts/images/company-logo'); ?></a>
	</div>
	<div class="small-12 medium-8 columns">
		<ul>
			<li><a href="/subscribe">Subscribe</a></li>
			<li><a href="/newsletters">Newsletters</a></li>
			<li><a href="http://payments.suntimes.com">Order Back Issues</a></li>
		</ul>
	</div>
	<div class="small-12 medium-1 columns">
		<?php echo CST()->get_template_part( 'social-links'); ?>
	</div>
</div>
<hr>
<div class="row footer-lower">
	<div class="small-12 columns">
		<?php
		wp_nav_menu( array(
				'theme_location' => 'homepage-footer-menu',
				'fallback_cb' => false,
				'container' => false,
				'depth' => 1,
				'items_wrap' => '<ul id="%1$s" class="">%3$s</ul>',
				'walker' => new GC_walker_nav_menu()
			)
		);
		?>
	</div>
</div>

</footer>