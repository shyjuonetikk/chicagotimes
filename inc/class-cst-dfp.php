<?php

/**
 * Class CST_DFP_Handler
 *
 * Basic centralized handler to generate and return the
 * markup for DFP ad divs
 */
class CST_DFP_Handler {

	private static $instance;

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
	 * @param int $deprecated
	 *
	 * @return string
	 *
	 * Create a generic markup unit
	 */
	public function unit( $index, $type = '', $class = '', $deprecated = 640 ) {
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
<div id="%1$s" class="%2$s" data-visual-label="%3$s">
<script>
	googletag.cmd.push(function() {
		googletag.display("%4$s");
	})
</script>
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
	 * @return string
	 *
	 * Create a custom interstitial unit
	 */
	public function interstitial( ) {

		if ( ! isset( $index ) ) {
			$index = 1;
		}

		return sprintf(
			'
<div id="%1$s" class="%2$s">
	<div id="dfp-interstitial-container">
		<div class="dfp-interstitial-headerbar">
			<a id="dfp-interstitial-close"></a>
		</div>
		<div id="dfp-interstitial-content"></div>
	</div>
</div>
',
			esc_attr( 'div-gpt-interstitial' ),
			esc_attr( 'dfp dfp-centered show-for-medium-up dfp-interstitial' )
		);
	}

	/**
	 * Determine content location and inject the settings for DFP
	 * into the markup
	 */
	public function ad_header_settings() {
		$parent_inventory = $this->get_parent_dfp_inventory();
		$dfp_slug         = 'news';
		$dfp_parent = '';
		$dfp_child = '';
		$dfp_grandchild = '';
		$ad_unit_path = '';
		if ( is_front_page() ) {
			$ad_unit_path = '/61924087/' .  $parent_inventory  . '/chicago.suntimes.com.index';
		}
		if ( is_singular() ) {
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
  var googletag = googletag || {};
  googletag.cmd = googletag.cmd || [];
  var CSTAdTags = {};
  googletag.cmd.push(function () {
    var billboard_mapping = googletag.sizeMapping().
    addSize([1200, 800], [ [970,90], [728,90], [300, 50], [320, 50] ] ). //tablet
    addSize([992, 0], [ [728, 90], [970, 90] ] ). //desktop
    addSize([800, 1200], [ [728,90], [300, 50], [320, 50] ] ). //tablet
    addSize([768, 1024], [ [728,90], [300, 50], [320, 50] ] ). //tablet
    addSize([640, 480], [300, 50], [320, 50]). //phone
    addSize([375, 667], [300, 50], [320, 50]). //phone
    addSize([0, 0], [300, 50], [320, 50]). //other
    build();
    var cube_mapping = googletag.sizeMapping()
	  .addSize([992, 0], [[300, 250]]) //desktop
	  .addSize([768, 0], [[300, 250]]) //tablet
	  .addSize([640, 480], [300, 250]) //phone
	  .addSize([375, 667], [300, 250]) //phone
	  .addSize([0, 0], [320, 50], [300, 50]) //other
	  .build();
    googletag.defineSlot(adUnitPath, [1, 1], 'div-gpt-interstitial')
      .addService(googletag.pubads()).setTargeting("pos", "1x1");
    googletag.defineSlot(adUnitPath, [[300, 250], [300, 600]], 'div-gpt-rr-cube-1')
      .addService(googletag.pubads()).setTargeting("pos", "rr cube 1");
    googletag.defineSlot(adUnitPath, [[300, 250]], 'div-gpt-rr-cube-2')
      .addService(googletag.pubads()).setTargeting("pos", "rr cube 2");
    googletag.defineSlot(adUnitPath, [[300, 250]], 'div-gpt-rr-cube-3')
      .addService(googletag.pubads()).setTargeting("pos", "rr cube 3");
    if (dfp.front_page) {
      googletag.defineSlot(adUnitPath, [[970, 250], [970, 90], [970, 415], [728, 90]], 'div-gpt-billboard-2')
        .defineSizeMapping(billboard_mapping)
        .addService(googletag.pubads())
        .setTargeting("pos", "Billboard 2 970x250")
        .setCollapseEmptyDiv(true, true);
      googletag.defineSlot(adUnitPath, [[728, 90]], 'div-gpt-super-leaderboard-3')
        .defineSizeMapping(billboard_mapping)
        .addService(googletag.pubads())
        .setTargeting("pos", "Super Leaderboard 3")
        .setCollapseEmptyDiv(true, true);
      googletag.defineSlot(adUnitPath, [[728, 90]], 'div-gpt-super-leaderboard-4')
        .defineSizeMapping(billboard_mapping)
        .addService(googletag.pubads())
        .setTargeting("pos", "Super Leaderboard 4")
        .setCollapseEmptyDiv(true, true);
      googletag.defineSlot(adUnitPath, [[728, 90]], 'div-gpt-super-leaderboard-5')
        .defineSizeMapping(billboard_mapping)
        .addService(googletag.pubads())
        .setTargeting("pos", "Super Leaderboard 5")
        .setCollapseEmptyDiv(true, true);
      googletag.defineSlot(adUnitPath, [300, 250], 'div-gpt-rr-cube-7')
        .addService(googletag.pubads()).setTargeting("pos", "rr cube 7");
      if (window.innerWidth > 1256) {
        googletag.defineSlot(adUnitPath, [184, 90], 'div-gpt-sponsor-ear-left')
          .addService(googletag.pubads()).setTargeting("pos", "Sponsor Ear Left")
          .setCollapseEmptyDiv(true, true);
        googletag.defineSlot(adUnitPath, [184, 90], 'div-gpt-sponsor-ear-right')
          .addService(googletag.pubads()).setTargeting("pos", "Sponsor Ear Right")
          .setCollapseEmptyDiv(true, true);
      }
    }
    if (dfp.front_page || dfp.section) {
      googletag.defineSlot(adUnitPath, [[2, 2], [970, 90]], 'div-gpt-sbb-1')
        .addService(googletag.pubads()).setTargeting("pos", "sbb");
      googletag.defineSlot(adUnitPath, [320, 50], 'div-gpt-mobile-leaderboard')
        .addService(googletag.pubads()).setTargeting("pos", "mobile leaderboard")
        .setCollapseEmptyDiv(true, true);
      googletag.defineSlot(adUnitPath, [[970, 250], [970, 90], [970, 415], [728, 90]], 'div-gpt-billboard-1')
        .defineSizeMapping(billboard_mapping)
        .addService(googletag.pubads())
        .setTargeting("pos", "Billboard 970x250")
        .setCollapseEmptyDiv(true, true);
    }
    if (dfp.section) {
      googletag.defineSlot(adUnitPath, [[970, 90], [728, 90]], 'div-gpt-super-leaderboard-2')
        .addService(googletag.pubads())
        .setTargeting("pos", "Super leaderboard 2 970x90")
        .setCollapseEmptyDiv(true, true);
    }
    if (dfp.section || dfp.article) {
      googletag.defineSlot(adUnitPath, [[300, 250], [300, 600]], 'div-gpt-rr-cube-5')
        .addService(googletag.pubads()).setTargeting("pos", "rr cube 5");
      googletag.defineSlot(adUnitPath, [[300, 250], [300, 600]], 'div-gpt-rr-cube-6')
        .addService(googletag.pubads()).setTargeting("pos", "rr cube 6");
    }
    if (dfp.article) {
      googletag.defineSlot(adUnitPath, [[728, 90]], 'div-gpt-atf-leaderboard-1')
        .addService(googletag.pubads())
        .setTargeting("pos", "atf leaderboard");
      CSTAdTags['div-gpt-sky-scraper-1'] = googletag.defineSlot(adUnitPath, [160, 600], 'div-gpt-sky-scraper-1')
        .addService(googletag.pubads())
        .setTargeting("pos", "SkyScraper");
      CSTAdTags['div-gpt-ym-craig'] = googletag.defineSlot(adUnitPath, [300, 250], 'div-gpt-ym-craig')
        .addService(googletag.pubads())
        .setTargeting("pos","ym craig")
        .setCollapseEmptyDiv(true,true);
    }
    if(dfp.gallery) {
      CSTAdTags['div-gpt-gallery-1'] = googletag.defineSlot(adUnitPath, [300, 250], 'div-gpt-gallery-1')
        .addService(googletag.pubads())
        .setTargeting("pos","gallery 1");
      CSTAdTags['div-gpt-gallery-2'] = googletag.defineSlot(adUnitPath, [300, 250], 'div-gpt-gallery-2')
        .addService(googletag.pubads())
        .setTargeting("pos","gallery 2");
      CSTAdTags['div-gpt-gallery-3'] = googletag.defineSlot(adUnitPath, [300, 250], 'div-gpt-gallery-3')
        .addService(googletag.pubads())
        .setTargeting("pos","gallery 3");
      CSTAdTags['div-gpt-gallery-4'] = googletag.defineSlot(adUnitPath, [300, 250], 'div-gpt-gallery-4')
        .addService(googletag.pubads())
        .setTargeting("pos","gallery 4");
    }
    googletag.pubads().enableSingleRequest();
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
		$current_site_url = get_bloginfo( 'url' );
		switch ( $current_site_url ) {
			case 'http://dev.suntimes.com':
			case 'https://suntimesmediapreprod.wordpress.com':
			case 'http://vip.local':
				$parent_inventory = 'chicago.suntimes.com.test';
				break;
			case 'http://chicago.suntimes.com':
			case 'https://suntimesmedia.wordpress.com':
				$parent_inventory = 'chicago.suntimes.com';
				break;
			default:
				$parent_inventory = 'chicago.suntimes.com';

		}
		return $parent_inventory;
	}
}

$dfp_handler = new CST_DFP_Handler();
