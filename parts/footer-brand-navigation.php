<footer>
	<hr>
<div class="row footer-upper">
	<div class="small-12 medium-3 columns">
		<a id="suntimes-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php get_template_part( 'parts/images/company-logo'); ?></a>
		<p class="copyright"><?php echo sprintf( 'Copyright &copy; 2005 - %s Chicago Sun-Times', date( 'Y' ) ); ?></p>
	</div>
	<div class="small-12 medium-7 columns">
		<ul>
			<li><a href="/about-us">About us</a></li>
			<li><a href="/contact-us">Contact us</a></li>
			<li><a href="/about-our-ads">About our ads</a></li>
		</ul>
		<ul>
			<li><a href="/privacy-policy">Privacy Policy</a></li>
			<li><a href="/terms-of-use">Terms of use</a></li>
			<li><a href="http://payments.suntimes.com" target="_blank">Order Back Issues</a>&nbsp;<i class="fa fa-external-link" aria-hidden="true"></i></li>
		</ul>
	</div>
	<div class="small-12 medium-2 columns">
		<?php echo CST()->get_template_part( 'social-links'); ?>
	</div>
</div>
</footer>