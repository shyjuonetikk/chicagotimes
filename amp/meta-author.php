<?php
$obj           = new CST\Objects\Article( get_the_ID());

foreach( $obj->get_authors() as $i => $author ) {
	?>
	<li class="amp-wp-byline">
		<?php if ( function_exists( 'get_avatar_url' ) ) : ?>
			<amp-img src="<?php echo esc_url( get_avatar_url( $author->get_email(), array(
				'size' => 24,
			) ) ); ?>" width="24" height="24" layout="fixed"></amp-img>
		<?php endif; ?>
		<span class="amp-wp-author"><?php echo esc_html( $author->get_display_name() ); ?></span>
	</li>
<?php
}