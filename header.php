<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<?php get_template_part( 'parts/analytics/chartbeat-header' ); ?>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/apple-touch-icon-152x152.png">
	<link rel="icon" type="image/png" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/favicon-32x32.png" sizes="32x32" />
	<link rel="icon" type="image/png" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/favicon-16x16.png" sizes="16x16" />
	<meta name="msapplication-TileColor" content="#282828" />
	<meta name="msapplication-TileImage" content="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/mstile-144x144.png" />
	<meta name="msapplication-square70x70logo" content="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/mstile-70x70.png" />
	<meta name="msapplication-square150x150logo" content="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/mstile-150x150.png" />
	<meta name="msapplication-wide310x150logo" content="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/mstile-310x150.png" />
	<meta name="msapplication-square310x310logo" content="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/mstile-310x310.png" />
	<?php if( is_front_page() ) { ?>
		<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<?php } ?>
	<script type="text/javascript" src="http://mtrx.go.sonobi.com/morpheus.chicagosuntimes.5552.js"></script>
	<?php get_template_part( 'parts/analytics/google' ); ?>
	
	<?php
	if ( is_front_page() || is_page() ) {
		get_template_part( 'parts/dfp/homepage/dfp-homepage' );
	} elseif( is_search() ) {
		get_template_part( 'parts/dfp/dfp-search' );
	} else {
		get_template_part( 'parts/dfp/dfp-check-section' );
	}

	if ( is_singular() ) {
		$current_obj = \CST\Objects\Post::get_by_post_id( get_the_ID() );
		if ( $current_obj ) {
			get_template_part( 'parts/vendors/nativo-content-header' );
			get_template_part( 'parts/vendors/adsupply-popunder-header' );
			get_template_part( 'parts/taboola/taboola-header' );
		}
	}
	?>

	<?php wp_head(); ?>
	<?php get_template_part( 'parts/analytics/comscore' ); ?>
</head>

<body <?php body_class(); ?>>
<div id="ie8-user" style="display:none;"></div>

<?php 
	if ( is_front_page() || is_404() ) {
		get_template_part( 'parts/homepage/header' );
	} else {
		get_template_part( 'parts/page-header' );
	}
?>