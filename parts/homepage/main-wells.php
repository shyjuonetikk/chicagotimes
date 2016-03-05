<?php global $homepage_main_well_posts; ?>
<div class="row">
    <div class="large-12 content-wrapper">
    <h2 class="mobile-top-news show-for-small-only"><?php echo esc_html_e( 'Top News' ); ?></h2>
        <div class="large-8 medium-12 columns">
            <section id="main-well">
                <div class="row">
            <?php 
                $obj = \CST\Objects\Post::get_by_post_id( $homepage_main_well_posts[2]->ID );
                if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
                    $primary_section = $obj->get_primary_parent_section();
                    if( $byline = $obj->get_byline() ) {
                        $author = $byline;
                    } else {
                        $author = get_the_author_meta( 'display_name', $homepage_main_well_posts[2]->post_author );
                    }
            ?>
                    <div class="large-12 medium-12 columns main-article-container">
                        <a href="<?php echo esc_url( $obj->the_permalink() ); ?>">
                            <?php
                                if ( 'image' == $obj->get_featured_media_type() ) {
                                    $featured_image_id = $obj->get_featured_image_id();
                                    if ( $attachment = \CST\Objects\Attachment::get_by_post_id( $featured_image_id ) ) {
                                        echo $attachment->get_html( 'chiwire-header-large' );
                                    }
                                }
                            ?>
                            <div class="article-title <?php echo esc_html( strtolower( $primary_section->name ) ); ?>-cat">
                                <h3><?php echo esc_html_e( $obj->the_title(), 'chicagosuntimes' ); ?></h3>
                                <p><?php echo esc_html_e ($obj->the_excerpt(), 'chicagosuntimes' ); ?></p>
                                <span>By <?php echo esc_html( $author ); ?></span>
                            </div>
                        </a>
                    </div>
                    <?php
                }
            ?>
                    <div class="large-12 medium-12 columns left-main-well">
                <?php 
                    $obj = \CST\Objects\Post::get_by_post_id( $homepage_main_well_posts[1]->ID );
                    if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
                        $primary_section = $obj->get_primary_parent_section();
                        if( $byline = $obj->get_byline() ) {
                            $author = $byline;
                        } else {
                            $author = get_the_author_meta( 'display_name', $homepage_main_well_posts[1]->post_author );
                        }
                ?>
                        <div class="large-6 medium-6 columns">
                            <div class="article-container">
                                <a href="<?php echo esc_url( $obj->the_permalink() ); ?>">
                                    <?php
                                        if ( 'image' == $obj->get_featured_media_type() ) {
                                            $featured_image_id = $obj->get_featured_image_id();
                                            if ( $attachment = \CST\Objects\Attachment::get_by_post_id( $featured_image_id ) ) {
                                                echo $attachment->get_html( 'chiwire-header-large' );
                                            }
                                        }
                                    ?>
                                    <div class="article-title <?php echo esc_html( strtolower( $primary_section->name ) ); ?>-cat">
                                        <h3><?php echo esc_html_e( $obj->the_title(), 'chicagosuntimes' ); ?></h3>
                                        <p><?php echo esc_html_e ($obj->the_excerpt(), 'chicagosuntimes' ); ?></p>
                                        <span>By <?php echo esc_html( $author ); ?></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php
                    }
                ?>
                <?php 
                    $obj = \CST\Objects\Post::get_by_post_id( $homepage_main_well_posts[0]->ID );
                    if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
                        $primary_section = $obj->get_primary_parent_section();
                        if( $byline = $obj->get_byline() ) {
                            $author = $byline;
                        } else {
                            $author = get_the_author_meta( 'display_name', $homepage_main_well_posts[0]->post_author );
                        }
                ?>
                        <div class="large-6 medium-6 columns">
                            <div class="article-container">
                                <a href="<?php echo esc_url( $obj->the_permalink() ); ?>">
                                    <?php
                                        if ( 'image' == $obj->get_featured_media_type() ) {
                                            $featured_image_id = $obj->get_featured_image_id();
                                            if ( $attachment = \CST\Objects\Attachment::get_by_post_id( $featured_image_id ) ) {
                                                echo $attachment->get_html( 'chiwire-header-large' );
                                            }
                                        }
                                    ?>
                                    <div class="article-title <?php echo esc_html( strtolower( $primary_section->name ) ); ?>-cat">
                                        <h3><?php echo esc_html_e( $obj->the_title(), 'chicagosuntimes' ); ?></h3>
                                        <p><?php echo esc_html_e ($obj->the_excerpt(), 'chicagosuntimes' ); ?></p>
                                        <span>By <?php echo esc_html( $author ); ?></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php
                    }
                ?>
                    </div>
                </div>
            </section>
        </div>
        <div class="large-4 columns">
            <?php get_template_part( 'parts/homepage/right-sidebar' ); ?>
        </div>
    </div>
</div>
<?php get_template_part( 'parts/dfp/homepage/dfp-sbb' ); ?>