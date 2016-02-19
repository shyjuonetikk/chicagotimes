<?php global $homepage_secondary_well_posts; ?>
<div class="row">
    <div class="large-12 content-wrapper">
        <div class="large-8 columns">
            <section id="secondary-wells">
                <div class="row">
                    <div class="large-12 medium-12">
                        <div class="large-6 medium-6 small-12 columns dfp-cube">
                            <?php get_template_part( 'parts/dfp/homepage/dfp-rr-cube-2' ); ?>
                        </div>
                        <div class="large-6 medium-6 small-12 columns">
                            <div class="article-container">
                                <?php 
                                    $obj = \CST\Objects\Post::get_by_post_id( $homepage_secondary_well_posts[0]->ID );
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
                                        <p><?php echo esc_html_e( $obj->the_excerpt(), 'chicagosuntimes' ); ?></p>
                                        <span>BY <?php echo esc_html( get_the_author_meta( 'display_name', $homepage_secondary_well_posts[0]->post_author ) ); ?></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="large-12 medium-12">
                        <div class="large-6 medium-6 small-12 columns">
                            <div class="article-container">
                                <?php 
                                    $obj = \CST\Objects\Post::get_by_post_id( $homepage_secondary_well_posts[1]->ID );
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
                                        <p><?php echo esc_html_e( $obj->the_excerpt(), 'chicagosuntimes' ); ?></p>
                                        <span>BY <?php echo esc_html( get_the_author_meta( 'display_name', $homepage_secondary_well_posts[1]->post_author ) ); ?></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="large-6 medium-6 small-12 columns dfp-cube">
                            <?php get_template_part( 'parts/dfp/homepage/dfp-rr-cube-3' ); ?>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="large-12 medium-12">
                        <div class="large-6 medium-6 small-12 columns">
                            <div class="article-container">
                                <?php 
                                    $obj = \CST\Objects\Post::get_by_post_id( $homepage_secondary_well_posts[2]->ID );
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
                                        <p><?php echo esc_html_e( $obj->the_excerpt(), 'chicagosuntimes' ); ?></p>
                                        <span>BY <?php echo esc_html( get_the_author_meta( 'display_name', $homepage_secondary_well_posts[2]->post_author ) ); ?></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="large-6 medium-6 small-12 columns">
                            <div class="article-container">
                                <?php 
                                    $obj = \CST\Objects\Post::get_by_post_id( $homepage_secondary_well_posts[3]->ID );
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
                                        <p><?php echo esc_html_e( $obj->the_excerpt(), 'chicagosuntimes' ); ?></p>
                                        <span>BY <?php echo esc_html( get_the_author_meta( 'display_name', $homepage_secondary_well_posts[3]->post_author ) ); ?></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>