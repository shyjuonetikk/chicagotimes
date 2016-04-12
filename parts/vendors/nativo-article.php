<?php
if( is_singular() ) {
    if( $sidebar_obj = get_queried_object() ) {
        $post_id = $sidebar_obj->ID;
        $obj = \CST\Objects\Post::get_by_post_id( $post_id );
        if( $obj ) {
            $obj_primary_section = $obj->get_primary_parent_section();
            $nativo_positions = CST()->frontend->cst_nativo_determine_positions( $obj_primary_section->slug );
            if( ! empty( $nativo_positions ) ) {
                $i = 0;
        ?>
        <div id="nativo-sponsored" style="display: none;">
            <h4>Sponsored Content</h4>
            <ul class="nativo-sponsored-articles">
        <?php foreach( $nativo_positions as $position ) { $i++; ?>
            <?php if( $i == 1 ) { ?>
                    <div id="nativo-sponsored-article-image"></div>
            <?php } ?>
                <li id="<?php echo $position; ?>"></li>
        <?php } ?>
            </ul>
        </div>
        <?php
            }
        }
    }
}
?>