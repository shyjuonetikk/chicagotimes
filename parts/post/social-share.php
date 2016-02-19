<?php if ( ! $obj ) {
    return;
}

if ( ! is_singular() ) : ?>
	<div class="right">
<?php endif; ?>

<?php if ( 'cst_embed' == $obj->get_post_type() && 'twitter' == $obj->get_embed_type() ) :
	$embed_data = $obj->get_embed_data();
	if ( ! $embed_data ) {
		return;
	}
?>
<a class="post-social reply" href="<?php echo esc_url( sprintf( 'https://twitter.com/intent/tweet?in_reply_to=%d', $embed_data->id_str ) ); ?>"><i class="fa fa-reply"></i></a>
<a class="post-social retweet" href="<?php echo esc_url( sprintf( 'https://twitter.com/intent/retweet?tweet_id=%d', $embed_data->id_str ) ); ?>"><i class="fa fa-retweet"></i></a>
<a class="post-social favorite" href="<?php echo esc_url( sprintf( 'https://twitter.com/intent/favorite?tweet_id=%d', $embed_data->id_str ) ); ?>"><i class="fa fa-star"></i></a>

<?php else :

	$share_link = rawurldecode( $obj->get_share_link() );
	$text = rawurlencode( $obj->get_twitter_share_text() );
	$twitter_args = array(
		'url'        => $share_link,
		'text'       => $text,
		'via'        => CST_TWITTER_USERNAME,
		);
	$twitter_url = add_query_arg( $twitter_args, 'https://twitter.com/share' );
?>
<a class="post-social twitter" target="_blank" href="<?php echo esc_url( $twitter_url ); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-twitter"></i></a>
<a class="post-social facebook" target="_blank" href="<?php echo esc_url( 'https://www.facebook.com/sharer/sharer.php?u=' . $obj->get_share_link() ); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-facebook"></i></a>
<?php endif; ?>

<?php if ( ! is_singular() ) : ?>
	</div>
<?php endif; ?>