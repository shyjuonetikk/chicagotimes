<div class="slider">
<?php
$cst = CST_Frontend::get_instance();
$primary_slug = $cst->slug_detection();
switch ( $primary_slug ) {
	case 'sports':
		dynamic_sidebar( 'sports_headlines' );
		break;
	case 'news':
		dynamic_sidebar( 'news_headlines' );
		break;
	case 'politics':
		dynamic_sidebar( 'politics_headlines' );
		break;
	case 'entertainment':
		dynamic_sidebar( 'entertainment_headlines' );
		break;
	case 'lifestyles':
		dynamic_sidebar( 'lifestyles_headlines' );
		break;
	case 'columnists':
		dynamic_sidebar( 'columnists_headlines' );
		break;
	case 'opinion':
		dynamic_sidebar( 'opinion_headlines' );
		break;
	case 'autos':
		dynamic_sidebar( 'autos_headlines' );
		break;
	case 'sponsored':
		break;
	default:
		dynamic_sidebar( 'news_headlines' );
		break;
}
?>
</div>
