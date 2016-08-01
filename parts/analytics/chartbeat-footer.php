<?php if ( is_singular() ) {
    $obj = \CST\Objects\Post::get_by_post_id( get_queried_object_id() );
    $sections = $obj->get_sections();
    $section_list = array();
    if( $sections ) {
        if ( isset( $obj ) && is_object( $obj ) ) {
            foreach( $sections as $section ) {
                array_push( $section_list, strtolower( $section->name ) );
            }
        }
    }
}
    $domain = parse_url( home_url(), PHP_URL_HOST );
?>

<script type='text/javascript'>
var _sf_async_config={};
_sf_async_config.uid = 38241;
_sf_async_config.domain = '<?php echo esc_js( $domain ); ?>';
_sf_async_config.useCanonical = true;
<?php if ( isset( $obj ) && is_object( $obj ) ) : ?>
	<?php if ( $section_list ) : ?>
_sf_async_config.sections = '<?php echo esc_js( implode( ', ', $section_list ) ); ?>';
	<?php endif; ?>
	<?php if ( $authors = $obj->get_authors() ) :
$author = array_shift( $authors ); ?>
_sf_async_config.authors = '<?php echo esc_js( $author->get_display_name() ); ?>';
	<?php endif; ?>
<?php endif; ?>
<?php if ( is_singular() ) { ?>
var _cbq = window._cbq || [];
_cbq.push(['_postid','<?php echo wp_json_encode( get_the_ID() ); ?>']);
<?php } ?>
(function(){
function loadChartbeat()
{ window._sf_endpt=(new Date()).getTime(); var e = document.createElement('script'); e.setAttribute('language', 'javascript'); e.setAttribute('type', 'text/javascript'); e.setAttribute('src', '//static.chartbeat.com/js/chartbeat.js'); document.body.appendChild(e); }
var oldonload = window.onload;
window.onload = (typeof window.onload != 'function') ?
loadChartbeat : function()
{ oldonload(); loadChartbeat(); }
;
})();
</script>
