<?php global $homepage_more_well_posts; ?>
        <hr/>
        <h2 class="section-title"><span><?php esc_html_e( 'More Top Stories', 'chicagosuntimes' ); ?></span></h2>
        <hr/>
        <section id="more-stories-wells">
            <hr/>
            <div class="row">
                <?php 
                    $obj = \CST\Objects\Post::get_by_post_id( $homepage_more_well_posts[0]->ID );
                    $primary_section = $obj->get_primary_parent_section();
                ?>
                <div class="large-4 medium-4 small-12 columns article-image <?php echo esc_html( strtolower( $primary_section->name ) ); ?>-triangle">
                    <a href="<?php echo esc_url( $obj->the_permalink() ); ?>">
                        <?php
                            if ( 'image' == $obj->get_featured_media_type() ) {
                                $featured_image_id = $obj->get_featured_image_id();
                                if ( $attachment = \CST\Objects\Attachment::get_by_post_id( $featured_image_id ) ) {
                                    echo $attachment->get_html( 'homepage-columns' );
                                }
                            }
                        ?>
                    </a>
                </div>
                <div class="large-8 medium-8 small-12 columns">
                    <a href="<?php echo esc_url( $obj->the_permalink() ); ?>">
                        <h3><?php echo esc_html_e( $obj->the_title(), 'chicagosuntimes' ); ?></h3>
                    </a>
                    <p><?php echo esc_html_e( $obj->the_excerpt(), 'chicagosuntimes' ); ?></p>
                    <span class="author">By <?php echo esc_html( get_the_author_meta( 'display_name', $homepage_more_well_posts[0]->post_author ) ); ?></span>
                </div>
            </div>
            <hr/>
            <div class="row">
               <?php 
                    $obj = \CST\Objects\Post::get_by_post_id( $homepage_more_well_posts[1]->ID );
                    $primary_section = $obj->get_primary_parent_section();
                ?>
                <div class="large-4 medium-4 small-12 columns article-image <?php echo esc_html( strtolower( $primary_section->name ) ); ?>-triangle">
                    <a href="<?php echo esc_url( $obj->the_permalink() ); ?>">
                        <?php
                            if ( 'image' == $obj->get_featured_media_type() ) {
                                $featured_image_id = $obj->get_featured_image_id();
                                if ( $attachment = \CST\Objects\Attachment::get_by_post_id( $featured_image_id ) ) {
                                    echo $attachment->get_html( 'homepage-columns' );
                                }
                            }
                        ?>
                    </a>
                </div>
                <div class="large-8 medium-8 small-12 columns">
                    <a href="<?php echo esc_url( $obj->the_permalink() ); ?>">
                        <h3><?php echo esc_html_e( $obj->the_title(), 'chicagosuntimes' ); ?></h3>
                    </a>
                    <p><?php echo esc_html_e( $obj->the_excerpt(), 'chicagosuntimes' ); ?></p>
                    <span class="author">By <?php echo esc_html( get_the_author_meta( 'display_name', $homepage_more_well_posts[1]->post_author ) ); ?></span>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="large-12 columns dfp-btf-leaderboard">
                    <?php get_template_part( 'parts/dfp/homepage/dfp-btf-leaderboard' ); ?>
                </div>
            </div>
            <hr/>
            <div class="row">
                <?php 
                    $obj = \CST\Objects\Post::get_by_post_id( $homepage_more_well_posts[2]->ID );
                    $primary_section = $obj->get_primary_parent_section();
                ?>
                <div class="large-4 medium-4 small-12 columns article-image <?php echo esc_html( strtolower( $primary_section->name ) ); ?>-triangle">
                    <a href="<?php echo esc_url( $obj->the_permalink() ); ?>">
                        <?php
                            if ( 'image' == $obj->get_featured_media_type() ) {
                                $featured_image_id = $obj->get_featured_image_id();
                                if ( $attachment = \CST\Objects\Attachment::get_by_post_id( $featured_image_id ) ) {
                                    echo $attachment->get_html( 'homepage-columns' );
                                }
                            }
                        ?>
                    </a>
                </div>
                <div class="large-8 medium-8 small-12 columns">
                    <a href="<?php echo esc_url( $obj->the_permalink() ); ?>">
                        <h3><?php echo esc_html_e( $obj->the_title(), 'chicagosuntimes' ); ?></h3>
                    </a>
                    <p><?php echo esc_html_e( $obj->the_excerpt(), 'chicagosuntimes' ); ?></p>
                    <span class="author">By <?php echo esc_html( get_the_author_meta( 'display_name', $homepage_more_well_posts[2]->post_author ) ); ?></span>
                </div>
            </div>
            <hr/>
            <div class="row">
                <?php 
                    $obj = \CST\Objects\Post::get_by_post_id( $homepage_more_well_posts[3]->ID );
                    $primary_section = $obj->get_primary_parent_section();
                ?>
                <div class="large-4 medium-4 small-12 columns article-image <?php echo esc_html( strtolower( $primary_section->name ) ); ?>-triangle">
                    <a href="<?php echo esc_url( $obj->the_permalink() ); ?>">
                        <?php
                            if ( 'image' == $obj->get_featured_media_type() ) {
                                $featured_image_id = $obj->get_featured_image_id();
                                if ( $attachment = \CST\Objects\Attachment::get_by_post_id( $featured_image_id ) ) {
                                    echo $attachment->get_html( 'homepage-columns' );
                                }
                            }
                        ?>
                    </a>
                </div>
                <div class="large-8 medium-8 small-12 columns">
                    <a href="<?php echo esc_url( $obj->the_permalink() ); ?>">
                        <h3><?php echo esc_html_e( $obj->the_title(), 'chicagosuntimes' ); ?></h3>
                    </a>
                    <p><?php echo esc_html_e( $obj->the_excerpt(), 'chicagosuntimes' ); ?></p>
                    <span class="author">By <?php echo esc_html( get_the_author_meta( 'display_name', $homepage_more_well_posts[3]->post_author ) ); ?></span>
                </div>
            </div>
        </section>
    </div>
        <div class="large-4 columns">
            <?php if( dynamic_sidebar( 'homepage_sidebar_two' ) ) { } ?>
            <?php if( dynamic_sidebar( 'homepage_sidebar_three' ) ) { } ?>
            <div class="row">
                <div class="medium-12 columns dfp-cube">
                    <?php get_template_part( 'parts/dfp/homepage/dfp-rr-cube-3' ); ?>
                </div>
            </div>
        </div>
    </div>
</div>