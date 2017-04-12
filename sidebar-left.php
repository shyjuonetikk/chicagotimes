<aside class="sidebar show-for-large-up article-sidebar large-2 columns" id="post-sidebar-left">
<?php if ( is_single() ) : ?>
    <div class="stick-sidebar-left">
		<?php echo wp_kses( CST()->dfp_handler->unit( 1, 'div-gpt-sky-scraper', 'dfp' ), CST()->dfp_kses ); ?>
        <hr>
    <?php get_template_part( 'parts/vendors/nativo-article' ); ?>
    </div>
<?php endif; ?>
</aside>
