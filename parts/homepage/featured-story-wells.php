<?php global $featured_homepage_story; ?>
<a href="<?php echo esc_url( get_post_type_archive_link( 'cst_feature' ) ); ?>" target="_blank" data-on="click" data-event-category="navigation" data-event-action="navigate-hp-featured-story">
<hr class="before">
<h2 class="section-title"><span><?php echo esc_html_e( 'Featured Story', 'chicagosuntimes' ); ?></span></h2>
<hr/>
</a>
<section id="featured-story-wells">
    <div>
        <div class="large-12 columns">
            <div class="featured-story">
            <a href="<?php esc_html_e( $featured_homepage_story['link'] ); ?>" target="_blank" data-on="click" data-event-category="navigation" data-event-action="navigate-hp-featured-story">
                <img src="<?php esc_html_e( $featured_homepage_story['image'] ); ?>" alt="article promo image">
                <h2><?php esc_html_e( $featured_homepage_story['title'], 'chicagosuntimes' ); ?></h2>
            </a>
            </div>
        </div>
    </div>
</section>