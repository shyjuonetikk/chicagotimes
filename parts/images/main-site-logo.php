<?php $obj = get_queried_object(); ?>

<?php if ( is_tax() ) : ?>
	<?php if ( $section = $obj->slug ) : ?>
		<?php if ( ( 'sports' !== $section || 'news' !== $obj ) && 0 !== $obj->parent ) : ?>
			<?php $section = get_term( $obj->parent, 'cst_section' )->slug; ?>
		<?php endif; ?>
	<?php else : ?>
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
<?php else : ?>
	<?php

	$section = null;
	if ( is_singular() ) {
		$post = \CST\Objects\Post::get_by_post_id( $obj->ID );

		if ( $post ) {
			$parent_section = $post->get_primary_parent_section();

			if ( $parent_section ) {
				$section = $parent_section->slug;
			}
		}
	} ?>
<?php endif; ?>
<?php
$header_sections = array(
	'sports',
	'news',
	'politics',
	'entertainment',
	'lifestyles',
	'opinion',
	'columnists',
	'obits',
	'autos',
);
if ( in_array( $section, $header_sections, true ) ) {
	$term_link = wpcom_vip_get_term_link( $section, 'cst_section' );
	if ( ! is_wp_error( $term_link ) ) {
		$term_object = wpcom_vip_get_term_by( 'name', $section, 'cst_section' );
?>
<a id="newsfeed-logo" href="<?php echo esc_url( wpcom_vip_get_term_link( $section, 'cst_section' ) ); ?>"><?php esc_html_e( $term_object->name, 'chicagosuntimes' ); ?></a>
<?php }
}
