<?php
/**
 * Class CST_AMP_Send_To_News_Sanitizer
 *
 * Basic sanitizer functionality for Send To News video embeds
 * Includes legacy video player for AMP and related embed code mapping
 *
 */
class CST_AMP_Send_To_News_Sanitizer extends AMP_Base_Sanitizer {
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
	public function sanitize() {
		// Empty as the script below looks for HTML element with ID that is
		// returned by class-article.php
	}
	/**
	 * @return mixed
	 *
	 * Find player id from html / dom being processed
	 */
	private function get_player_id() {
		$xp = new DOMXPath( $this->dom );
		$player_div = $xp->query('//span[contains(concat(" ", normalize-space(@class), " "), " s2nlegacy ")]');
		if ( $player_div ) {
			$player_present = $player_div->item(0);
			if ( null !== $player_present ) {
				if ( $player_div->item( 0 )->hasAttribute( 'data-video-id' ) ) {
					$player_id = $player_div->item( 0 )->getAttribute( 'data-video-id' );
					return $this->send_to_news_embeds_map[ $player_id ];
				}
			}
		} else {
			return false;
		}
	}
	/**
	 * @return array
	 *
	 * Inject custom script the AMP way
	 */
	public function get_scripts() {
		$player_id = $this->get_player_id();
		if ( $player_id ) {
			return array( 'http://embed.sendtonews.com/player2/embedcode.php?type=full&fk=' . $player_id . '&cid=4661' );
		} else {
			return array();
		}
	}
}
