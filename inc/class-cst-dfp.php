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
	 *
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
<div id="%1$s" class="%2$s" data-visual-label="%3$s"></div>
',
			esc_attr( $type . '-' . intval( $index ) ),
			esc_attr( $class ),
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
}

$dfp_handler = new CST_DFP_Handler();
