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
<span class="post-section-taxonomy"><a href="<?php echo esc_url( get_term_link( $section ) ); ?>"><?php echo esc_html( $section->name ); ?></a></span>
<?php endif; ?>
<?php if ( !is_sticky() ) : ?>
	<span class="post-relative-date top-date"><?php echo human_time_diff( $obj->get_post_date_gmt() ); ?></span>
<?php endif; ?>
</div>