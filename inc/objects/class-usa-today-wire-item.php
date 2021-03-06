<?php

namespace CST\Objects;

/**
 * Base class to represent a USA Today item
 */
class USA_Today_Wire_Item extends Post {

    /**
     * Create an AP Wire Item from its SimpleXML representation
     *
     * @param SimpleXML
     */
    public static function create_from_simplexml( $feed_entry ) {
        global $edit_flow;

        $native_published = date( 'Y-m-d H:i:s', strtotime( $feed_entry->datePublished ) );
        $gmt_date_string = get_gmt_from_date( $native_published );

        // Hack to fix Edit Flow bug where it resets post_date_gmt and really breaks things
        if ( is_object( $edit_flow ) ) {
            $_POST['post_type'] = 'cst_usa_today_item';
        }

        $post_args = array(
            'post_title'        => sanitize_text_field( $feed_entry->headline ),
            'post_content'      => wp_filter_post_kses( $feed_entry->fullText ),
            'post_type'         => 'cst_usa_today_item',
            'post_author'       => 0,
            'post_status'       => 'publish',
            'post_name'         => md5( 'usa_today_item' . $feed_entry->assetId ),
            'post_date'         => get_gmt_from_date( $native_published ),
            'post_date_gmt'     => $gmt_date_string,
            );

        $post_id = wp_insert_post( $post_args, true );
        if ( is_wp_error( $post_id ) ) {
            return $post_id;
        }

        $post = new USA_Today_Wire_Item( $post_id );

        // Process attributes from the item's XML node

        // Headline node
        $post->set_wire_headline( sanitize_text_field( (string) $feed_entry->headline ) );
        
        // Attribution > Publication node
        $post->set_wire_dateline( sanitize_text_field( (string) $feed_entry->attribution->publication ) );
    
        // fullText node
        $post->set_wire_content( wp_filter_post_kses( $feed_entry->fullText ) );

        // promoBrief node
        $post->set_wire_promo_brief( wp_filter_post_kses( $feed_entry->promoBrief ) );
            

        return $post;
    }

    /**
     * Get a USA Today Wire Item by its original ID
     *
     * @param string $original_id
     * @return USA_Today_Wire_Item|false
     */
    public static function get_by_original_id( $original_id ) {
        global $wpdb;

        $key = md5( 'usa_today_item' . $original_id );
        $post_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name=%s LIMIT 0,1", $key ) );
        if ( ! $post_id ) {
            return false;
        }

        return new USA_Today_Wire_Item( $post_id );
    }

    /**
     * Get the item's headline from its NITF data
     *
     * @return string
     */
    public function get_wire_headline() {
        return $this->get_meta( 'usa_today_wire_headline' );
    }

    /**
     * Set the item's wire headline
     *
     * @param string
     */
    public function set_wire_headline( $wire_headline ) {
        $this->set_meta( 'usa_today_wire_headline', $wire_headline );
    }

    /**
     * Get the item's dateline from its NITF data
     *
     * @return string
     */
    public function get_wire_dateline() {
        return $this->get_meta( 'usa_today_wire_dateline' );
    }

    /**
     * Set the item's wire dateline
     *
     * @param string
     */
    public function set_wire_dateline( $wire_dateline ) {
        $this->set_meta( 'usa_today_wire_dateline', $wire_dateline );
    }

    /**
     * Get the item's body from its NITF data
     *
     * @return string
     */
    public function get_wire_content() {
        return $this->get_meta( 'usa_today_wire_content' );
    }

    /**
     * Set the item's wire body
     *
     * @param string
     */
    public function set_wire_content( $wire_content ) {
        $this->set_meta( 'usa_today_wire_content', $wire_content );
    }

    /**
     * Get the item's wire promo brief
     *
     * @return string
     */
    public function get_wire_promo_brief() {
        return $this->get_meta( 'usa_today_wire_promo_brief' );
    }

    /**
     * Set the item's wire promo brief
     *
     * @param string
     */
    public function set_wire_promo_brief( $wire_content ) {
        $this->set_meta( 'usa_today_wire_promo_brief', $wire_content );
    }

    /**
     * Get a given field from the NITF data
     *
     * @return mixed
     */
    public function get_nitf_field( $nitf_data, $xpath ) {

        if ( empty( $nitf_data ) ) {
            return '';
        }

        $obj = simplexml_load_string( $nitf_data );
        return $obj->xpath( $xpath );
    }

    /**
     * External URL for the AP Wire Item
     *
     * @return string
     */
    public function get_external_url() {
        return $this->get_meta( 'external_url' );
    }

    /**
     * External URL for the AP Wire Item
     *
     * @param string
     */
    public function set_external_url( $external_url ) {
        $this->set_meta( 'external_url', $external_url );
    }

    /**
     * Get the post for the article
     *
     * @return \CST\Objects\Article|false
     */
    public function get_article_post() {

        if ( $post_id = $this->get_meta( 'article_post_id' ) ) {

            if ( $post = get_post( $post_id ) ) {
                return new Article( $post );
            }

        }

        return false;
    }

    /**
     * Create an article post from this wire item
     *
     * @return \CST\Objects\Article|false
     */
    public function create_article_post() {
        global $coauthors_plus;

        $article = Article::create( array(
            'post_title'     => sanitize_text_field( $this->get_wire_headline() ),
            'post_content'   => wp_filter_post_kses( $this->get_wire_content() ),
            ) );
        if ( ! $article ) {
            return false;
        }
        if ( WP_DEBUG && $coauthors_plus && $guest_author = $coauthors_plus->guest_authors->get_guest_author_by( 'post_name', 'usa-today' ) ) {
            $coauthors_plus->add_coauthors( $article->get_id(), array( $guest_author->user_nicename ), false );
        } elseif ( $coauthors_plus && $guest_author = $coauthors_plus->guest_authors->get_guest_author_by( 'post_name', 'usa-today-network' ) ) {
            $coauthors_plus->add_coauthors( $article->get_id(), array( $guest_author->user_nicename ), false );
        }

        $this->set_meta( 'article_post_id', $article->get_id() );

        return $article;
    }

    /**
     * Not necessary because not displayed on frontend
     */
    public function get_font_icon() {
        return '';
    }

}