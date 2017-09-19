<?php $obj = get_queried_object(); ?>

<?php if ( is_author() ) : ?>

		<?php $section = 'news'; ?>

	<?php else: ?>

	<?php if ( $obj ) :

        $post_object = \CST\Objects\Post::get_by_post_id( $obj->ID );

		if( is_tax() ) : ?>
			<?php if ( $section = $obj->slug ) : ?>
				<?php if( ( $section != 'sports' || $obj != 'news' ) && $obj->parent != 0 ) : ?>
					<?php $section = get_term( $obj->parent, 'cst_section' )->slug; ?>
				<?php endif; ?>
			<?php else: ?>
				<?php
                    if ( $post_object ) {
                        $section = $post_object->get_primary_section()->slug;
                    } ?>
			<?php endif; ?>
		<?php else: ?>
			<?php
                if ( $post_object) {
                    $section = $post_object->get_primary_parent_section()->slug;
                } ?>
		<?php endif; ?>
	<?php else: ?>

		<?php $section = 'news'; ?>

	<?php endif; ?>

<?php endif; ?>


<?php if ( 'sports' == $section ) : ?>
	<a href="<?php echo esc_url( wpcom_vip_get_term_link( 'sports', 'cst_section' ) ); ?>"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/sports-logo.svg" /></a>
<?php elseif ( 'news' == $section ) : ?>
	<a href="<?php echo esc_url( wpcom_vip_get_term_link( 'news', 'cst_section' ) ); ?>"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/newsfeed-color.svg" /></a>
<?php endif;
