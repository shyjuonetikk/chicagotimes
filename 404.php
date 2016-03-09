<?php get_header(); ?>
    
    <section class="row grey-background" style="width:100%;max-width:none;">
        <div class="404content columns large-12 text-center large-centered">

            <h1><?php esc_html_e( 'Page Not Found', 'chicagosuntimes' ); ?></h1>

            <p>
                <?php esc_html_e( "We're sorry, but we seem to have lost this page.", 'chicagosuntimes' ); ?>
            </p>

            <form class="search-wrap" autocomplete="off" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <input id="search-input" placeholder="<?php esc_attr_e( 'search...', 'chicagosuntimes' ); ?>" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" />
                <a href="#" id="search-button" class="search-in">
                    <i class="fa fa-search"></i>
                </a>
            </form>

        </div>
    </section>

<?php get_footer(); ?>