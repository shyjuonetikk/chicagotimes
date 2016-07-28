<?php

class CST_Search_Widget extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'cst_search',
            esc_html__( 'CST Search', 'chicagosuntimes' ),
            array(
                'description' => esc_html__( 'Display CST Search.', 'chicagosuntimes' ),
            )
        );

    }

    public function widget( $args, $instance ) {
    ?>
    <div class="row">
        <div class="large-12 medium-6 small-12 search-widget">
            <form class="search-wrap" autocomplete="off" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <input id="search-input" placeholder="<?php esc_attr_e( 'search...', 'chicagosuntimes' ); ?>" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" />
        <?php if( is_front_page() ) : ?>
                <a href="#" id="search-button" class="search-in">
                    <i class="fa fa-search"></i>
                </a>
        <?php else : ?>
                <button type="submit" id="search-button" class="search-in">
                    <i class="fa fa-search"></i>
                </button>
        <?php endif; ?>
            </form>
        </div>
    </div>
    <?php
    }

    public function form( $instance ) {

    }

    public function update( $new_instance, $old_instance ) {

    }

}