<?php global $homepage_main_well_posts; ?>
<div class="row">
    <div class="large-12 content-wrapper">
    <h2 class="mobile-top-news show-for-small-only"><?php esc_html_e( 'Top News', 'chicagosuntimes' ); ?></h2>
        <div class="large-8 medium-12 columns main-well-container">
            <section id="main-well">
                <div>
            <?php 
                $obj = \CST\Objects\Post::get_by_post_id( $homepage_main_well_posts[0]->ID );
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
                    <div class="large-12 medium-12 columns main-article-container">
						<?php CST()->frontend->well_article_markup( $obj, $author, $primary_section ); ?>
                    </div>
                    <?php
                }
            ?>
                    <div class="large-12 medium-12 left-main-well">
                <?php 
                    $obj = \CST\Objects\Post::get_by_post_id( $homepage_main_well_posts[1]->ID );
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
                        <div class="large-6 medium-6 columns">
                            <div class="article-container">
								<?php CST()->frontend->well_article_markup( $obj, $author, $primary_section, 'chiwire-header-medium' ); ?>
                            </div>
                        </div>
                        <?php
                    }
                ?>
                <?php 
                    $obj = \CST\Objects\Post::get_by_post_id( $homepage_main_well_posts[2]->ID );
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
                        <div class="large-6 medium-6 columns">
                            <div class="article-container">
	                            <?php CST()->frontend->well_article_markup( $obj, $author, $primary_section, 'chiwire-header-medium' ); ?>
                            </div>
                        </div>
                        <?php
                    }
                ?>
                    </div>
                </div>
            </section>
        </div>
        <div class="large-4 columns homepage-sidebar">
            <?php get_template_part( 'parts/homepage/right-sidebar' ); ?>
        </div>
    </div>
</div>
<?php get_template_part( 'parts/dfp/homepage/dfp-billboard' ); ?>
<?php get_template_part( 'parts/dfp/homepage/dfp-sbb' ); ?>