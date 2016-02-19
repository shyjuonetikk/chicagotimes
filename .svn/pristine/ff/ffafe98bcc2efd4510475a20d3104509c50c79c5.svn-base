<?php global $homepage_main_well_posts; ?>
<div class="row">
    <div class="large-12 content-wrapper">
        <div class="large-8 medium-12 columns">
            <section id="main-well">
                <div class="row">
                    <div class="large-12 medium-12 columns main-article-container">
                        <?php 
                            $obj = \CST\Objects\Post::get_by_post_id( $homepage_main_well_posts[2]->ID );
                            $primary_section = $obj->get_primary_parent_section();
                        ?>
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
                                <span>BY <?php echo esc_html( get_the_author_meta( 'display_name', $homepage_main_well_posts[2]->post_author ) ); ?></span>
                            </div>
                        </a>
                    </div>
                    <div class="large-12 medium-12 columns left-main-well">
                        <div class="large-6 medium-6 columns">
                            <div class="article-container">
                                <?php 
                                    $obj = \CST\Objects\Post::get_by_post_id( $homepage_main_well_posts[1]->ID );
                                    $primary_section = $obj->get_primary_parent_section();
                                ?>
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
                                        <span>BY <?php echo esc_html( get_the_author_meta( 'display_name', $homepage_main_well_posts[1]->post_author ) ); ?></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="large-6 medium-6 columns">
                            <div class="article-container">
                                <?php 
                                    $obj = \CST\Objects\Post::get_by_post_id( $homepage_main_well_posts[0]->ID );
                                    $primary_section = $obj->get_primary_parent_section();
                                ?>
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
                                        <span>BY <?php echo esc_html( get_the_author_meta( 'display_name', $homepage_main_well_posts[0]->post_author ) ); ?></span>
                                    </div>
                                </a>
                            </div>
                        </div>
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