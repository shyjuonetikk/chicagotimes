<?php global $homepage_election_well_posts; ?>
<div class="row">
    <div class="large-12 content-wrapper">
        <div class="large-8 columns">
            <section id="secondary-wells">
                <div class="row">
                    <div class="large-12 medium-12">
                <?php
                    $obj = \CST\Objects\Post::get_by_post_id( $homepage_election_well_posts[0]->ID );
                    if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
                        $primary_section = $obj->get_primary_parent_section();
                        if( $byline = $obj->get_byline() ) {
                            $author = $byline;
                        } else {
                            $author = get_the_author_meta( 'display_name', $homepage_election_well_posts[0]->post_author );
                        }
                ?>
                        <div class="large-6 medium-6 small-12 columns">
                            <div class="article-container">
                                <a href="<?php echo esc_url( $obj->the_permalink() ); ?>">
                                    <?php
                                        if ( $featured_image_id = $obj->get_featured_image_id() ) {
                                            if ( $attachment = \CST\Objects\Attachment::get_by_post_id( $featured_image_id ) ) {
                                                echo $attachment->get_html( 'chiwire-header-small' );
                                            }
                                        }
                                    ?>
                                    <div class="article-title <?php echo esc_html( strtolower( $primary_section->name ) ); ?>-cat">
                                        <h3><?php echo esc_html_e( $obj->the_title(), 'chicagosuntimes' ); ?></h3>
                                        <p><?php echo esc_html_e( $obj->the_excerpt(), 'chicagosuntimes' ); ?></p>
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
                <hr/>
                <div class="row">
                    <div class="large-12 medium-12">
                <?php 
                    $obj = \CST\Objects\Post::get_by_post_id( $homepage_election_well_posts[1]->ID );
                    if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
                        $primary_section = $obj->get_primary_parent_section();
                        if( $byline = $obj->get_byline() ) {
                            $author = $byline;
                        } else {
                            $author = get_the_author_meta( 'display_name', $homepage_election_well_posts[1]->post_author );
                        }
                ?>
                        <div class="large-6 medium-6 small-12 columns">
                            <div class="article-container">
                                <a href="<?php echo esc_url( $obj->the_permalink() ); ?>">
                                    <?php
                                        if ( $featured_image_id = $obj->get_featured_image_id() ) {
                                            if ( $attachment = \CST\Objects\Attachment::get_by_post_id( $featured_image_id ) ) {
                                                echo $attachment->get_html( 'chiwire-header-small' );
                                            }
                                        }
                                    ?>
                                    <div class="article-title <?php echo esc_html( strtolower( $primary_section->name ) ); ?>-cat">
                                        <h3><?php echo esc_html_e( $obj->the_title(), 'chicagosuntimes' ); ?></h3>
                                        <p><?php echo esc_html_e( $obj->the_excerpt(), 'chicagosuntimes' ); ?></p>
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
                <hr/>
                <div class="row">
                    <div class="large-12 medium-12">
                <?php 
                    $obj = \CST\Objects\Post::get_by_post_id( $homepage_election_well_posts[2]->ID );
                    if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
                        $primary_section = $obj->get_primary_parent_section();
                        if( $byline = $obj->get_byline() ) {
                            $author = $byline;
                        } else {
                            $author = get_the_author_meta( 'display_name', $homepage_election_well_posts[2]->post_author );
                        }
                ?>
                        <div class="large-6 medium-6 small-12 columns">
                            <div class="article-container">
                                <a href="<?php echo esc_url( $obj->the_permalink() ); ?>">
                                    <?php
                                        if ( $featured_image_id = $obj->get_featured_image_id() ) {
                                            if ( $attachment = \CST\Objects\Attachment::get_by_post_id( $featured_image_id ) ) {
                                                echo $attachment->get_html( 'chiwire-header-small' );
                                            }
                                        }
                                    ?>
                                    <div class="article-title <?php echo esc_html( strtolower( $primary_section->name ) ); ?>-cat">
                                        <h3><?php echo esc_html_e( $obj->the_title(), 'chicagosuntimes' ); ?></h3>
                                        <p><?php echo esc_html_e( $obj->the_excerpt(), 'chicagosuntimes' ); ?></p>
                                        <span>By <?php echo esc_html( $author ); ?></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php
                    }
                ?>
                <?php 
                    $obj = \CST\Objects\Post::get_by_post_id( $homepage_election_well_posts[3]->ID );
                    if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
                        $primary_section = $obj->get_primary_parent_section();
                        if( $byline = $obj->get_byline() ) {
                            $author = $byline;
                        } else {
                            $author = get_the_author_meta( 'display_name', $homepage_election_well_posts[3]->post_author );
                        }
                ?>
                        <div class="large-6 medium-6 small-12 columns">
                            <div class="article-container">
                                <a href="<?php echo esc_url( $obj->the_permalink() ); ?>">
                                    <?php
                                        if ( $featured_image_id = $obj->get_featured_image_id() ) {
                                            if ( $attachment = \CST\Objects\Attachment::get_by_post_id( $featured_image_id ) ) {
                                                echo $attachment->get_html( 'chiwire-header-small' );
                                            }
                                        }
                                    ?>
                                    <div class="article-title <?php echo esc_html( strtolower( $primary_section->name ) ); ?>-cat">
                                        <h3><?php echo esc_html_e( $obj->the_title(), 'chicagosuntimes' ); ?></h3>
                                        <p><?php echo esc_html_e( $obj->the_excerpt(), 'chicagosuntimes' ); ?></p>
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