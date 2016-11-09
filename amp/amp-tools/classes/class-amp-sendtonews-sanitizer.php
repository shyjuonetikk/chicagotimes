<?php

/**
 * Class CST_AMP_Send_To_News_Sanitizer
 *
 * Basic sanitizer functionality for Send To News video embeds
 *
 */
class CST_AMP_Send_To_News_Sanitizer extends AMP_Base_Sanitizer {

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
		$divs = $this->dom->getElementsByTagName( 'div' );
		$divtoo = $divs->item( 1 );
		if ( null !== $divtoo ) {
			$player_id = $divtoo->getAttribute( 'data-pid' );
			return $player_id;
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