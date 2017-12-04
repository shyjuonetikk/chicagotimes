<?php if ( is_tax() || is_singular() ) {
    $section_obj = get_queried_object();
    if( is_tax() ) {
        if( $section_obj->taxonomy == 'cst_section' ) {
            if( $section_obj->parent != 0 ) {
                $parent_terms = get_term( $section_obj->parent, 'cst_section' );
                if( ! in_array( $parent_terms->slug, CST_Frontend::$post_sections ) ) {
                    $child_terms = get_term( $parent_terms->parent, 'cst_section' );
                    $section_slug = $child_terms->slug;
                } else {
                    $section_slug = $parent_terms->slug;
                }
            } else {
                $section_slug = $section_obj->slug;
            }
        } else {
            $section_slug = 'news';
        }
    }

    if( is_singular() ) {
        $obj = \CST\Objects\Post::get_by_post_id( get_the_ID() );

        if ( $obj ) {
            $parent_section = $obj->get_primary_parent_section();

            if ( $parent_section ) {
                $section_slug = $parent_section->slug;
            } 
        } else {
            $section_slug = 'news';
        }
    }

    $newsletter_link = 'http://cb.sailthru.com/join/5py/newslettersignup';
    $newsletter_text = 'Sign up for Morning Edition, the Sun-Times New & Politics newsletter';
    switch( $section_slug ) {
        case 'news':
            $newsletter_text = 'Sign-Up for Morning Edition, the Sun-Times News &amp; Politics Newsletter';
            $newsletter_link = 'http://cb.sailthru.com/join/5py/newslettersignup';
            break;
        case 'sports':
            $newsletter_text = 'Sign-Up for the Sun-Times Sports Newsletter and Sports Alerts';
            $newsletter_link = 'http://cb.sailthru.com/join/5py/newslettersignup';
            break;
        case 'entertainment':
            $newsletter_text = 'Sign-Up for the Sun-Times Entertainment Newsletter';
            $newsletter_link = 'http://cb.sailthru.com/join/5py/newslettersignup';
            break;
        case 'politics':
                if( is_tax() ) :
                    $newsletter_text = 'Sign-Up for Morning Edition, the Sun-Times News &amp; Politics Newsletter';
                    $newsletter_link = 'http://cb.sailthru.com/join/5py/newslettersignup';
                endif;
                if( is_singular() ) :
                    $newsletter_text = 'Sign-Up for Political Breaking News Alerts from the Sun-Times';
                    $newsletter_link = 'http://cb.sailthru.com/join/5py/newslettersignup';
                endif;
            break;
        default:
            $newsletter_text = 'Sign-Up for Morning Edition, the Sun-Times New & Politics newsletter';
            $newsletter_link = 'http://cb.sailthru.com/join/5py/newslettersignup';
            break;
    }
?>
<p>
     <span><?php esc_html_e( $newsletter_text ); ?></span>: <a href="<?php echo esc_url( $newsletter_link ); ?>" target="_blank" class="button expand tiny info"><i class="fa fa-envelope"></i> Sign-Up</a>
</p>
<?php }
