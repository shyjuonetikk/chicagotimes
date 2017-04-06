<?php
/**
 * Class CST_AMP_Send_To_News_Embed
 *
 * Basic sanitizer functionality for Send To News video embeds
 * Includes legacy video player for AMP and related embed code mapping
 *
 */
class CST_AMP_Send_To_News_Embed extends AMP_Base_Embed_Handler {
	private static $script_slug = 'amp-frame';
	private static $script_src = 'https://cdn.ampproject.org/v0/amp-iframe-0.1.js';
	private $send_to_news_embeds_map = array(
		'xXrmaE8c'=> 'uqWfqG2Y',
		'TR8jtM5y'=> 'WOOeQ5Jw',
		'oags2xgZ' => 's3AyJdaz',
		'L9X2Tt4y'=> 'C30fZO7v',
		'a7k31LHx'=> '8Owdfvnq',
		'L0muW63f'=> 'hdUJ4uMz',
		'udXbWp8Y'=> 'dAT6rZV6',
		'SRHLAr2T'=> 'IS3jNqMB',
		'fLPoOgHI'=> 'BQ3NYJzd',
		'uy7k8sat'=> 'idn8h9Kj',
	);
	public function register_embed() {
		// Add our new callback
		add_filter( 'the_content', array( $this, 'cst_build_send_to_news_element' ) );
	}

	public function unregister_embed() {
		remove_filter( 'the_content', array( $this, 'cst_build_send_to_news_element' ) );
	}
	/**
	 * @return mixed
	 *
	 * Find player id from html / dom being processed
	 */
	private function cst_build_send_to_news_element() {
		$xp = new DOMXPath( $this->dom );
		$player_div = $xp->query('//span[contains(concat(" ", normalize-space(@class), " "), " s2nlegacy ")]');
		if ( $player_div ) {
			$player_present = $player_div->item(0);
			if ( null !== $player_present ) {
				if ( $player_div->item( 0 )->hasAttribute( 'data-video-id' ) ) {
					$player_id = $player_div->item( 0 )->getAttribute( 'data-video-id' );
					$this->did_convert_elements = true;
					return $this->render( $this->send_to_news_embeds_map[ $player_id ] );
				}
			}
		} else {
			return false;
		}
	}

	public function render( $args ) {
		$args = wp_parse_args( $args, array(
			'images' => false,
		) );

		if ( empty( $args['images'] ) ) {
			return '';
		}

		return AMP_HTML_Utils::build_tag(
			'amp-iframe',
			array(
				'width'  => $this->args['width'],
				'height' => $this->args['height'],
				'type'   => 'slides',
				'layout' => 'responsive',
				'class'  => 'cst-amp-carousel',
			),
			implode( PHP_EOL, $images )
		);
	}
		/**
	 * @return array
	 *
	 * Inject custom script the AMP way
	 */

	public function get_scripts() {
		if ( ! $this->did_convert_elements ) {
			return array();
		}

		return array( self::$script_slug => self::$script_src );
	}
}
