
<hr/>
<footer>
<div class="row">
    <div class="large-3 columns">
        <p class="copyright"><?php echo esc_html( sprintf( 'Copyright &copy; 2005-%s Chicago Sun-Times', date( 'Y' ) ) ); ?></p>
    </div>
    <div class="large-9 columns">
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
