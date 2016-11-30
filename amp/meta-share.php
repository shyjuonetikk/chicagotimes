<?php
$obj = new CST\Objects\Article( get_the_ID() );
$cst_amp_share = new CST_AMP_Social_Share_Embed();
?>
<div class="post-meta-social">
		<?php echo $cst_amp_share->cst_build_facebook_share_element( $obj ); ?>
		<?php echo $cst_amp_share->cst_build_twitter_share_element( $obj ); ?>
</div>