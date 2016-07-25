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
            $feed_url = 'http://sportschatter.com/wp-json/wp/v2/posts/';
            $image_url = 'http://sportschatter.com/wp-json/wp/v2/media';
            $base_url = 'http://www.sportschatter.com/sports-talk/slideshow';
        } elseif( $chatter_site == 'sports' ) {
            $feed_url = 'http://sportschatter.com/wp-json/wp/v2/posts/';
            $image_url = 'http://sportschatter.com/wp-json/wp/v2/media';
            $base_url = 'http://www.sportschatter.com/sports-talk/slideshow';
        } elseif( $chatter_site == 'celeb' ) {
            $feed_url = 'http://celebchatter.com/wp-json/wp/v2/posts/';
            $image_url = 'http://celebchatter.com/wp-json/wp/v2/media';
            $base_url = 'http://www.celebchatter.com/celeb/slideshow';
        } else {
            $feed_url = 'http://politicschatter.com/wp-json/wp/v2/posts/';
            $image_url = 'http://politicschatter.com/wp-json/wp/v2/media';
            $base_url = 'http://www.politicschatter.com/politics-talk/slideshow';
        }

        echo $args['before_widget'];

        echo $args['before_title'] . esc_html( $chatter_site . ' chatter' ) . $args['after_title'];

            $chatter_item = CST()->frontend->cst_get_chatter_site( $feed_url ); 
            $chatter_item_slug = $chatter_item['0']->slug;
            $featured_media_id = $chatter_item['0']->featured_media;
            if( $featured_media_id ) :
                $featured_media = CST()->frontend->cst_get_chatter_site( $image_url . '/' . $featured_media_id );
                $featured_media_url = $featured_media->media_details->sizes->medium->source_url;
        ?>
                <ul class="widget-recent-posts">
                    <li>
                        <a href="<?php echo esc_url( $base_url . '/' . $chatter_item_slug ); ?>" target="_blank">
                            <img src="<?php echo esc_html( $featured_media_url ); ?>" style="width:290px;height:200px;" /><br />
                            <span class='title'><?php echo $chatter_item['0']->title->rendered; ?></span>
                        </a>
                    </li>
                </ul>
        <?php
            endif;
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