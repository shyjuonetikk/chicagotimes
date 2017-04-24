<?php if ( $section = $obj->get_primary_section() ) : ?>
<div class="post-meta post-meta-top">
	<span class="post-section-taxonomy"><a href="<?php echo esc_url( wpcom_vip_get_term_link( $section ) ); ?>"><?php echo esc_html( $section->name ); ?></a></span>
</div>
<?php endif;
