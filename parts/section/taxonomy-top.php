<?php if( ! is_tax( 'cst_topic' ) && ! is_tax( 'cst_person' ) && ! is_tax( 'cst_location' ) ) : ?>
<?php $section_front = get_queried_object()->slug; ?>
<?php if ( $section_front ) : ?>
	<?php 
		if( $section_front == 'obituaries-obituaries' ) :
			$section_front_spacing = 'obituaries';
		else :
			$section_front_spacing = str_replace( '-', ' ', $section_front ); 
		endif;
	?>
	<a href="" class="section-front"><?php esc_html_e( $section_front_spacing ); ?></a>
	<?php if( $section_front_spacing == 'television' ) : ?>
		<a href="http://www.wciu.com" target="_blank" class="section-front-sponsor">Brought to you by
			<img src="<?php echo get_template_directory_uri(); ?>/assets/images/wciu-logo.png" alt="WCIU LOGO">
		</a>
	<?php endif; ?>
<?php endif; ?>
<?php else: ?>
<div id="section-top">

	<div class="row">
		<div class="small-12 columns">

		<h2><?php
			if ( is_tax( 'cst_topic' ) ) {
				echo '<span class="fa">#</span>';
			} else if ( is_tax( 'cst_person' ) ) {
				echo '<i class="fa fa-male"></i>';
			} else if ( is_tax( 'cst_location' ) ) {
				echo '<i class="fa fa-location-arrow"></i>';
			}
		?><?php echo esc_html( get_queried_object()->name ); ?></h2>
		<?php if ( get_queried_object()->description ) : ?>
		<div id="section-description">
			<?php echo wpautop( get_queried_object()->description ); ?>
		</div>
		<?php endif; ?>
		<?php if( ! is_tax( 'cst_section' ) ) : ?>
		<?php
			$share_link = rawurlencode( wpcom_vip_get_term_link( get_queried_object() ) );
			$text = ( get_queried_object()->description ) ? rawurlencode( get_queried_object()->description ) : rawurlencode( get_queried_object()->name );
			$twitter_args = array(
				'url'        => $share_link,
				'text'       => $text,
				);
			$twitter_url = add_query_arg( $twitter_args, 'https://twitter.com/share' );
			$facebook_args = array(
				'u'          => $share_link,
				);
			$facebook_url = add_query_arg( $facebook_args, 'https://www.facebook.com/sharer/sharer.php' );
		?> 
		<div id="section-share">
			<a target="_blank" href="<?php echo esc_url( $twitter_url ); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-twitter"></i></a>
			<a target="_blank" href="<?php echo esc_url( $facebook_url ); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-facebook"></i></a>
		</div>
		<?php endif; ?>

		</div>

	</div>

</div>
<?php endif; ?>