<!doctype html>
<html amp>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
	<?php do_action( 'amp_post_template_head', $this ); ?>

	<style amp-custom>
		<?php $this->load_parts( array( 'style' ) ); ?>
		<?php do_action( 'amp_post_template_css', $this ); ?>
	</style>
</head>
<body>
<?php do_action( 'amp_post_template_body_start', $this ); ?>
<?php $this->load_parts( array( 'header-bar' ) ); ?>
<div class="amp-wp-content">
	<div class="amp-cst-meta">
		<ul class="amp-wp-meta">
			<?php $this->load_parts( apply_filters( 'amp_post_template_meta_parts', array( 'meta-taxonomy', 'meta-time' ) ) ); ?>
		</ul>
		<?php echo $this->load_parts( array( 'meta-share' ) ); ?>
	</div>
	<?php $this->load_parts( array( 'meta-leaderboard' ) ); ?>
	<h1 class="amp-wp-title"><?php echo wp_kses_data( $this->get( 'post_title' ) ); ?></h1>
	<ul class="amp-wp-meta author">
		<?php $this->load_parts( apply_filters( 'amp_post_template_meta_parts', array( 'meta-author' ) ) ); ?>
	</ul>
	<div class="article">
		<?php echo $this->get( 'post_amp_content' ); // amphtml content; no kses ?>
	</div>
	<?php do_action( 'cst_amp_after_amp_content' ); ?>
</div>
<?php do_action( 'amp_post_template_footer', $this ); ?>
</body>
</html>
