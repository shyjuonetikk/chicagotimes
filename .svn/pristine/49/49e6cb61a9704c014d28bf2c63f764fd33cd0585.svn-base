<div class="row">
    <div class="large-12 columns dfp-btf-leaderboard">
        <?php get_template_part( 'parts/dfp/homepage/dfp-atf-leaderboard' ); ?>
    </div>
</div>
<hr/>
<footer>
<div class="row">
    <div class="large-3 columns">
        <p class="copyright"><?php esc_html_e( 'Copyright &copy; 2005-2016 Chicago Sun-Times', 'chicagosuntimes') ; ?></p>
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
<script type="text/javascript" async src="http://launch.newsinc.com/js/embed.js" id="_nw2e-js"></script>