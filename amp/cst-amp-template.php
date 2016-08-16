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
<?php $this->load_parts( array( 'header-bar' ) ); ?>
<div class="amp-wp-content">
	<ul class="amp-wp-meta">
		<?php $this->load_parts( apply_filters( 'amp_post_template_meta_parts', array( 'meta-taxonomy', 'meta-time' ) ) ); ?>
	</ul>
	<h1 class="amp-wp-title"><?php echo wp_kses_data( $this->get( 'post_title' ) ); ?></h1>
	<ul class="amp-wp-meta">
		<?php $this->load_parts( apply_filters( 'amp_post_template_meta_parts', array( 'meta-author' ) ) ); ?>
	</ul>
	<div class="article">
		<?php echo $this->get( 'post_amp_content' ); // amphtml content; no kses ?>
	</div>
</div>
<?php do_action( 'amp_post_template_footer', $this ); ?>
</body>
</html>
