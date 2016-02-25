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
            $feed_url = 'http://sportschatter.com/api/2.0/get_posts/';
        } elseif( $chatter_site == 'sports' ) {
            $feed_url = 'http://sportschatter.com/api/2.0/get_posts/';
        } elseif( $chatter_site == 'celeb' ) {
            $feed_url = 'http://celebchatter.com/api/2.0/get_posts/';
        } else {
            $feed_url = 'http://politicschatter.com/api/2.0/get_posts/';
        }

        echo $args['before_widget'];

        echo $args['before_title'] . esc_html( $chatter_site . ' chatter' ) . $args['after_title'];

        ?>
        <ul class="widget-recent-posts">
            <?php $chatter_item = CST()->frontend->cst_get_chatter_site( $feed_url ); 
                    $thumbnail = $chatter_item->posts['0']->thumbnail->url;
                    $thumbnail = str_replace( 'https://' . $chatter_site . 'chatter.mas.wordpress-prod-wp.aggrego.com' , 'http://wp-ag.s3.amazonaws.com', $thumbnail );
            ?>
            <li>
                <a href="<?php echo esc_url( $chatter_item->posts['0']->url ); ?>" target="_blank">
                    <img src="<?php echo esc_html( $thumbnail ); ?>" style="width:290px;height:200px;" /><br />
                    <span class='title'><?php echo $chatter_item->posts['0']->title; ?></span>
                </a>
            </li>
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
        <p>
            <label for="<?php echo $this->get_field_id('cst_chatter_site'); ?>">
                <?php esc_html_e( 'CelebChatter', 'chicagosuntimes' ); ?>
                <input class="" id="<?php echo $this->get_field_id('cst_celeb_chatter'); ?>" name="<?php echo $this->get_field_name('cst_chatter_site'); ?>" type="radio" value="<?php esc_html_e( 'celeb' ); ?>" <?php if( $chatter_site === 'celeb') { echo 'checked="checked"'; } ?> />
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