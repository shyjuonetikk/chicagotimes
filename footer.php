<?php if ( !is_front_page() ) {
	get_template_part( 'parts/page-footer' );
} ?>
</div>

<?php wp_footer(); ?>
<?php 
    if( is_singular() ) :
        get_template_part( 'parts/vendors/google-survey-footer' );
        get_template_part( 'parts/vendors/yieldmo-footer' );
        get_template_part( 'parts/vendors/aggrego-chatter-footer' );
    endif;
?>
</div>
<?php get_template_part( 'parts/analytics/chartbeat-footer' ); ?>
<footer>
	<div class="row">
		<div class="small-12 large-3 columns">
			<p class="copyright"><?php echo sprintf( 'Copyright &copy; 2005 - %s Chicago Sun-Times', date( 'Y' ) ); ?></p>
		</div>
		<div class="small-12 large-9 columns">
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
</body>
</html>
