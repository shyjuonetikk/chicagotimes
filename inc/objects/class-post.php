<?php

namespace CST\Objects;

/**
 * Base class to represent a WordPress Post
 */
abstract class Post {

	protected $post;

	protected static $post_type = 'post';

	public function __construct( $post ) {

		if ( is_numeric( $post ) ) {
			$post = get_post( $post );
		}

		$this->post = $post;
	}

	/**
	 * Get the proper object based on its post ID
	 *
	 * @param $post_id
	 *
	 * @return Article|Gallery|Attachment|Link|Video|Embed|bool
	 */
	public static function get_by_post_id( $post_id ) {

		if ( ! $post_id ) {
			return false;
		}

		$post = get_post( $post_id );
		if ( ! $post ) {
			return false;
		}

		$class = '\CST\Objects\\' . ucwords( str_replace( 'cst_', '', $post->post_type ) );
		if ( '\CST\Objects\Post' == $class ) {
			return false;
		}
		if ( class_exists( $class ) ) {
			return new $class( $post_id );
		} else {
			return false;
		}

	}

	/**
	 * Get the ID for the post
	 *
	 * @return int
	 */
	public function get_id() {
		return $this->get_field( 'ID' );
	}

	/**
	 * Get the post type for the post
	 *
	 * @return string
	 */
	public function get_post_type() {
		return get_post_type( $this->get_id() );
	}

	/**
	 * Get a friendly text version of the post type
	 *
	 * @param string $post_type
	 * @return string
	 */

	public function get_post_type_name( $post_type ) {

		if ( empty( $post_type ) ) {
			return;
		}

		switch ( $post_type ) {
			case 'cst_article':
				$post_type_name = 'article';
				break;
			case 'cst_link':
				$post_type_name = 'link';
				break;
			case 'cst_embed':
				$post_type_name = 'embed';
				break;
			case 'cst_video':
				$post_type_name = 'video';
				break;
			case 'cst_gallery':
				$post_type_name = 'gallery';
				break;
			case 'cst_feature':
				$post_type_name = 'feature';
				break;
			default:
				break;
		}

		return $post_type_name;

	}

	/**
	 * Get the title for the post
	 *
	 * @return string
	 */
	public function get_title() {
		return $this->get_field( 'post_title' );
	}

	/**
	 * Echo the title for the post
	 */
	public function the_title() {
		echo wp_kses_post( apply_filters( 'the_title', $this->get_title() ) );
	}

	/**
	 * Set the title of the post
	 *
	 * @param string
	 */
	public function set_title( $title ) {
		$this->set_field( 'post_title', $title );
	}

	/**
	 * Get the slug for the post
	 *
	 * @return string
	 */
	public function get_slug() {
		return $this->get_field( 'post_name' );
	}

	/**
	 * Set the slug of the post
	 *
	 * @param string
	 */
	public function set_slug( $slug ) {
		$this->set_field( 'post_name', sanitize_title( $slug ) );
	}

	/**
	 * Get the status of post
	 *
	 * @return string
	 */
	public function get_status() {
		return $this->get_field( 'post_status' );
	}

	/**
	 * Set the status of post
	 * Use sparingly, because it bypasses many actions
	 *
	 * @param string
	 */
	public function set_status( $status ) {
		$this->set_field( 'post_status', $status );
	}

	/**
	 * Get the type of post
	 *
	 * @return string
	 */
	public function get_type() {
		return str_replace( 'cst_', '', static::$post_type );
	}

	/**
	 * Get the excerpt for the post
	 *
	 * @return mixed
	 */
	public function get_excerpt() {
		if ( $excerpt = $this->get_field( 'post_excerpt' ) ) {
			return $excerpt;
		}
	}

	/**
	 * Echo the excerpt for the post
	 */
	public function the_excerpt() {
		echo wp_kses_post( apply_filters( 'the_excerpt', $this->get_excerpt() ) );
	}

	/**
	 * Set the excerpt for the post
	 *
	 * @param string $excerpt
	 */
	public function set_excerpt( $excerpt ) {
		$this->set_field( 'post_excerpt', $excerpt );
	}

	/**
	 * Get the content for the post
	 *
	 * @return string
	 */
	public function get_content() {
		return $this->get_field( 'post_content' );
	}

	/**
	 * Echo the content for the post
	 */
	public function the_content() {
		global $wp_embed;
		remove_filter ( 'the_content', array ( $GLOBALS['wp_embed'], 'autoembed' ), 8 );
		$content = wp_kses_post( apply_filters( 'the_content', $this->get_field( 'post_content' ) ) );
		$content = $wp_embed->autoembed( $content );
		add_filter( 'the_content', array( array ( $GLOBALS['wp_embed'], 'autoembed' ), 8 ) );
		echo $content;
	}

	/**
	 * Set the content for the post
	 *
	 * @param string $content
	 */
	public function set_content( $content ) {
		$this->set_field( 'post_content', $content );
	}

	/**
	 * Get the font icon for the post
	 */
	abstract public function get_font_icon();

	/**
	 * Get the authors for the post
	 *
	 * @return array
	 */
	public function get_authors() {

		$authors = get_coauthors( $this->get_id() );
		foreach ( $authors as $key => &$author ) {
			if ( 'guest-author' == $author->type ) {
				if ( class_exists( 'Guest_Author' ) ) {
					$author = new Guest_Author( $author );
				} else {
					$author = new User( $author );
				}
			} else {
				$author = new User( $author );
			}
		}
		return $authors;
	}

	/**
	 * Get the link to edit the post
	 *
	 * @return string
	 */
	public function get_edit_link() {
		return admin_url( 'post.php?action=edit&post=' . $this->get_id() );
	}

	/**
	 * Get the share link for the post
	 *
	 * @return string
	 */
	public function get_share_link() {
		return wp_get_shortlink( $this->get_id(), 'post' );
	}

	/**
	* Get the permalink for the post
	*
	* @return string
	*/
	public function get_permalink() {
		return get_permalink( $this->get_id() );
	}

	/**
	 * Get the permalink for the post
	 *
	 */
	public function the_permalink() {
		echo esc_url( apply_filters( 'the_permalink', $this->get_permalink() ) );
	}

	/**
	 * Get the post date for the post
	 *
	 * @param string $format
	 *
	 * @return false|string
	 */
	public function get_post_date( $format = 'U' ) {
		return date( $format, strtotime( $this->get_field( 'post_date' ) ) );
	}

	/**
	 * Set the post date for the post
	 *
	 * @param string
	 */
	public function set_post_date( $post_date ) {
		$this->set_field( 'post_date', date( 'Y-m-s H:i:s', strtotime( $post_date ) ) );
	}

	/**
	 * Get the post date gmt for the post
	 * @param string $format
	 *
	 * @return false|string
	 */
	public function get_post_date_gmt( $format = 'U' ) {
		return date( $format, strtotime( $this->get_field( 'post_date_gmt' ) ) );
	}

	/**
	 * Set the post date gmt for the post
	 *
	 * @param string
	 */
	public function set_post_date_gmt( $post_date_gmt ) {
		$this->set_field( 'post_date_gmt', date( 'Y-m-s H:i:s', strtotime( $post_date_gmt ) ) );
	}
	/**
	 * Set the post modified for the post
	 *
	 * @param $format string
	 * @return string
	 */
	public function get_post_modified( $format = 'U' ) {
		return date( $format, strtotime( $this->get_field( 'post_modified' ) ) );
	}

	/**
	 * Return the publish date or if modified the post modified date
	 * @param string $format
	 *
	 * @return mixed|string
	 *
	 */
	public function get_localized_pub_mod_date( $format = 'U' ) {
		$post_modified_date = $this->get_post_modified();
		$original_date = $this->get_post_date();
		if ( $post_modified_date > $original_date ) {
			$localized_display_date = $post_modified_date;
		} else {
			$localized_display_date = $original_date;
		}
		return $localized_display_date;
	}
	/**
	 * Set the post modified for the post
	 *
	 * @param string
	 */
	public function set_post_modified( $post_modified ) {
		$this->set_field( 'post_modified', date( 'Y-m-s H:i:s', strtotime( $post_modified ) ) );
	}

	/**
	 * Get the post modified GMT for the post
	 *
	 * @param string $format
	 *
	 * @return false|string
	 */
	public function get_post_modified_gmt( $format = 'U' ) {
		return date( $format, strtotime( $this->get_field( 'post_modified_gmt' ) ) );
	}

	/**
	 * Set the post modified gmt for the post
	 *
	 * @param string
	 */
	public function set_post_modified_gmt( $post_modified_gmt ) {
		$this->set_field( 'post_modified_gmt', date( 'Y-m-s H:i:s', strtotime( $post_modified_gmt ) ) );
	}


	/**
	 * Get the featured image ID for the post
	 *
	 * @return int|false
	 */
	public function get_featured_image_id() {
		return (int) $this->get_meta( '_thumbnail_id' );
	}

	/**
	 * Set the featured image for the post
	 *
	 * @param int $featured_image_id
	 */
	public function set_featured_image_id( $featured_image_id ) {
		$this->set_meta( '_thumbnail_id', (int) $featured_image_id );
	}

	/**
	 * Get the featured image url for the given featured image id
	 *
	 * @param string $size
	 * @return string|false
	 */
	public function get_featured_image_url( $size = 'full' ) {

		$attachment_id = $this->get_featured_image_id();
		if ( ! $attachment_id ) {
			return false;
		}
		$src = wp_get_attachment_image_src( $attachment_id, $size );
		if ( ! $src ) {
			return false;
		}

		return $src[0];
	}

	/**
	 * Get the HTML for the featured image html
	 * @param string $size
	 *
	 * @return string
	 */
	public function get_featured_image_html( $size = 'full' ) {

		if ( $featured_image_id = $this->get_featured_image_id() ) {
			return wp_get_attachment_image( $featured_image_id, $size, '' );
		} else {
			return '';
		}
	}

	/**
	 * Get the primary section for the post
	 *
	 * @return object|false
	 */
	public function get_primary_section() {

		if ( $sections = $this->get_sections() ) {
			return array_shift( $sections );
		} else {
			return false;
		}

	}



	/**
	 * Get the sections of the post
	 *
	 * @return array
	 */
	public function get_sections() {
		return $this->get_taxonomy_terms( 'cst_section' );
	}

	/**
	 * Get the section slugs of the post
	 *
	 * @return array|bool
	 */
	public function get_section_slugs() {
		$sections = $this->get_taxonomy_terms( 'cst_section' );
		$slugs = array();
		if ( $sections ) {
			foreach ( $sections as $section ) {
				array_push( $slugs, $section->slug );
			}
			return $slugs;
		} else {
			return false;
		}
	}

	/**
	 * Get the parent section of the post
	 *
	 * @return array|bool
	 */
	public function get_primary_parent_section() {

		if ( $sections = $this->get_sections() ) {

			while ( $section = array_shift( $sections ) ) {
				if ( 0 == $section->parent ) {
					return $section;
				} else {
					$section = $this->get_grandchild_parent_section();
					return $section;
				}
			}
		} else {
			$section = wpcom_vip_get_term_by( 'slug', 'news', 'cst_section' );
			return $section;
		}

	}

	public function get_child_parent_section() {
		$sections = $this->get_taxonomy_terms( 'cst_section' );
		if ( ! $sections ) :
			return;
		endif;

		$primary_child = array_shift( $sections );
		$parent_details = get_term( $primary_child->parent, 'cst_section' );
		return $parent_details->slug;

	}

	/**
	 * @return array|null|void|\WP_Error|\WP_Term
	 */
	public function get_grandchild_parent_section() {
		$sections = $this->get_taxonomy_terms( 'cst_section' );
		if ( ! $sections ) :
			return;
		endif;

		$primary_child = array_shift( $sections );
		$parent_details = get_term( $primary_child->parent, 'cst_section' );
		if ( 0 != $parent_details->parent ) {
			$parent_details = get_term( $parent_details->parent, 'cst_section' );
		}

		return $parent_details;

	}

	/**
	 * Get the child sections of the post
	 *
	 * @return bool|mixed|array
	 */
	public function get_child_section() {
		$sections = $this->get_taxonomy_terms( 'cst_section' );
		$children = array();
		foreach ( $sections as $section ) {
			if ( 0 != $section->parent ) {
				array_push( $children, $section->slug );
			}
		}

		if ( count( $children ) > 0 ) {
			return array_shift( $children );
		} else {
			return false;
		}

	}

	/**
	 * Set the sections for the post
	 *
	 * @param array
	 */
	public function set_sections( $sections ) {
		$this->set_taxonomy_terms( 'cst_section', $sections );
	}

	/**
	 * Get the topics of the post
	 *
	 * @return array
	 */
	public function get_topics() {
		return $this->get_taxonomy_terms( 'cst_topic' );
	}

	/**
	 * Set the topics for the post
	 *
	 * @param array
	 */
	public function set_topics( $topics ) {
		$this->set_taxonomy_terms( 'cst_topic', $topics );
	}

	/**
	 * Get the locations of the post
	 *
	 * @return array
	 */
	public function get_locations() {
		return $this->get_taxonomy_terms( 'cst_location' );
	}

	/**
	 * Set the locations for the post
	 *
	 * @param array
	 */
	public function set_locations( $locations ) {
		$this->set_taxonomy_terms( 'cst_location', $locations );
	}

	/**
	 * Get the people of the post
	 *
	 * @return array
	 */
	public function get_people() {
		return $this->get_taxonomy_terms( 'cst_person' );
	}

	/**
	 * Set the people for the post
	 *
	 * @param array
	 */
	public function set_people( $people ) {
		$this->set_taxonomy_terms( 'cst_person', $people );
	}

	/**
	 * Get the byline field for the post
	 *
	 * @return string
	 */
	public function get_byline() {

		if ( $byline = $this->get_fm_field( 'freelancer_byline' ) ) {
			return $byline;
		} else {
			return false;
		}

	}

	/**
	 * Get the preferred term field for the article
	 *
	 * @param $term_field_name
	 *
	 * @return bool|mixed
	 */

	public function get_preferred_terms( $term_field_name ) {

		if ( $value = $this->get_fm_field( $term_field_name ) ) {
			return $value;
		} else {
			return false;
		}

	}

	/**
	 * Get the newsletter field for the post
	 *
	 * @return string
	 */
	public function get_newsletter_tag() {

		if ( $newsletter_tag = $this->get_fm_field( 'newsletter_tags' ) ) {
			return $newsletter_tag;
		} else {
			return false;
		}

	}

	/**
	 * Get the chatter widget field for the post
	 *
	 * @return string
	 */
	public function get_chatter_widget_selection() {

		if ( $chatter_selection = $this->get_fm_field( 'cst_preferred_terms' ) ) {
			return $chatter_selection['choose_chatter']['chatter_widget_selection'];
		} else {
			return false;
		}

	}

	/**
	 * Get the yieldmo tag field for the post
	 *
	 * @return string
	 */
	public function get_yieldmo_tag() {

		if ( $yieldmo_tag = $this->get_fm_field( 'yieldmo_tags' ) ) {
			return $yieldmo_tag;
		} else {
			return false;
		}

	}

	/**
	 * Get the SEO title for the post
	 *
	 * @return string
	 */
	public function get_seo_title() {
		if ( $title = $this->get_fm_field( 'cst_distribution', 'seo', 'title' ) ) {
			return $title;
		} else {
			return $this->get_default_seo_title();
		}
	}

	/**
	 * Get the default SEO title for the post
	 *
	 * @return string
	 */
	public function get_default_seo_title() {
		return $this->get_title() . ' | ' . get_bloginfo( 'name' );
	}

	/**
	 * Get the SEO description for the post
	 *
	 * @return string
	 */
	public function get_seo_description() {
		if ( $description = $this->get_fm_field( 'cst_distribution', 'seo', 'description' ) ) {
			return $description;
		} else {
			return $this->get_default_seo_description();
		}
	}

	/**
	 * Get the default SEO description for the post
	 *
	 * @return string
	 */
	public function get_default_seo_description() {

		$excerpt = $this->get_field( 'post_excerpt' );
		if ( ! $excerpt ) {
			$content = $this->get_field( 'post_content' );
			$parts = wordwrap( $content, 150, PHP_EOL );
			$parts = explode( PHP_EOL, $parts );
			$excerpt = array_shift( $parts );
		}
		return $excerpt;
	}

	/**
	 * Get a given Facebook open graph tag for this post
	 *
	 * @param string $tag_name
	 * @return string
	 */
	public function get_facebook_open_graph_tag( $tag_name ) {

		switch ( $tag_name ) {

			case 'title':
				$val = $this->get_fm_field( 'cst_distribution', 'facebook', 'title' );
				break;

			case 'description':
				$val = $this->get_fm_field( 'cst_distribution', 'facebook', 'description' );
				break;

			case 'url':
				$val = $this->get_permalink();
				break;

			case 'image':
				$image_id = $this->get_fm_field( 'cst_distribution', 'facebook', 'image' );
				if ( $src = wp_get_attachment_image_src( $image_id, 'facebook-open-graph' ) ) {
					$val = $src[0];
				} else {
					$val = '';
				}
				break;

			default:
				break;
		}

		if ( ! empty( $val ) ) {
			return $val;
		} else {
			return $this->get_default_facebook_open_graph_tag( $tag_name );
		}

	}

	/**
	 * Get the default Facebook Open Graph tag for this post
	 *
	 * @param string $tag_name
	 * @return string
	 */
	public function get_default_facebook_open_graph_tag( $tag_name ) {

		switch ( $tag_name ) {

			case 'title':
				$val = $this->get_title();
				break;

			case 'description':
				$val = $this->get_excerpt();
				break;

			case 'url':
				$val = $this->get_permalink();
				break;

			case 'image':
				$val = $this->get_featured_image_url( 'facebook-open-graph' );
				break;

			default:
				$val = '';
				break;
		}

		return $val;

	}

	/**
	 * Get a given Twitter card tag for this post
	 *
	 * @param string $tag_name
	 * @return string
	 */
	public function get_twitter_card_tag( $tag_name ) {

		switch ( $tag_name ) {

			case 'title':
				$title = $this->get_fm_field( 'cst_distribution', 'twitter', 'title' );
				// Limited to 70 characters or less
				if ( strlen( $title ) > 70 ) {
					$parts = wordwrap( $title, 70, PHP_EOL );
					$parts = explode( PHP_EOL, $parts );
					$val = array_shift( $parts );
				} else {
					$val = $title;
				}
				break;

			case 'description':
				$description = $this->get_fm_field( 'cst_distribution', 'twitter', 'description' );
				if ( strlen( $description ) > 200 ) {
					$parts = wordwrap( $description, 200, PHP_EOL );
					$parts = explode( PHP_EOL, $parts );
					$val = array_shift( $parts );
				} else {
					$val = $description;
				}
				break;

			case 'url':
				$val = $this->get_permalink();
				break;

			case 'image':
				$image_id = $this->get_fm_field( 'cst_distribution', 'twitter', 'image' );
				if ( $src = wp_get_attachment_image_src( $image_id, 'twitter-card' ) ) {
					$val = $src[0];
				} else {
					$val = '';
				}
				break;

			default:
				$val = '';
				break;
		}

		if ( ! empty( $val ) ) {
			return $val;
		} else {
			return $this->get_default_twitter_card_tag( $tag_name );
		}

	}

	/**
	 * Get the default Twitter card tag for this post
	 *
	 * @param string $tag_name
	 * @return string
	 */
	public function get_default_twitter_card_tag( $tag_name ) {

		switch ( $tag_name ) {

			case 'title':
				$title = $this->get_title();
				// Limited to 70 characters or less
				if ( strlen( $title ) > 70 ) {
					$parts = wordwrap( $title, 70, PHP_EOL );
					$parts = explode( PHP_EOL, $parts );
					$val = array_shift( $parts );
				} else {
					$val = $title;
				}
				break;

			case 'description':
				$excerpt = $this->get_excerpt();
				// Limited to 200 characters or less
				if ( strlen( $excerpt ) > 200 ) {
					$parts = wordwrap( $excerpt, 200, PHP_EOL );
					$parts = explode( PHP_EOL, $parts );
					$val = array_shift( $parts );
				} else {
					$val = $excerpt;
				}
				break;

			case 'url':
				$val = $this->get_permalink();
				break;

			case 'image':
				$val = $this->get_featured_image_url( 'twitter-card' );
				break;

			default:
				$val = '';
				break;
		}

		return $val;

	}

	/**
	 * Get the text to use when a user shares a link on Twitter
	 *
	 * @return string
	 */
	public function get_twitter_share_text() {

		$share_text = $this->get_fm_field( 'cst_distribution', 'twitter', 'share_text' );
		if ( empty( $share_text ) ) {
			$share_text = $this->get_title();
		}

		if ( strlen( $share_text ) > CST_TWITTER_SHARE_TEXT_MAX_LENGTH ) {
			$share_text = substr( $share_text, 0, CST_TWITTER_SHARE_TEXT_MAX_LENGTH );
		}

		return $share_text;
	}

	/**
	 * Get data for a Google Analytics dimension
	 *
	 * @param int $dimension
	 * @return string
	 */
	public function get_ga_dimension( $dimension ) {

		$val = '';
		switch ( $dimension ) {
			case 1:
				$author_names = array();
				foreach ( $this->get_authors() as $author ) {
					$author_names[] = $author->get_display_name();
				};
				$val = implode( ',', $author_names );
				break;

			case 2:
				if ( $topics = $this->get_topics() ) {
					$topic = array_shift( $topics );
					$val = $topic->name;
				}
				break;

			case 3:
				if ( $people = $this->get_people() ) {
					$person = array_shift( $people );
					$val = $person->name;
				}
				break;

			case 4:
				if ( $locations = $this->get_locations() ) {
					$location = array_shift( $locations );
					$val = $location->name;
				}
				break;

			case 5:
				$val = $this->post->post_type;
				break;

			case 6:
				$datetime = new \DateTime( $this->post->post_date );
				$val = date_format( $datetime, 'mdY h:i:s' );
				break;

			case 7:
				$datetime = new \DateTime( $this->post->post_modified );
				$val = date_format( $datetime, 'mdY h:i:s' );
				break;

			case 8:
				$val = false;
				break;

			case 9:
				if ( $section = $this->get_primary_section() ) {
					$val = $section->name;
				} else {
					$val = false;
				}
				break;

		}
		return $val;

	}

	/**
	 * @return string
	 */
	public function get_twitter_share_url() {
		$share_link = rawurldecode( $this->get_share_link() );
		$text = rawurlencode( $this->get_twitter_share_text() );
		$twitter_args = array(
			'url'        => $share_link,
			'text'       => $text,
			'via'        => CST_TWITTER_USERNAME,
		);
		$twitter_url = add_query_arg( $twitter_args, 'https://twitter.com/share' );
		return $twitter_url;
	}
	/**
	 * Get print slug
	 *
	 * @return string
	 */
	public function get_print_slug() {

		return $this->get_fm_field( 'cst_distribution', 'print', 'print_slug' );

	}

	/**
	 * Create a new instance
	 *
	 * @param $args array of parameters for Post creation
	 *
	 * @return Post|false
	 */
	public static function create( $args = array() ) {

		$defaults = array(
			'post_type'     => static::$post_type,
			'post_status'   => 'draft',
			'post_author'   => get_current_user_id(),
			);
		$args = array_merge( $defaults, $args );
		add_filter( 'wp_insert_post_empty_content', '__return_false' );
		$post_id = wp_insert_post( $args );
		remove_filter( 'wp_insert_post_empty_content', '__return_false' );
		if ( ! $post_id ) {
			return false;
		}

		$class = get_called_class();

		return new $class( $post_id );
	}

	/**
	 * Get a field from the post object
	 *
	 * @param string $key
	 * @return mixed
	 */
	protected function get_field( $key ) {
		return $this->post->$key;
	}

	/**
	 * Set a field for the post object
	 *
	 * @param string $key
	 * @param mixed $value
	 */
	protected function set_field( $key, $value ) {
		global $wpdb;

		$wpdb->update( $wpdb->posts, array( $key => $value ), array( 'ID' => $this->get_id() ) );
		clean_post_cache( $this->get_id() );
		$this->post = get_post( $this->get_id() );
	}

	/**
	 * Get a meta value for a post
	 *
	 * @param string
	 * @return mixed
	 */
	protected function get_meta( $key ) {
		return get_post_meta( $this->get_id(), $key, true );
	}

	/**
	 * Set a meta value for a post
	 *
	 * @param string $key
	 * @param mixed $value
	 */
	protected function set_meta( $key, $value ) {
		update_post_meta( $this->get_id(), $key, $value );
	}

	/**
	 * Get a Fieldmanager field
	 *
	 * @param string
	 * @return mixed
	 */
	protected function get_fm_field() {

		$fields = func_get_args();
		$parent = array_shift( $fields );

		$meta = $this->get_meta( $parent );
		foreach ( $fields as $key ) {
			if ( isset( $meta[ $key ] ) ) {
				$meta = $meta[ $key ];
			} else {
				return false;
			}
		}
		return $meta;

	}

	/**
	 * Get the taxonomy terms for a post
	 *
	 * @param string $taxonomy
	 * @return array|false
	 */
	protected function get_taxonomy_terms( $taxonomy ) {

		$terms = get_the_terms( $this->get_id(), $taxonomy );
		if ( $terms && ! is_wp_error( $terms ) ) {
			return $terms;
		} else {
			return false;
		}

	}

	/**
	 * Set taxonomy terms for a post
	 *
	 * @param string $taxonomy
	 * @param array $terms Array of term names or term objects
	 *
	 * @return bool
	 */
	protected function set_taxonomy_terms( $taxonomy, $terms ) {

		if ( ! is_array( $terms ) ) {
			return false;
		}

		// Maybe this was an array of objects
		$first_term = $terms[0];
		if ( is_object( $first_term ) ) {
			$terms = wp_list_pluck( $terms, 'name' );
		}

		// Terms need to exist in order to use wp_set_object_terms(), sadly
		foreach ( $terms as $term ) {
			if ( ! get_term_by( 'name', $term, $taxonomy ) ) {
				wp_insert_term( $term, $taxonomy );
			}
		}

		wp_set_object_terms( $this->get_id(), array_map( 'sanitize_title', $terms ), $taxonomy );
	}

	/**
	 * Get content for sponsored settings and return content array
	 * or false if empty array and to not display sponsored content
	 * @return array | bool
	 */
	public function get_sponsored_content() {
		if ( is_singular( 'cst_feature' ) ) {
			return false;
		}
		if ( $sponsor_array = $this->get_fm_field( 'cst_production', 'sponsored_content' ) ) {
			if ( $this->is_sponsored_content_active( $sponsor_array ) ) {
				return $sponsor_array;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	/**
	 * @return bool
	 *
	 * Callback content check function for Ad_Vendor handler
	 */
	public function is_not_sponsored_content() {
		return ! $this->get_sponsored_content();
	}
	/**
	 * Check for content and settings in the sponsored meta for the content item
	 *
	 * @param array $sponsor_array
	 * @return bool
	 */
	private function is_sponsored_content_active( $sponsor_array ) {
		if ( null === $sponsor_array['sponsor_url'] ||
			 null === $sponsor_array['sponsor_image'] ||
			 empty( trim( $sponsor_array['sponsor_content_name'] ) ) ||
			 empty( trim( $sponsor_array['sponsor_line1'] ) ) ||
			 empty( trim( $sponsor_array['sponsor_line2'] ) ) ) {
			return false;
		} else {
			return true;
		}
	}
}
