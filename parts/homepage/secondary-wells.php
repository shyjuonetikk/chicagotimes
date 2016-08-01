<?php global $homepage_secondary_well_posts; ?>
<div class="row">
    <div class="large-12 content-wrapper">
        <div class="large-8 columns secondary-well-container">
            <section id="secondary-wells">
                    <div class="large-12 medium-12 secondary-well-upper">
                        <div class="large-6 medium-6 small-12 columns dfp-cube">
                            <?php get_template_part( 'parts/dfp/homepage/dfp-rr-cube-2' ); ?>
                        </div>
                <?php
                    $obj = \CST\Objects\Post::get_by_post_id( $homepage_secondary_well_posts[0]->ID );
                    if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
                        $primary_section = $obj->get_primary_parent_section();
                        if( $byline = $obj->get_byline() ) {
                            $author = $byline;
                        } else {
                            $authors = $obj->get_authors();
                            $author_data = $authors[0];
                            $author = $author_data->get_display_name();
                        }
                ?>
                        <div class="large-6 medium-6 small-12 columns">
							<?php CST()->frontend->well_article_container_markup( $obj, $author, $primary_section ); ?>
                        </div>
                        <?php
                    }
                ?>
                    </div>
                <hr/>
                <div class="secondary-well-lower">
                    <div class="large-12 medium-12">
                <?php
                    $obj = \CST\Objects\Post::get_by_post_id( $homepage_secondary_well_posts[1]->ID );
                    if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
                        $primary_section = $obj->get_primary_parent_section();
                        if( $byline = $obj->get_byline() ) {
                            $author = $byline;
                        } else {
                            $authors = $obj->get_authors();
                            $author_data = $authors[0];
                            $author = $author_data->get_display_name();
                        }
                ?>
                        <div class="large-6 medium-6 small-12 columns">
							<?php CST()->frontend->well_article_container_markup( $obj, $author, $primary_section ); ?>
                        </div>
                        <?php
                    }
                ?>
                        <div class="large-6 medium-6 small-12 columns dfp-cube">
                            <?php get_template_part( 'parts/dfp/homepage/dfp-rr-cube-3' ); ?>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="secondary-well-bottom">
                    <div class="large-12 medium-12">
                <?php 
                    $obj = \CST\Objects\Post::get_by_post_id( $homepage_secondary_well_posts[2]->ID );
                    if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
                        $primary_section = $obj->get_primary_parent_section();
                        if( $byline = $obj->get_byline() ) {
                            $author = $byline;
                        } else {
                            $authors = $obj->get_authors();
                            $author_data = $authors[0];
                            $author = $author_data->get_display_name();
                        }
                ?>
                        <div class="large-6 medium-6 small-12 columns">
							<?php CST()->frontend->well_article_container_markup( $obj, $author, $primary_section ); ?>
                        </div>
                        <?php
                    }
                ?>
                <?php 
                    $obj = \CST\Objects\Post::get_by_post_id( $homepage_secondary_well_posts[3]->ID );
                    if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
                        $primary_section = $obj->get_primary_parent_section();
                        if( $byline = $obj->get_byline() ) {
                            $author = $byline;
                        } else {
                            $authors = $obj->get_authors();
                            $author_data = $authors[0];
                            $author = $author_data->get_display_name();
                        }
                ?>
                        <div class="large-6 medium-6 small-12 columns">
							<?php CST()->frontend->well_article_container_markup( $obj, $author, $primary_section ); ?>
                        </div>
                        <?php
                    }
                ?>
                    </div>
                </div>
            </section>