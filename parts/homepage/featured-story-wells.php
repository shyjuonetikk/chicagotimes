<?php global $featured_homepage_story; ?>
<hr/>
<h2 class="section-title"><span><?php echo esc_html_e( 'Featured Story', 'chicagosuntimes' ); ?></span></h2>
<hr/>
<section id="featured-story-wells">
    <div class="row">
        <div class="large-12 columns">
            <div class="featured-story">
            <a href="<?php esc_html_e( $featured_homepage_story['link'] ); ?>" target="_blank">
                <img src="<?php esc_html_e( $featured_homepage_story['image'] ); ?>" alt="article promo image">
                <h2><?php esc_html_e( $featured_homepage_story['title'], 'chicagosuntimes' ); ?></h2>
            </a>
            </div>
        </div>
    </div>
</section>