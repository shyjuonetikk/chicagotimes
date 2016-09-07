<?php

if ( ! $obj ) {
    return;
}

	$classes = array( 'post-meta', 'post-meta-top' );

	if ( is_singular() ) {
		$classes[] = 'columns medium-11 medium-offset-1 end';
	}

	if ( is_sticky() && !is_singular() ) {
		$classes[] = 'sticky-taxonomy';
	}
?>
<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
<?php if ( $section = $obj->get_primary_section() ) : ?>
<?php if ( is_sticky() && !is_singular() ) : ?>
	<span class="developing">
		<span class="triangle-top-right"></span>
		<span class="developing-text">developing</span>
		<span class="right-ribbon"></span>
	</span>
<?php endif; ?>
<span class="post-section-taxonomy">
	<a href="<?php echo esc_url( wpcom_vip_get_term_link( $section ) ); ?>"><?php echo esc_html( $section->name ); ?></a>
</span>
	<?php if ( is_singular() ) {
		CST()->frontend->section_front_header_and_sponsor( $section->term_id );
	}?>
<?php endif; ?>
	<?php if ( !is_sticky() ) : ?>
	<span class="post-relative-date top-date"><?php echo date( 'm/d/Y, h:ia', $obj->get_post_date() ); ?></span>
<?php endif; ?>
</div>