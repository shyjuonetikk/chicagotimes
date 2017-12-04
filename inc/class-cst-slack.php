<?php

/**
 * Slack API support for CST WordPress theme
 *
 * Monitor save event on cst_articles and upon publish
 * craft and perform Slack API notifications to payload url
 */

class CST_Slack {

	private $payload_url                  = 'https://hooks.slack.com/services/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';
	private $api_notification_payload_url = 'https://hooks.slack.com/services/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';
	private $dev_team_test_channel        = 'https://hooks.slack.com/services/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';

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
		// Work from transition_post_status action (vs save_post) to better handle
		// newly published content vs just updated
		add_action( 'transition_post_status', array( $this, 'new_content_payload' ), 10, 3 );
	}

	/**
	 * @param $post
	 * @param $old_status
	 * @param $new_status
	 *
	 * Share newly published (not updated) content to Slack channel
	 */
	public function new_content_payload( $new_status, $old_status, $post ) {

		if ( 'publish' === $old_status ) {
			return;
		}

		if ( defined( 'WP_DEBUG' ) ) {
			if ( true === WP_DEBUG ) {
				return;
			}
		}

		if ( 'publish' === $new_status ) {
			if ( 'cst_article' === $post->post_type ) {
				$payload = $this->new_content_payload_to_json( $post->ID, $post );
				if ( false !== $payload ) {
					$this->send_payload( array(
						'body' => $payload,
					), $this->payload_url );
				}
			}
		}
	}

	/**
	 * @param array                         $response
	 * @param \WP_Post|\CST\Objects\Article $obj
	 * @param string                        $vendor
	 */
	public function notify_development_team_error( $response, $obj, $vendor ) {
		$error_message        = wp_remote_retrieve_response_message( $response );
		$response_code        = wp_remote_retrieve_response_code( $response );
		$notification_message = $vendor . ': "' . $obj->get_title() . '" updated with this response ' . $response_code . ' and message ' . $error_message;
		$slack_parameters     = [
			'text'         => $notification_message,
			'unfurl_links' => false,
			'unfurl_media' => false,
		];
		$payload              = $this->new_content_payload_to_json( $obj->ID, $obj, $slack_parameters );
		if ( false !== $payload ) {
			$this->send_payload( [
				'body' => $payload,
			], $this->dev_team_test_channel );
		}
	}
	/**
	 * @param \WP_Post|\CST\Objects\Article $post
	 *
	 * Send a notification to Slack that an item has been updated and
	 * a spider request has been triggered with Sailthru.
	 */
	public function updated_content_to_sailthru( $post ) {
		$obj              = new \CST\Objects\Article( $post->ID );
		$slack_parameters = [
			'text'         => 'Content updated - Sailthru notified to re-spider',
			'unfurl_links' => false,
			'unfurl_media' => false,
		];
		if ( 'cst_article' === $obj->get_post_type() ) {
			$payload = $this->new_content_payload_to_json( $post->ID, $post, $slack_parameters );
			if ( false !== $payload ) {
				$this->send_payload( [
					'body' => $payload,
				], $this->dev_team_test_channel );
			}
		}
	}
	/**
	 * @param $payload
	 * @param $payload_url
	 *
	 * Send json payload to Slack
	 */
	function send_payload( $payload, $payload_url ) {
		$headers = array(
			'content-type' => 'application/json',
		);
		wp_safe_remote_post( $payload_url, array(
			'body'    => $payload['body'],
			'headers' => $headers,
		));

	}
	/**
	 * @param $post_id
	 * @param $post
	 * @param array $slack_parameters
	 *
	 * @return mixed|string
	 *
	 * Craft Slack API body payload and return json_encoded
	 */
	public function new_content_payload_to_json( $post_id, $post, $slack_parameters = [] ) {

		$defaults             = [
			'text'         => 'Story published',
			'unfurl_links' => true,
			'unfurl_media' => true,
		];
		$payload              = array_merge( $defaults, $slack_parameters );
		$obj                  = new \CST\Objects\Article( $post_id );
		$author               = $this->get_author( $obj );
		$attachment_thumb_url = '';
		if ( has_post_thumbnail( $post_id ) ) {
			$attachment_thumb_id  = get_post_thumbnail_id( $post_id );
			$attachment_thumb_url = wp_get_attachment_thumb_url( $attachment_thumb_id );
		}
		$payload['attachments'] = array(
			array(
				'text'        => html_entity_decode( wp_trim_words( $post->post_content, 20 ) . "\n" ),
				'pretext'     => html_entity_decode( get_the_excerpt( $post_id ) ),
				'fallback'    => wp_strip_all_tags( get_the_title( $post_id ) ),
				'thumb_url'   => $attachment_thumb_url,
				'image_url'   => $attachment_thumb_url,
				'color'       => '#000',
				'title'       => html_entity_decode( get_the_title( $post_id ) ),
				'title_link'  => esc_url( wp_get_shortlink( $post_id ) ),
				'author_name' => 'Author: ' . $author,
				'footer'      => 'Chicago Sun-Times API',
				'footer_icon' => esc_url( get_stylesheet_directory_uri() ) . '/assets/images/favicons/favicon-16x16.png',
				'ts'          => time(),
			),
		);
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

	/**
	 * @param $response
	 * @param $payload_array
	 * @param $obj \CST\Objects\Article
	 *
	 * Upon content state transition trigger a post to the Slack App API channel
	 */
	public function notify_app( $response, $payload_array, $obj ) {
		$response_code        = wp_remote_retrieve_response_code( $response );
		$notification_message = '"' . $obj->get_title() . '" added/updated with this response code ' . $response_code;
		$payload['text']      = html_entity_decode( $obj->get_title() .' published/updated' );
		$section_array        = $this->notification_message_formatting( $payload_array, $obj );
		$payload['attachments']  = array(
			array(
				'text'        => html_entity_decode( $notification_message ),
				'pretext'     => html_entity_decode( '[cst.atapi.net] Reply: ' . wp_remote_retrieve_body( $response ) ),
				'fallback'    => html_entity_decode( $obj->get_title() ),
				'color'       => 'good',
				'fields'      => array(
					array(
					'title' => 'Token',
					'value' => $payload_array['body']['token'],
					'short' => true,
					),
					array(
						'title' => 'Slug',
						'value' => $payload_array['body']['slug'],
						'short' => true,
					),
					$section_array,
					array(
						'title' => 'Message',
						'value' => html_entity_decode( $payload_array['body']['message'] ),
						'short' => true,
					),
				),
				'title'       => html_entity_decode( $obj->get_title() ),
				'title_link'  => esc_url( wp_get_shortlink( $obj->get_id() ) ),
				'footer'      => 'Chicago Sun-Times API',
				'footer_icon' => esc_url( get_stylesheet_directory_uri() ) . '/assets/images/favicons/favicon-16x16.png',
				'ts'          => time(),
			),
		);
		$payload['unfurl_links'] = true;
		$payload['unfurl_media'] = true;

		$this->send_payload( array(
			'body' => json_encode( $payload ),
		), $this->api_notification_payload_url );

	}

	/**
	 * @param $payload_array
	 * @param $obj
	 *
	 * @return array
	 *
	 * Format the section information transmitted to the Slack notification channel
	 */
	private function notification_message_formatting( $payload_array, $obj ) {
		$sections = array();
		if ( 'cst_feature' === $obj->get_post_type() ) {
			$section_list = $obj->get_post_type();
		} else {
			$section_counter = 1;
			while ( isset( $payload_array['body'][ "section{$section_counter}" ] ) ) {
				$sections[] = $payload_array['body'][ "section{$section_counter}" ];
				$section_counter++;
			}
			$section_list = implode( ',', $sections );
		}
		$section_array = array(
			'title' => 'Sections',
			'value' => $section_list,
			'short' => true,
		);
		return $section_array;
	}
}
