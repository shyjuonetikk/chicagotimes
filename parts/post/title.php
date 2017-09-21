<?php if ( ! empty( $is_main_query ) ) { ?>
	<?php if ( is_singular() ) { ?>
	<div class="columns small-11 medium-10 end">
		<h1><?php $obj->the_title(); ?></h1>
	</div>
	<div class="post-meta post-meta-social show-for-small-only">
		<?php echo CST()->get_template_part( 'post/social-share', array( 'obj' => $obj ) ); ?>
	</div>
	<?php } else { ?>
	<h3 class="section-article-link"><a href="<?php $obj->the_permalink(); ?>" data-on="click" data-event-category="sf-list" data-event-action="click-title"><?php $obj->the_title(); ?></a></h3>
	<?php } ?>
<?php } else { ?>
	<h3><a href="<?php $obj->the_permalink(); ?>" data-on="click" data-event-category="sf-list" data-event-action="click-sf-title"><?php $obj->the_title(); ?></a></h3>
<?php }
