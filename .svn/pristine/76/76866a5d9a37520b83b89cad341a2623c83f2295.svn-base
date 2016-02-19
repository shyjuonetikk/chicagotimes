<?php $obj = get_queried_object(); ?>

<?php if( is_tax() ) : ?>
	<?php if ( $section = $obj->slug ) : ?>
		<?php if( ( $section != 'sports' || $obj != 'news' ) && $obj->parent != 0 ) : ?>
			<?php $section = get_term( $obj->parent, 'cst_section' )->slug; ?>
		<?php endif; ?>
	<?php else: ?>	
		<?php 

		$section = null;

		$post = \CST\Objects\Post::get_by_post_id( $obj->ID );

		if ( $post ) {
			$primary_section = $post->get_primary_section();

			if ( $primary_section ) {
				$section = $primary_section->slug;
			} 
		} ?>
	<?php endif; ?>
<?php else: ?>
	<?php 

	$section = null;

	$post = \CST\Objects\Post::get_by_post_id( $obj->ID );

	if ( $post ) {
		$parent_section = $post->get_primary_parent_section();

		if ( $parent_section ) {
			$section = $parent_section->slug;
		} 
	} ?>
<?php endif; ?>

<?php if ( 'sports' == $section ) : ?>
	<a href="<?php echo esc_url( get_term_link( 'sports', 'cst_section' ) ); ?>"><img class="newsfeed-logo" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/sports-logo.svg" /></a>
<?php elseif ( 'news' == $section ) : ?>
	<a href="<?php echo esc_url( get_term_link( 'news', 'cst_section' ) ); ?>"><img class="newsfeed-logo" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/newsfeed-color.svg" /></a>
<?php endif; ?>