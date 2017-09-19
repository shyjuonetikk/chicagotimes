<?php echo wp_kses( CST()->get_template_part( 'post/gallery-slides', array( 'obj' => $obj ) ), CST()->gallery_kses  );
