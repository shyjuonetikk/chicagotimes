<?php

/**
 * Class CST_DFP_Handler
 *
 * Basic centralized handler to generate and return the
 * markup for DFP ad divs
 */
class CST_DFP_Handler {

	private static $instance;
	private $adhesion_template_begin =
	'
<div id="cst-wrapper-%1$d">
	<div class="cst-dfp cst-creative">
	<div id="cst-close-%1$d" onclick="document.getElementById(\'cst-close-%1$d\').style.display=\'none\';document.getElementById(\'cst-wrapper-%1$d\').style.display=\'none\';">
		<span class="fa-stack"><i class="fa fa-circle fa-stack-1x"></i><i class="fa fa-times-circle fa-stack-1x fa-inverse"></i></span>
	</div>'
	;

	private $adhesion_template_end =
	'
</div>
</div>'
	;
	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new CST_DFP_Handler();
		}

		return self::$instance;
	}

	/**
	 * @param $index
	 * @param string $type
	 * @param string $class
	 * @return string
	 *
	 * Create a generic markup unit
	 */
	public function unit( $index, $type = '', $class = '' ) {
		if ( empty( $type ) ) {
			$type = 'div-gpt-atf-leaderboard';
		}
		if ( empty( $class ) ) {
			$class = 'dfp dfp-leaderboard dfp-centered show-for-medium-up';
		}
		if ( ! isset( $index ) ) {
			$index = 1;
		}
		return sprintf(
			'
<div class="row">
<div id="%1$s" class="%2$s" data-visual-label="%3$s">
<script>
	googletag.cmd.push(function() {
		googletag.display("%4$s");
	})
</script>
</div>
</div>
',
			esc_attr( $type . '-' . intval( $index ) ),
			esc_attr( $class ),
			esc_attr( $type . '-' . intval( $index ) ),
			esc_attr( $type . '-' . intval( $index ) )
		);
	}

	/**
	 * @param $index
	 * @param string $type
	 * @param string $class
	 *
	 * @return string
	 *
	 * Setup to inject a 1x1 DFP definition primarily for Undertone
	 */
	public function one_by_one_unit( $index, $type = '', $class='' ) {
		if ( empty( $type ) ) {
			$type = 'div-gpt-placement';
		}
		if ( empty( $class ) ) {
			$class = 'dfp-placement';
		}
		if ( ! isset( $index ) ) {
			$index = 1;
		}
		return sprintf(
			'
<div id="%1$s" class="%2$s" data-visual-label="%1$s" data-target="one_by_one"></div>
<script class="dfp">
	googletag.cmd.push(function() {
		CSTAdTags[\'%1$s\'] = googletag.defineSlot(dfp.adunitpath, [1,1], \'%1$s\')
		.addService(googletag.pubads())
		.setTargeting("pos", "1x1")
		googletag.display("%1$s");
	})
</script>

',
			esc_attr( $type . '-' . intval( $index ) ),
			esc_attr( $class ),
			esc_attr( $type . '-' . intval( $index ) ),
			esc_attr( $type . '-' . intval( $index ) )
		);
	}
	/**
	 * @param $index
	 * @param string $type
	 * @param string $class
	 * @param string $mapping
	 * @param string $targeting_name
	 * @param string $default_size
	 * @return string
	 *
	 * Create a dynamic generic markup unit
	 */
	public function dynamic_unit( $index, $type = '', $class = '', $mapping = '', $targeting_name = 'atf leaderboard', $default_size = '300,250' ) {
		if ( empty( $type ) ) {
			$type = 'div-gpt-placement';
		}
		if ( empty( $class ) ) {
			$class = 'dfp-placement';
		}
		if ( empty( $mapping ) ) {
			$mapping = 'article_mapping';
		}
		if ( ! isset( $index ) ) {
			$index = 1;
		}
		return sprintf(
			'
<div id="%1$s" class="%2$s" data-visual-label="%1$s" data-target="%4$s"></div>
<script class="dfp">
googletag.cmd.push(function() {
	CSTAdTags[\'%1$s\'] = googletag.defineSlot(dfp.adunitpath, [%5$s], \'%1$s\')
	.defineSizeMapping(%3$s)
	.addService(googletag.pubads())
	.setTargeting("pos", "%4$s")
	.setCollapseEmptyDiv(true, true);
	googletag.display("%1$s");
	});
</script>
',
			esc_attr( $type . '-' . intval( $index ) ),
			esc_attr( $class ),
			esc_attr( $mapping ),
			esc_attr( $targeting_name ),
			esc_attr( $default_size )
		);
	}

	public function get_dynamic_adhesion_start() {
		return $this->adhesion_template_begin;
	}
	public function get_dynamic_adhesion_end() {
		return $this->adhesion_template_end;
	}
	/**
	 * @param $index
	 * @param string $type
	 * @param string $class
	 *
	 * @return string
	 *
	 * Create a DFP cube unit
	 */
	public function cube( $index, $type = '', $class = '' ) {
		if ( empty( $type ) ) {
			$type = 'div-gpt-rr-cube';
		}
		if ( empty( $class ) ) {
			$class = 'dfp dfp-cube';
		}
		return sprintf(
			esc_attr( '<div id="%1$s" class="%2$s"></div>' ),
			esc_attr( $type . '-' . intval( $index ) ),
			esc_attr( $class )
		);
	}

	/**
	 * @param $index
	 *
	 * @return string
	 *
	 * Create a sliding billboard unit
	 */
	public function sbb( $index ) {

		return sprintf(
			'
<div id="%1$s" class="%2$s">
	<div id="dfp-sbb-top" class="dfp-sbb-minimize"></div>
	<div id="dfp-sbb-bottom"></div>
	<script>
	googletag.cmd.push(function() {
		googletag.display("%1$s");
	})
</script>
</div>
			',
			esc_attr( 'div-gpt-sbb' . '-' . $index ),
			esc_attr( 'dfp dfp-sbb dfp-centered' )
		);
	}

	/**
	 * @param $index
	 *
	 * @return string
	 *
	 * Create a custom sliding billboard unit
	 */
	public function sbb_pushdown( $index ) {

		return sprintf(
			'
<div id="%1$s" class="%2$s">
	<div id="dfp-sbb-pushdown-top" class="dfp-sbb-minimize"></div>
	<div id="dfp-sbb-pushdown-bottom"></div>
</div>
',
			esc_attr( 'div-gpt-sbb-pushdown-' . $index ) ,
			esc_attr( 'dfp dfp-sbb dfp-centered show-for-medium-up' )
		);
	}

	/**

	 * Determine content location and inject the settings for DFP
	 * into the markup
	 *
	 * If $amp is true just return the path to be used in the AMP Ad call
	 *
	 * @param bool $amp
	 *
	 * @return string
	 */
	public function ad_header_settings( $amp = false ) {
		$parent_inventory = $this->get_parent_dfp_inventory();
		if ( $amp ) {
			return '/61924087/' . 'AMP_CST';
		}
		$dfp_slug         = 'news';
		$dfp_parent = '';
		$dfp_child = '';
		$dfp_grandchild = '';
		$ad_unit_path = '';
		if ( is_front_page() ) {
			$ad_unit_path = '/61924087/' .  $parent_inventory  . '/chicago.suntimes.com.index';
		}
		if ( is_singular() || is_author() ) {
			$obj = \CST\Objects\Post::get_by_post_id( get_the_ID() );

			if ( $obj ) {
				$parent_section = $obj->get_primary_parent_section();

				if ( $parent_section ) {
					$dfp_slug = $parent_section->slug;
				}
			}
			$ad_unit_path = '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_slug . '/chicago.suntimes.com.' . $dfp_slug . '.index';
		}
		if ( is_tax() ) {
			$dfp_obj = get_queried_object();
			if ( 'cst_section' === $dfp_obj->taxonomy ) {
				if ( 0 === $dfp_obj->parent ) {
					$dfp_slug = $dfp_obj->slug;
					$ad_unit_path = '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_slug . '/chicago.suntimes.com.' . $dfp_slug . '.index';
				} else {
					$dfp_parent = $dfp_obj->parent;
					$dfp_term   = get_term( $dfp_parent, 'cst_section' );
					$dfp_slug 	= $dfp_term->slug;
					if ( 0 !== $dfp_term->parent ) {
						$dfp_parent_term   	= get_term( $dfp_term->parent, 'cst_section' );
						if ( 0 === $dfp_parent_term->parent ) {
							$dfp_parent 		= $dfp_parent_term->slug;
							$dfp_child 			= $dfp_term->slug;
							$dfp_grandchild 	= str_replace( '-', '', $dfp_obj->slug );
							$ad_unit_path = '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild;
						} else {
							$ad_unit_path = '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_slug . '/chicago.suntimes.com.' . $dfp_slug . '.index';
						}
					} else {
						$dfp_parent = $dfp_term->slug;
						$dfp_child  = $dfp_obj->slug;
						$ad_unit_path = '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child;
					}
				}
			}
		}
		?>
<script>/* <![CDATA[ */
var dfp = {
	"account_id":"/61924087/",
	"front_page": <?php echo wp_json_encode( is_front_page() ); ?>,
	"section": <?php echo wp_json_encode( is_tax( 'cst_section' ) ); ?>,
	"article": <?php echo wp_json_encode( is_singular() ); ?>,
	"search": <?php echo wp_json_encode( is_search() ); ?>,
	"fourohfour": <?php echo wp_json_encode( is_404() ); ?>,
	"author": <?php echo wp_json_encode( is_author() ); ?>,
	"gallery": <?php echo wp_json_encode( is_singular( 'cst_gallery' ) ); ?>,
	"parent_inventory":<?php echo wp_json_encode( $parent_inventory . '/chicago.suntimes.com.index' ); ?>,
	"parent" : <?php echo wp_json_encode( $dfp_parent ); ?>,
	"child" : <?php echo wp_json_encode( $dfp_child ); ?>,
	"slug" : <?php echo wp_json_encode( $dfp_slug ); ?>,
	"grandchild" : <?php echo wp_json_encode( $dfp_grandchild ); ?>,
	"adunitpath" : <?php echo wp_json_encode( $ad_unit_path ); ?>
};
/* ]]> */
</script>
		<?php
	}

	/**
	 * Generate dfp position definitions, sizes, call DFP
	 * and enjoy the rest of the page
	 */
	public function generate_header_definitions() {

		if ( is_page_template( 'page-monster.php' ) ) {
			return;
		}
			?>
<script type='text/javascript'>
  var adUnitPath = dfp.adunitpath;
  var article_skyscraper_mapping, article_lead_unit_mapping, article_cube_mapping, sf_mapping, sf_inline_mapping, article_mapping, sf_super_leaderboard_mapping, super_leaderboard_mapping, hp_upper_super_leaderboard_mapping, gallery_cube_mapping, hp_cube_mapping, article_leaderboard_mapping, hp_ear_mapping;
  var googletag = googletag || {};
  googletag.cmd = googletag.cmd || [];
  var CSTAdTags = {};
  googletag.cmd.push(function () {
    article_lead_unit_mapping = googletag.sizeMapping()
      .addSize([1025, 0], [728, 90]) //desktop
	  .addSize([800, 1200], [ [320, 50] ] ) //tablet
	  .addSize([800, 1280], [ [320, 50] ] ) //tablet
	  .addSize([768, 1024], [ [320, 50] ] ) //tablet
      .addSize([0, 0], [[320, 50],[300,50]]) //other
	  .build();
    super_leaderboard_mapping = googletag.sizeMapping().
    addSize([1200, 800], [ [970,90], [728,90] ] ). //tablet
    addSize([1025, 0], [728, 90]). //desktop
    addSize([992, 0], [ [970, 90], [728, 90] ] ). //desktop
    addSize([1024, 768], [ [320, 50], [300, 50] ] ). //tablet
    addSize([800, 1200], [ [320, 50], [300, 50] ] ). //tablet
    addSize([768, 1024], [ [320, 50], [300, 50] ] ). //tablet
    addSize([640, 480], [[320, 50], [300, 50]]). //phone
    addSize([414, 0], [[320, 50], [300, 50]]). //phone
    addSize([375, 667], [[320, 50], [300, 50]]). //phone
    addSize([0, 0], [[320, 50], [300, 50]]). //other
    build();
    hp_upper_super_leaderboard_mapping = googletag.sizeMapping().
    addSize([1200, 800], [ [970, 250], [970,90], [728,90] ] ). //tablet
    addSize([992, 0], [ [970, 250], [970, 90], [728, 90] ] ). //desktop
    addSize([800, 1200], [ [728,90] ] ). //tablet
    addSize([768, 1024], [ [728,90] ] ). //tablet
    addSize([640, 480], [[320, 50], [300, 50]]). //phone
    addSize([414, 0], [[320, 50], [300, 50]]). //phone
    addSize([375, 667], [[320, 50], [300, 50]]). //phone
    addSize([0, 0], [[320, 50], [300, 50]]). //other
	  build();
    sf_super_leaderboard_mapping = googletag.sizeMapping().
    addSize([1200, 800], [ [970, 250], [970,90], [728,90] ] ). //tablet
    addSize([992, 0], [ [970, 250], [970, 90], [728, 90] ] ). //desktop
    addSize([800, 1200], [ [728,90] ] ). //tablet
    addSize([768, 1024], [ [728,90] ] ). //tablet
    addSize([640, 480], [[320, 50], [300, 50]]). //phone
    addSize([414, 0], [[320, 50], [300, 50]]). //phone
    addSize([375, 667], [[320, 50], [300, 50]]). //phone
    addSize([0, 0], [[320, 50], [300, 50]]). //other
	  build();
    article_cube_mapping = googletag.sizeMapping()
      .addSize([0, 0], []) //other
	  .addSize([1025, 0], [[300, 600], [300, 250]]) //desktop
	  .build();
    article_skyscraper_mapping = googletag.sizeMapping()
      .addSize([0, 0], []) //other
	  .addSize([1025, 0], [[160,600]]) //desktop
	  .build();
    hp_ear_mapping = googletag.sizeMapping()
      .addSize([0, 0], []) //other
	  .addSize([992, 0], [[184,90]]) //desktop
	  .build();
    hp_cube_mapping = googletag.sizeMapping()
	  .addSize([1025, 0], [[300, 600]]) //desktop
	  .addSize([768,1024], [[300, 600]]) //desktop no sidebar
	  .addSize([768, 0], [[300, 600]]) //desktop
	  .addSize([732, 0], [[300, 250]]) //mobile device
	  .addSize([640, 480], [[320, 50], [300, 50]]) //phone
	  .addSize([375, 667], [[320, 50], [300, 50]]) //phone
	  .addSize([0, 0], [[300, 50], [320, 50]])
	  .build();
    gallery_cube_mapping = googletag.sizeMapping()
      .addSize([0, 0], []) //other
	  .addSize([1025, 0], [[300, 250]]) //desktop
	  .build();
    article_mapping = googletag.sizeMapping().
    addSize([992, 0], [ [728, 90] ] ). //desktop
    addSize([800, 1200], [ [728,90] ] ). //tablet
    addSize([768, 1024], [ [728,90] ] ). //tablet
    addSize([640, 480], [[300, 50], [320, 50]]). //phone
    addSize([375, 667], [[300, 50], [320, 50]]). //phone
    addSize([0, 0], [[300, 50], [320, 50]]). //other
    build();
    article_leaderboard_mapping = googletag.sizeMapping().
    addSize([992, 0], [ [728, 90] ] ). //desktop
    addSize([800, 1200], [ [728,90] ] ). //tablet
    addSize([768, 1024], [ [728,90] ] ). //tablet
    addSize([640, 480], [[320, 50], [300, 50]]). //phone
    addSize([375, 667], [[320, 50], [300, 50]]). //phone
    addSize([0, 0], [320, 50], [300, 50]). //other
    build();
    sf_mapping = googletag.sizeMapping()
      .addSize([0, 0], []) //other
	  .addSize([992, 0], [[300, 600], [300, 250]]) //desktop
      .addSize([768, 0], [[300, 600], [300, 250]]) //tablet
      .build();
    sf_inline_mapping = googletag.sizeMapping()
      .addSize([992, 0], [[300, 250]]) //desktop
      .addSize([768, 0], [[300, 250]]) //tablet
      .addSize([640, 0], [[300, 250], [320, 50]]) //phone
      .addSize([414, 0], [[300, 250], [320, 50]]) //phone
      .addSize([375, 0], [[300, 250], [320, 50]]) //phone
      .addSize([0, 0], [320, 50]) //other
      .build();
    if (dfp.front_page) {
      googletag.defineSlot(adUnitPath, [[2, 2], [970, 90]], 'div-gpt-sbb-1')
        .addService(googletag.pubads())
        .setTargeting("pos", "sbb")
        .setCollapseEmptyDiv(true, true);
      googletag.defineSlot(adUnitPath, [[728, 90]], 'div-gpt-super-leaderboard-3')
        .defineSizeMapping(super_leaderboard_mapping)
        .addService(googletag.pubads())
        .setTargeting("pos", "Super Leaderboard 3")
        .setCollapseEmptyDiv(true, true);
      googletag.defineSlot(adUnitPath, [[728, 90]], 'div-gpt-super-leaderboard-4')
        .defineSizeMapping(super_leaderboard_mapping)
        .addService(googletag.pubads())
        .setTargeting("pos", "Super Leaderboard 4")
        .setCollapseEmptyDiv(true, true);
      googletag.defineSlot(adUnitPath, [[728, 90]], 'div-gpt-super-leaderboard-5')
        .defineSizeMapping(super_leaderboard_mapping)
        .addService(googletag.pubads())
        .setTargeting("pos", "Super Leaderboard 5")
        .setCollapseEmptyDiv(true, true);
        googletag.defineSlot(adUnitPath, [184, 90], 'div-gpt-sponsor-ear-left')
          .defineSizeMapping(hp_ear_mapping)
          .addService(googletag.pubads()).setTargeting("pos", "Sponsor Ear Left")
          .setCollapseEmptyDiv(true, true);
        googletag.defineSlot(adUnitPath, [184, 90], 'div-gpt-sponsor-ear-right')
          .defineSizeMapping(hp_ear_mapping)
          .addService(googletag.pubads()).setTargeting("pos", "Sponsor Ear Right")
          .setCollapseEmptyDiv(true, true);
    }
    if (dfp.author) {
      googletag.defineSlot(adUnitPath, [ [728, 90] ], 'div-gpt-super-leaderboard-2')
        .defineSizeMapping(super_leaderboard_mapping)
        .addService(googletag.pubads())
        .setTargeting("pos", "Super leaderboard 2 970x90")
        .setCollapseEmptyDiv(true, true);
    }
    if (dfp.search||dfp.fourohfour||dfp.article) {
      googletag.defineSlot(adUnitPath, [[728, 90]], 'div-gpt-atf-leaderboard-1')
        .defineSizeMapping(article_leaderboard_mapping)
        .addService(googletag.pubads())
        .setTargeting("pos", "atf leaderboard");
    }
    if (dfp.article) {
      CSTAdTags['div-gpt-sky-scraper-1'] = googletag.defineSlot(adUnitPath, [160, 600], 'div-gpt-sky-scraper-1')
		.defineSizeMapping(article_skyscraper_mapping)
		.addService(googletag.pubads())
		.setTargeting("pos", "SkyScraper");
    }
    if(dfp.gallery) {
      CSTAdTags['div-gpt-gallery-1'] = googletag.defineSlot(adUnitPath, [300, 250], 'div-gpt-gallery-1')
        .addService(googletag.pubads())
		.defineSizeMapping(gallery_cube_mapping)
        .setTargeting("pos","gallery 1");
    }
    googletag.pubads().enableSingleRequest();
    window.CSTAds = window.CSTAds || false;
    if (window.CSTAds) {
      googletag.pubads().addEventListener('slotVisibilityChanged', CSTAds.handleGptVisibility);
      googletag.pubads().addEventListener('impressionViewable', CSTAds.handleGptImpressionViewability);
	}
    googletag.enableServices();
});

</script>
<?php
	}

	/**
	 * @return string
	 *
	 * Better determination of DFP ad inventory to use
	 * Defaults to production ad delivery
	 */
	public function get_parent_dfp_inventory() {
		$pathname = explode( '//', get_bloginfo( 'url' ) );
		switch ( $pathname[1] ) {
			case 'dev.suntimes.com':
			case 'suntimesmediapreprod.wordpress.com':
			case 'vip.local':
			case 'vagrant.local':
				$parent_inventory = 'chicago.suntimes.com.test';
				break;
			case 'chicago.suntimes.com':
			case 'suntimesmedia.wordpress.com':
				$parent_inventory = 'chicago.suntimes.com';
				break;
			default:
				$parent_inventory = 'chicago.suntimes.com';
		}
		return $parent_inventory;
	}
}

$dfp_handler = new CST_DFP_Handler();
