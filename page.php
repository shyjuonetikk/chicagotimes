<?php
  /* 
   * Template Name: Page Template
   */
?>
<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<div>
    <section id="subscribe">
        <div class="row">
            <div class="just-in-wrapper large-12 columns mbox3">
            <?php the_content(); ?>
            </div>
        </div>
    </section>
</div>
<?php endwhile; else : ?>
    <p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>
<?php get_template_part( 'parts/homepage/footer' ); ?>

<?php get_footer(); ?>