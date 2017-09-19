<?php $obj = get_queried_object();
if ( is_tax() ) : ?>
	<?php if ( $section = $obj->slug ) : ?>
		<?php if ( ( 'sports' !== $section || 'news' !== $obj ) && 0 !== $obj->parent ) : ?>
			<?php $section = get_term( $obj->parent, 'cst_section' )->slug; ?>
		<?php endif; ?>
	<?php else : ?>
		<?php
		$section = null;
		$post_object = \CST\Objects\Post::get_by_post_id( $obj->ID );
		if ( $post_object ) {
			$primary_section = $post_object->get_primary_section();
			if ( $primary_section ) {
				$section = $primary_section->slug;
			}
		} ?>
	<?php endif; ?>
<?php else : ?>
	<?php
	$section = null;
	if ( is_singular() ) {
		$post_object = \CST\Objects\Post::get_by_post_id( $obj->ID );
		if ( $post_object ) {
			$parent_section = $post_object->get_primary_parent_section();
			if ( $parent_section ) {
				$section = $parent_section->slug;
			}
		}
	} ?>
<?php endif; ?>
<h2>
<?php if ( 'sports' === $section ) : ?>
	<a id="newsfeed-logo" href="<?php echo esc_url( wpcom_vip_get_term_link( 'sports', 'cst_section' ) ); ?>" data-on="click" data-event-category="navigation" data-event-action="navigate-sf-newsfeed-logo"><?php esc_html_e( 'Sports', 'chicagosuntimes' ); ?></a>
<?php elseif ( 'news' === $section ) : ?>
	<a id="newsfeed-logo" href="<?php echo esc_url( wpcom_vip_get_term_link( 'news', 'cst_section' ) ); ?>" data-on="click" data-event-category="navigation" data-event-action="navigate-sf-newsfeed-logo"><?php esc_html_e( 'News', 'chicagosuntimes' ); ?></a>
<?php elseif ( 'politics' === $section ) : ?>
	<a id="newsfeed-logo" href="<?php echo esc_url( wpcom_vip_get_term_link( 'politics', 'cst_section' ) ); ?>" data-on="click" data-event-category="navigation" data-event-action="navigate-sf-newsfeed-logo"><?php esc_html_e( 'Politics', 'chicagosuntimes' ); ?></a>
<?php elseif ( 'entertainment' === $section ) : ?>
	<a id="newsfeed-logo" href="<?php echo esc_url( wpcom_vip_get_term_link( 'entertainment', 'cst_section' ) ); ?>" data-on="click" data-event-category="navigation" data-event-action="navigate-sf-newsfeed-logo"><?php esc_html_e( 'Entertainment', 'chicagosuntimes' ); ?></a>
<?php elseif ( 'lifestyles' === $section ) : ?>
	<a id="newsfeed-logo" href="<?php echo esc_url( wpcom_vip_get_term_link( 'lifestyles', 'cst_section' ) ); ?>" data-on="click" data-event-category="navigation" data-event-action="navigate-sf-newsfeed-logo"><?php esc_html_e( 'Lifestyles', 'chicagosuntimes' ); ?></a>
<?php elseif ( 'opinion' === $section ) : ?>
	<a id="newsfeed-logo" href="<?php echo esc_url( wpcom_vip_get_term_link( 'opinion', 'cst_section' ) ); ?>" data-on="click" data-event-category="navigation" data-event-action="navigate-sf-newsfeed-logo"><?php esc_html_e( 'Opinion', 'chicagosuntimes' ); ?></a>
<?php elseif ( 'columnists' === $section ) : ?>
	<a id="newsfeed-logo" href="<?php echo esc_url( wpcom_vip_get_term_link( 'columnists', 'cst_section' ) ); ?>" data-on="click" data-event-category="navigation" data-event-action="navigate-sf-newsfeed-logo"><?php esc_html_e( 'Columnists', 'chicagosuntimes' ); ?></a>
<?php elseif ( 'obits' === $section ) : ?>
	<a id="newsfeed-logo" href="<?php echo esc_url( wpcom_vip_get_term_link( 'obits', 'cst_section' ) ); ?>" data-on="click" data-event-category="navigation" data-event-action="navigate-sf-newsfeed-logo"><?php esc_html_e( 'Obits', 'chicagosuntimes' ); ?></a>
<?php endif; ?>
</h2>
