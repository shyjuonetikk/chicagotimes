<?php

/**
 * Slack API support for CST WordPress theme
 *
 * Monitor save event on cst_articles and upon publish
 * craft and perform Slack API notifications to payload url
 */

class CST_Slack {

	private $payload_url = 'https://hooks.slack.com/services/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';

	private static $instance;

	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new CST_Slack();
		}
		return self::$instance;
	}
	public function __construct() {
		$this->setup_actions();
	}

	public function setup_actions() {
		add_action( 'save_post_cst_article', array( $this, 'new_content_payload' ), 10, 3 );
	}

	/**
	 * @param $post_id
	 * @param $post
	 * @param $update
	 * 
	 * Share newly published (not updated) content to Slack channel
	 */
	public function new_content_payload( $post_id, $post, $update ) {

		if ( $update ) {
			return;
		}
		if ( 'publish' === $post->post_status ) {
			$payload = $this->new_content_payload_to_json( $post_id, $post );
			$this->send_payload( array(
				'body' => $payload,
			) );
		}
	}

	function send_payload( $payload ) {
		$headers = array(
			'content-type' => 'application/json',
		);
		wp_safe_remote_post( $this->payload_url, array(
			'body' => $payload['body'],
			'headers' => $headers,
		));

	}
	/**
	 * @param $post_id
	 * @param $post
	 * @param bool $update
	 *
	 * @return mixed|string|void
	 * 
	 * Craft Slack API body payload and return json_encoded
	 */
	public function new_content_payload_to_json( $post_id, $post ) {

		$obj                  = new \CST\Objects\Article( $post_id );
		$author               = $this->get_author( $obj );
		$attachment_thumb_url = '';
		if ( has_post_thumbnail( $post_id ) ) {
			$attachment_thumb_id = get_post_thumbnail_id( $post_id );
			$attachment_thumb_url = wp_get_attachment_thumb_url( $attachment_thumb_id );
		}
		$payload['text']        = 'New content';
		$payload['attachments'] = array(
			array(
				'text'        => esc_html( wp_trim_words( $post->post_content, 20 ) . "\n" ),
				'pretext'     => esc_attr( get_the_excerpt( $post_id ) ),
				'fallback'    => wp_strip_all_tags( get_the_title( $post_id ) ),
				'thumb_url'   => $attachment_thumb_url,
				'image_url'   => $attachment_thumb_url,
				'color'       => '#222222',
				'author_name' => 'Author: ' . $author,
				'title'       => htmlentities2( get_the_title( $post_id ) ),
				'title_link'  => esc_url( wp_get_shortlink( $post_id ) ),
				'footer'      => 'Chicago Sun-Times API',
				'footer_icon' => esc_url( get_stylesheet_directory_uri() ) . '/assets/images/favicons/favicon-16x16.png',
				'ts'          => time(),
			),
		);
		$payload['unfurl_links'] = true;
		$payload['unfurl_media'] = true;
		return json_encode( $payload );
	}

	/**
	 * @param $obj
	 *
	 * @return mixed
	 * Get and return an author name
	 */
	public function get_author( $obj ) {
		$authors     = $obj->get_authors();
		$author_data = $authors[0];
		$author      = $author_data->get_display_name();

		return $author;
	}
}

$cst_slack = new CST_Slack();
