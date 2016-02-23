<hr/>
<div class="row">
    <div class="large-12 columns dfp-atf-leaderboard">
        <?php get_template_part( 'parts/dfp/homepage/dfp-atf-leaderboard' ); ?>
    </div>
</div>
<h2 class="section-title"><span><?php esc_html_e( 'More From', 'chicagosuntimes' ); ?></span></h2>
<hr/>
<section id="section-column-wells">
    <div class="row">
        <div class="large-3 medium-6 columns">
            <div class="section-list">
                <h3 class="news-border"><a href="<?php echo esc_url( home_url( '/' ) . 'section/news/' ); ?>"><?php esc_html_e( 'News', 'chicagosuntimes' ); ?></a></h3>
	                <?php $query = array(
		                'post_type'             => array( 'cst_article' ),
		                'ignore_sticky_posts'   => true,
		                'posts_per_page'        => 5,
		                'post_status'           => 'publish',
		                'cst_section'           => 'news',
	                );
	                CST()->frontend->cst_homepage_content_block( $query ); ?>
            </div>
        </div>
        <div class="large-3 medium-6 columns">
            <div class="section-list">
                <h3 class="sports-border"><a href="<?php echo esc_url( home_url( '/' ) . 'section/sports/' ); ?>"><?php esc_html_e( 'Sports', 'chicagosuntimes' ); ?></a></h3>
	                <?php $query = array(
		                'post_type'             => array( 'cst_article' ),
		                'ignore_sticky_posts'   => true,
		                'posts_per_page'        => 5,
		                'post_status'           => 'publish',
		                'cst_section'           => 'sports',
	                );
	                CST()->frontend->cst_homepage_content_block( $query ); ?>
            </div>
        </div>
        <div class="large-3 medium-6 columns">
            <div class="section-list">
                <h3 class="politics-border"><a href="<?php echo esc_url( home_url( '/' ) . 'section/politics/' ); ?>"><?php esc_html_e( 'Politics', 'chicagosuntimes' ); ?></a></h3>
	                <?php $query = array(
		                'post_type'             => array( 'cst_article' ),
		                'ignore_sticky_posts'   => true,
		                'posts_per_page'        => 5,
		                'post_status'           => 'publish',
		                'cst_section'           =>  'politics',
	                );
	                CST()->frontend->cst_homepage_content_block( $query ); ?>
            </div>
        </div>
        <div class="large-3 medium-6 columns">
            <div class="section-list">
                <h3 class="entertainment-border"><a href="<?php echo esc_url( home_url( '/' ) . 'section/entertainment/' ); ?>"><?php esc_html_e( 'Entertainment', 'chicagosuntimes' ); ?></a></h3>
	                <?php $query = array(
		                'post_type'             => array( 'cst_article' ),
		                'ignore_sticky_posts'   => true,
		                'posts_per_page'        => 5,
		                'post_status'           => 'publish',
		                'cst_section'           => 'entertainment',
	                );
	                CST()->frontend->cst_homepage_content_block( $query ); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="large-3 medium-6 columns">
            <div class="section-list">
                <h3 class="columnists-border"><a href="<?php echo esc_url( home_url( '/' ) . 'section/columnists/' ); ?>"><?php esc_html_e( 'Columnists', 'chicagosuntimes' ); ?></a></h3>
	                <?php $query = array(
		                'post_type'             => array( 'cst_article' ),
		                'ignore_sticky_posts'   => true,
		                'posts_per_page'        => 5,
		                'post_status'           => 'publish',
		                'cst_section'           => 'columnists',
	                );
	                CST()->frontend->cst_homepage_content_block( $query ); ?>
            </div>
        </div>
        <div class="large-3 medium-6 columns">
            <div class="section-list">
                <h3 class="opinion-border"><a href="<?php echo esc_url( home_url( '/' ) . 'section/opinion/' ); ?>"><?php esc_html_e( 'Opinion', 'chicagosuntimes' ); ?></a></h3>
	                <?php $query = array(
		                'post_type'             => array( 'cst_article' ),
		                'ignore_sticky_posts'   => true,
		                'posts_per_page'        => 5,
		                'post_status'           => 'publish',
		                'cst_section'           => 'opinion',
	                );
	                CST()->frontend->cst_homepage_content_block( $query ); ?>
            </div>
        </div>
        <div class="large-3 medium-6 columns">
            <div class="section-list">
                <h3 class="lifestyles-border"><a href="<?php echo esc_url( home_url( '/' ) . 'section/lifestyles/' ); ?>"><?php esc_html_e( 'Lifestyles', 'chicagosuntimes' ); ?></a></h3>
	                <?php $query = array(
		                'post_type'             => array( 'cst_article' ),
		                'ignore_sticky_posts'   => true,
		                'posts_per_page'        => 5,
		                'post_status'           => 'publish',
		                'cst_section'           => 'lifestyles',
	                );
	                CST()->frontend->cst_homepage_content_block( $query ); ?>
            </div>
        </div>
        <div class="large-3 medium-6 columns">
            <div class="section-list">
                <h3><a href="<?php echo esc_url( home_url( '/' ) . 'section/the-watchdogs/' ); ?>"><?php esc_html_e( 'The Watchdogs', 'chicagosuntimes' ); ?></a></h3>
	                <?php $query = array(
		                'post_type'             => array( 'cst_article' ),
		                'ignore_sticky_posts'   => true,
		                'posts_per_page'        => 5,
		                'post_status'           => 'publish',
		                'cst_section'           => 'the-watchdogs',
	                );
	                CST()->frontend->cst_homepage_content_block( $query ); ?>
            </div>
        </div>
    </div>
</section>