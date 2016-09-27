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

	public function generate_header_definitions() {

		$parent_inventory = $this->get_dfp_inventory();
		if ( is_front_page() ) {
			$inventory = '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index';
			?>
<script type='text/javascript'>
	var mapping = googletag.sizeMapping().
	addSize([1024, 768], [970, 250]).
	addSize([980, 690], [728, 90]).
	addSize([640, 480], [320, 50]).
	addSize([0, 0], [88, 31]).
	// Fits browsers of any size smaller than 640 x 480
	build();
	googletag.cmd.push(function () {

		googletag.defineSlot(<?php echo wp_json_encode( $inventory ); ?>, [1, 1], 'div-gpt-interstitial')
			.addService(googletag.pubads()).setTargeting("pos", "1x1");
		googletag.defineSlot(<?php echo wp_json_encode( $inventory ); ?>, [728, 90], 'div-gpt-atf-leaderboard')
			.addService(googletag.pubads())
			.setTargeting("pos", "atf leaderboard")
			.defineSizeMapping(mapping);
		googletag.defineSlot(<?php echo wp_json_encode( $inventory ); ?>, [[2, 2], [970, 90]], 'div-gpt-sbb-1')
			.addService(googletag.pubads()).setTargeting("pos", "sbb");
		googletag.defineSlot(<?php echo wp_json_encode( $inventory ); ?>, [[970, 250], [970, 90], [970, 415], [728, 90], [320, 50], [300, 50]], 'div-gpt-billboard-1')
			.addService(googletag.pubads())
			.setTargeting("pos", "Billboard 970x250")
			.setCollapseEmptyDiv(true, true)
			.defineSizeMapping(mapping);
		googletag.defineSlot(<?php echo wp_json_encode( $inventory ); ?>, [[970, 250], [970, 90], [970, 415], [728, 90], [320, 50], [300, 50]], 'div-gpt-billboard-2')
			.addService(googletag.pubads())
			.setTargeting("pos", "Billboard 2 970x250")
			.setCollapseEmptyDiv(true, true)
			.defineSizeMapping(mapping);
		googletag.defineSlot(<?php echo wp_json_encode( $inventory ); ?>, [[970, 90], [728, 90]], 'div-gpt-super-leaderboard-2')
			.addService(googletag.pubads())
			.setTargeting("pos", "Super leaderboard 2 970x90")
			.setCollapseEmptyDiv(true, true)
			.defineSizeMapping(mapping);
		googletag.defineSlot(<?php echo wp_json_encode( $inventory ); ?>, [[970, 90], [728, 90]], 'div-gpt-super-leaderboard-3')
			.addService(googletag.pubads())
			.setCollapseEmptyDiv(true, true)
			.defineSizeMapping(mapping);
		googletag.defineSlot(<?php echo wp_json_encode( $inventory ); ?>, [[970, 90], [728, 90]], 'div-gpt-super-leaderboard-4')
			.addService(googletag.pubads())
			.setCollapseEmptyDiv(true, true)
			.defineSizeMapping(mapping);
		googletag.defineSlot(<?php echo wp_json_encode( $inventory ); ?>, [[970, 90], [728, 90]], 'div-gpt-super-leaderboard-5')
			.addService(googletag.pubads())
			.setCollapseEmptyDiv(true, true)
			.defineSizeMapping(mapping);} else {
		googletag.defineSlot(<?php echo wp_json_encode( $inventory ); ?>, [320, 50], 'div-gpt-mobile-leaderboard')
			.addService(googletag.pubads()).setTargeting("pos", "mobile leaderboard")
			.setCollapseEmptyDiv(true, true);
		googletag.defineSlot(<?php echo wp_json_encode( $inventory ); ?>, [[970, 90], [728, 90]], 'div-gpt-btf-leaderboard')
			.addService(googletag.pubads()).setTargeting("pos", "btf leaderboard")
			.setCollapseEmptyDiv(true, true)
			.defineSizeMapping(mapping);
		googletag.defineSlot(<?php echo wp_json_encode( $inventory ); ?>, [[300, 250], [300, 600]], 'div-gpt-rr-cube-1')
			.addService(googletag.pubads()).setTargeting("pos", "rr cube 1");
		googletag.defineSlot(<?php echo wp_json_encode( $inventory ); ?>, [[300, 250]], 'div-gpt-rr-cube-2')
			.addService(googletag.pubads()).setTargeting("pos", "rr cube 2");
		googletag.defineSlot(<?php echo wp_json_encode( $inventory ); ?>, [[300, 250]], 'div-gpt-rr-cube-3')
			.addService(googletag.pubads()).setTargeting("pos", "rr cube 3");
		googletag.defineSlot(<?php echo wp_json_encode( $inventory ); ?>, [[300, 250]], 'div-gpt-rr-cube-4')
			.addService(googletag.pubads()).setTargeting("pos", "rr cube 4");
		googletag.defineSlot(<?php echo wp_json_encode( $inventory ); ?>, [[300, 250], [300, 600]], 'div-gpt-rr-cube-5')
			.addService(googletag.pubads()).setTargeting("pos", "rr cube 5");
		googletag.defineSlot(<?php echo wp_json_encode( $inventory ); ?>, [[300, 250], [300, 600]], 'div-gpt-rr-cube-6')
			.addService(googletag.pubads()).setTargeting("pos", "rr cube 6");
		googletag.defineSlot(<?php echo wp_json_encode( $inventory ); ?>, [300, 250], 'div-gpt-rr-cube-7')
			.addService(googletag.pubads()).setTargeting("pos", "rr cube 6");
		if (window.innerWidth > 1256) {
			googletag.defineSlot(<?php echo wp_json_encode( $inventory ); ?>, [184, 90], 'div-gpt-sponsor-ear-left')
				.addService(googletag.pubads()).setTargeting("pos", "Sponsor Ear Left")
				.setCollapseEmptyDiv(true, true);
			googletag.defineSlot(<?php echo wp_json_encode( $inventory ); ?>, [184, 90], 'div-gpt-sponsor-ear-right')
				.addService(googletag.pubads()).setTargeting("pos", "Sponsor Ear Right")
				.setCollapseEmptyDiv(true, true);
		}
		googletag.pubads().enableSingleRequest();
		googletag.enableServices();
});
</script>
<?php
		}
	}

	public function get_dfp_inventory() {
		$current_site_url = get_bloginfo( 'url' );
		if ( $current_site_url !== 'http://chicago.suntimes.com' ) {
			$parent_inventory = 'chicago.suntimes.com.test';
		} else {
			$parent_inventory = 'chicago.suntimes.com';
		}
		return $parent_inventory;
	}
}

$dfp_handler = new CST_DFP_Handler();
