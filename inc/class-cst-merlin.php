<?php

/**
 * Integration with Merlin photo asset system
 */
class CST_Merlin {

	private static $instance;

	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new CST_Merlin;
			self::$instance->setup_actions();
		}

		return self::$instance;
	}

	/**
	 * Set up Merlin-related actions
	 */
	private function setup_actions() {

		add_action( 'load-post.php', array( $this, 'action_load_post' ) );
		add_action( 'load-post-new.php', array( $this, 'action_load_post' ) );

		add_action( 'wp_ajax_cst_import_merlin', array( $this, 'handle_import_merlin' ) );
		remove_action( 'wp_ajax_query-attachments', 'wp_ajax_query_attachments', 1 );
		add_action( 'wp_ajax_query-attachments', array( $this, 'handle_ajax_query_attachments' ), 1 );

	}

	/**
	 * Only perform these actions on the Edit Post view
	 */
	public function action_load_post() {

		add_action( 'admin_enqueue_scripts', array( $this, 'action_admin_enqueue_scripts' ) );

	}

	/**
	 * Enqueue scripts and styles
	 */
	public function action_admin_enqueue_scripts() {
		global $post;

		wp_enqueue_script( 'cst-merlin', get_template_directory_uri() . '/assets/js/merlin.js', array( 'jquery', 'media-views' ) );
		wp_localize_script( 'cst-merlin', 'CSTMerlinData', array(
			'nonce'              => wp_create_nonce( 'merlin-import' ),
			'post_id'            => (int)$post->ID,
			'import_label'       => esc_html__( 'Import into WordPress', 'chicagosuntimes' ),
			'importing_label'    => esc_html__( 'Importing...', 'chicagosuntimes' )
		) );

		wp_enqueue_style( 'cst-merlin', get_template_directory_uri() . '/assets/css/merlin.css' );

	}

	/**
	 * Handle a request to import Merlin images
	 */
	public function handle_import_merlin() {

		if ( ! current_user_can( 'upload_files' ) ) {
			wp_send_json_error();
		}

		if ( ! wp_verify_nonce( $_GET['nonce'], 'merlin-import' ) ) {
			wp_send_json_error();
		}

		$merlin_ids = is_array( $_GET['merlin_ids'] ) ? array_map( 'intval', $_GET['merlin_ids'] ) : array();
		if ( empty( $merlin_ids ) ) {
			wp_send_json_error();
		}

		$post_id = (int)$_GET['post_id'];

		$attachment_ids = array();
		foreach( $merlin_ids as $merlin_id ) {

			$item = $this->get_merlin_items( array( 'id' => $merlin_id ) );
			if ( is_wp_error( $item ) ) {
				continue;
			}

			$item = array_shift( $item );
			$attach_id = $this->download_image( $item->full_url, $post_id, $item->title );
			if ( is_wp_error( $attach_id ) ) {
				wp_send_json_error( $attach_id->get_error_message() );
			}

			$attachment = new \CST\Objects\Attachment( $attach_id );
			$attachment->set_title( sanitize_text_field( $item->title ) );
			$attachment->set_caption( sanitize_text_field( $item->caption ) );
			$attachment->set_credit( wp_kses_post( $item->credit ) );
			$attachment_ids[] = $attach_id;

		}

		wp_send_json_success( $attachment_ids );

	}

	/**
	 * Overload core's query_attachments handling with our own
	 */
	public function handle_ajax_query_attachments() {

		if ( isset( $_POST['query']['post_mime_type'] ) && $_POST['query']['post_mime_type'] ) {

			// No nonce check for core so neither for us!
			if ( ! current_user_can( 'upload_files' ) ) {
				wp_send_json_error();
			}

			// do the merlin request
			$args = array(
				'ipp'     => (int) $_POST['query']['posts_per_page'],
				'sp'      => (int) $_POST['query']['paged'],
				'types'   => 'Photo',
				);

			if ( ! empty( $_POST['query']['s'] ) ) {
				$args['q'] = sanitize_text_field( $_POST['query']['s'] );
			}
			$items = $this->get_merlin_items( $args );
			if ( is_wp_error( $items ) ) {
				wp_send_json_error( $items->get_error_message() );
			}

			foreach( $items as &$item ) {
				$item = $this->format_merlin_as_attachment( $item );
			}

			wp_send_json_success( $items );

		} else {
			wp_ajax_query_attachments();
		}

	}

	/**
	 * Get image items from Merlin
	 */
	public function get_merlin_items( $query_args = array() ) {

		$defaults = array(
			'ali'                  => CST_MERLIN_API_KEY,
			'format'               => 'api',
			);
		$query_args = array_merge( $defaults, $query_args );

		$url = add_query_arg( $query_args, trailingslashit( CST_MERLIN_API_URL ) . 'mweb/wmsql.wm.request?plugin_opensearch' );
		$response = wp_remote_get( $url, array( 'timeout' => 20 ) );
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
			return new WP_Error( 'url-error', esc_html__( "Couldn't retrieve items from Merlin.", 'chicagosuntimes' ) );
		}

		$xml = wp_remote_retrieve_body( $response );
		$dom = new DOMDocument;
		$dom->loadXML( $xml );

		$merlin_objects = array();
		foreach( $dom->getElementsByTagName( 'item' ) as $item ) {

			$metadata = $item->getElementsByTagName( 'metadata' )->item(0);
			$title = $metadata->getElementsByTagName('headline')->item(0)->nodeValue;
			$date = time();

			$merlin_objects[] = (object)array(
				'id'          => intval( $metadata->getElementsByTagName( 'merlinid' )->item(0)->nodeValue ),
				'title'       => sanitize_text_field( $title ),
				'thumb_url'   => esc_url_raw( $item->getElementsByTagName( 'thumbtemplink' )->item(0)->nodeValue ),
				'full_url'    => esc_url_raw( $item->getElementsByTagName( 'SODA' )->item(0)->nodeValue ),
				'credit'      => sanitize_text_field( $metadata->getElementsByTagName( 'credit' )->item(0)->nodeValue ),
				'caption'     => sanitize_text_field( $metadata->getElementsByTagName( 'caption' )->item(0)->nodeValue ),
				'date'        => $date,
				);

		}

		return $merlin_objects;

	}

	/**
	 * Format a Merlin item as an attachment
	 *
	 * @param object $merlin_obj
	 * @return array
	 */
	private function format_merlin_as_attachment( $merlin_obj ) {
		return array(
				'id'          => $merlin_obj->id,
				'title'       => $merlin_obj->title,
				'filename'    => '',
				'url'         => $merlin_obj->thumb_url,
				'link'        => $merlin_obj->thumb_url,
				'alt'         => '',
				'author'      => 0,
				'description' => '',
				'caption'     => $merlin_obj->caption,
				'name'        => sanitize_title( $merlin_obj->title ),
				'status'      => 'inherit',
				'uploadedTo'  => 0,
				'date'        => $merlin_obj->date,
				'modified'    => $merlin_obj->date,
				'menuOrder'   => 0,
				'mime'        => 'image/jpeg', // isn't returned in response
				'type'        => 'image',
				'subtype'     => 'jpeg', // @todo
				'icon'        => wp_mime_type_icon( 'image/jpeg' ),
				'dateFormatted' => mysql2date( get_option('date_format'), date( 'Y-m-d H:i:s', $merlin_obj->date ) ),
				'nonces'      => array(
					'update' => false,
					'delete' => false,
					'edit'   => false
				),
				'editLink'   => false,
				'sizes'      => array(
					'thumbnail'        => array(
						'height'       => 128,
						'width'        => 128,
						'orientation'  => 'landscape',
						'url'          => $merlin_obj->thumb_url
						),
					),
			);

	}

	/**
	 * Internalize wpcom_vip_download_url() to bypass a couple gotchas
	 */
	private function download_image( $image_url, $post_id = 0, $title = '' ) {

		if ( ! is_admin() ) {
			return new WP_Error( 'not-in-admin', 'Media sideloading can only be done in when `true === is_admin()`.' );
		}

		// Allow attachments without posts
		// if ( empty( $post_id ) ) {
		// 	return new WP_Error( 'no-post-id', 'Please specify a valid post ID.' );
		// }

		if ( ! filter_var( $image_url, FILTER_VALIDATE_URL ) ) {
			return new WP_Error( 'not-a-url', 'Please specify a valid URL.' );
		}

		$image_url_path = parse_url( $image_url, PHP_URL_PATH );
		$image_path_info = pathinfo( $image_url_path );

		// SODA URLs don't have extensions
		// if ( ! in_array( strtolower( $image_path_info['extension'] ), array( 'jpg', 'jpe', 'jpeg', 'gif', 'png' ) ) ) {
		// 	return new WP_Error( 'not-an-image', 'Specified URL does not have a valid image extension.' );
		// }

		// Download file to temp location; short timeout, because we don't have all day.
		$downloaded_url = download_url( $image_url, 30 );

		// We couldn't download and store to a temporary location, so bail.
		if ( is_wp_error( $downloaded_url ) ) {
			return $downloaded_url;
		}

		// Merlin produces awful filenames, so let's build our own
		if ( ! empty( $title ) ) {
			$file_array['name'] = sanitize_file_name( $title );
		} else {
			$file_array['name'] = $image_path_info['basename'];
		}
		// wp_check_filetype_and_ext() needs to know what type of image to check for
		if ( empty( $image_path_info['extension'] ) ) {
			$file_array['name'] .= '.jpg';
		}
		$file_array['tmp_name'] = $downloaded_url;

		if ( empty( $description ) ) {
			$description = $image_path_info['filename'];
		}

		// Now, let's sideload it.
		$attachment_id = media_handle_sideload( $file_array, $post_id, $description );

		// If error storing permanently, unlink and return the error
		if ( is_wp_error( $attachment_id ) ) {
			@unlink( $file_array['tmp_name'] ); // unlink can throw errors if the file isn't there
			return $attachment_id;
		}

		return $attachment_id;
	}


}