<?php $column_well_sections = array(
	'news' => 'Home2',
	'sports' => 'Home3',
	'politics' => 'Home4',
	'the-watchdogs' => 'Home5',
	'entertainment' => '',
	'columnists' => '',
	'opinion' => '',
	'lifestyles' => '',
);
?>
<section id="section-column-wells">
    <div class="row" data-equalizer>
<?php foreach ( $column_well_sections as $section_slug => $sponsored_key ) { ?>
	<div class="large-3 medium-6 small-12 columns" data-equalizer-watch>
		<div class="section-list">
			<h3 class="<?php echo esc_attr( $section_slug ); ?>-border"><a href="<?php echo esc_url( home_url( '/' ) . 'section/' . esc_attr( $section_slug ) . '/' ); ?>" data-on="click" data-event-category="navigation"
									   data-event-action="navigate-hp-<?php echo esc_attr( $section_slug ); ?>-column-title"><?php esc_html_e( ucfirst( $section_slug ), 'chicagosuntimes' ); ?></a></h3>
			<?php $query = array(
				'post_type'           => array( 'cst_article' ),
				'ignore_sticky_posts' => true,
				'posts_per_page'      => 5,
				'post_status'         => 'publish',
				'cst_section'         => esc_attr( $section_slug ),
			);
			CST()->frontend->cst_homepage_content_block( $query, esc_attr( $sponsored_key ) ); ?>
		</div>
	</div>
<?php } ?>
    </div>
</section>
