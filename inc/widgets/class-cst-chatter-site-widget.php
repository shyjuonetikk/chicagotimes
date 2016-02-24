<?php

class CST_Chatter_Site_Widget extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'CST_Chatter_Site_Widget',
            esc_html__( 'CST Chatter Site Wire', 'chicagosuntimes' ),
            array(
                'description' => esc_html__( 'Displays recent Chatter Site posts.', 'chicagosuntimes' ),
            )
        );

    }

    public function widget( $args, $instance ) {
        $chatter_site = $instance['cst_chatter_site'];
        if( empty( $chatter_site ) ) {
            $feed_url = 'http://sportschatter.com/feed/?post_type=slideshow';
        } elseif( $chatter_site == 'sports' ) {
            $feed_url = 'http://sportschatter.com/feed/?post_type=slideshow';
        } else {
            $feed_url = 'http://politicschatter.com/feed/?post_type=slideshow';
        }

        echo $args['before_widget'];

        echo $args['before_title'] . esc_html( $chatter_site . ' chatter' ) . $args['after_title'];

        ?>
        <ul class="widget-recent-posts">
            <?php $chatter_items = CST()->frontend->cst_homepage_fetch_feed( $feed_url, 5 );
                  if( count( $chatter_items ) > 0 ) :
                      foreach( $chatter_items as $chatter_item ) { ?>
            <li>
                <a href="<?php echo esc_url( $chatter_item->get_permalink() ); ?>">
                    <span class='section'><?php echo esc_html( $chatter_site ); ?></span><span class='chatter'><?php echo esc_html( 'CHATTER' ); ?></span>
                    <span class='time'><?php echo human_time_diff( strtotime( $chatter_item->get_date('j F Y g:i a') ) ); ?></span><br />
                    <span class='title'><?php echo $chatter_item->get_title(); ?></span>
                </a>
            </li>
            <?php }; endif; ?>
        </ul>
        <?php
        echo $args['after_widget'];
    
    }

    public function form( $instance ) {
        $instance = $instance;
        if( ! empty( $instance['cst_chatter_site'] ) ) :
            $chatter_site = $instance['cst_chatter_site'];
        else :
            $chatter_site = '';
        endif;
    ?>
        <p>
            <strong><?php esc_html_e( 'Chatter Site to Display', 'chicagosuntimes' ); ?></strong>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('cst_chatter_site'); ?>">
            <?php esc_html_e( 'PoliticsChatter', 'chicagosuntimes' ); ?>
            <input class="" id="<?php echo $this->get_field_id('cst_politics_chatter'); ?>" name="<?php echo $this->get_field_name('cst_chatter_site'); ?>" type="radio" value="<?php esc_html_e( 'politics' ); ?>" <?php if( $chatter_site === 'politics'){ echo 'checked="checked"'; } ?> />
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('cst_chatter_site'); ?>">
                <?php esc_html_e( 'SportsChatter', 'chicagosuntimes' ); ?>
                <input class="" id="<?php echo $this->get_field_id('cst_sports_chatter'); ?>" name="<?php echo $this->get_field_name('cst_chatter_site'); ?>" type="radio" value="<?php esc_html_e( 'sports' ); ?>" <?php if( $chatter_site === 'sports') { echo 'checked="checked"'; } ?> />
            </label>
        </p>
        <hr/>
    <?php
    }

    public function update( $new_instance, $old_instance ) {

        $instance = $old_instance;
        $instance['cst_chatter_site'] = sanitize_text_field( $new_instance['cst_chatter_site'] );
        return $instance;

    }

}