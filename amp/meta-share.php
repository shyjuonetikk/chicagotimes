<?php
$obj = new CST\Objects\Article( get_the_ID() );
$cst_amp = CST_AMP::get_instance();
?>
<div class="post-meta-social">
		<?php echo $cst_amp->amp_facebook_share( $obj ); ?>
		<?php echo $cst_amp->amp_twitter_share( $obj ); ?>
</div>