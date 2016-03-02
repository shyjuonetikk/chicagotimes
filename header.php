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
	<link rel="icon" type="image/png" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/favicon-32x32.png" sizes="32x32" />
	<link rel="icon" type="image/png" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/favicon-16x16.png" sizes="16x16" />
	<?php if( is_front_page() ) { ?>
		<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<?php } ?>
	<meta name="msapplication-TileColor" content="#282828">
	<meta name="msapplication-TileImage" content="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicons/mstile-144x144.png">
	
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
			$primary_section = $current_obj->get_primary_parent_section();
			if( ! $primary_section ) {
				$primary_section = $current_obj->get_grandchild_parent_section();
			}
			
			if( $primary_section->slug == 'sponsored' ) {
				get_template_part( 'parts/vendors/nativo-header' );
				get_template_part( 'parts/vendors/nativo-content-header' );
			}
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
	if ( is_front_page() ) {
		get_template_part( 'parts/homepage/header' );
	} else {
		get_template_part( 'parts/page-header' );
	}
?>