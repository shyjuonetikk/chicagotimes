<aside class="sidebar show-for-large-up article-sidebar" id="post-sidebar-left">
<?php if ( is_single() ) : ?>
    <div class="stick-sidebar-left">
		<?php echo CST()->dfp_handler->unit( 1, 'div-gpt-sky-scraper', 'dfp' ); ?>
        <hr>
    <?php get_template_part( 'parts/vendors/nativo-article' ); ?>
    </div>
<?php endif; ?>
</aside>