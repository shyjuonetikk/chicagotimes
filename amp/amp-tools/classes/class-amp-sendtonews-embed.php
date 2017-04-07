<?php
/**
 * Class CST_AMP_Send_To_News_Embed
 *
 * Basic embed functionality for Send To News video embeds
 * Includes legacy video player for AMP and related embed code mapping
 *
 */
class CST_AMP_Send_To_News_Embed extends AMP_Base_Embed_Handler {
	private static $script_slug = 'amp-iframe';
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
	public function cst_build_send_to_news_element( $content ) {

		$obj = new CST\Objects\Article( get_the_ID() );
		$media_type = $obj->get_featured_media_type();
		if ( 'video' === $media_type ) {
			$player_id = $obj->get_featured_video_script();
			$this->did_convert_elements = true;
			return $content . $this->render( array( 'player_id' => $player_id ) );
		} else {
			return $content;
		}

	}

	public function render( $args ) {

		$args = wp_parse_args( $args, array(
			'player_id' => false,
		) );

		if ( empty( $args['player_id'] ) ) {
			return '';
		}

		$b = AMP_HTML_Utils::build_tag(
			'iframe',
			array(
				'href'   => esc_url( 'http://embed.sendtonews.com/player2/embedcode.php?type=full&fk=' . $args['player_id'] . '&cid=4661' ),
				'height' => '400',
				'frameborder' => '0',
				'scrolling' => 'no',
				'sandbox' => 'allow-scripts allow-same-origin allow-popups',
				'layout' => 'responsive',
			)
		);
		return $b;
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
