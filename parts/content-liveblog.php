<?php echo CST()->get_template_part( 'post/title', $vars ); ?>

<?php if ( ! empty( $is_main_query ) ) : ?>
	<?php if ( is_singular( 'cst_liveblog' ) ) : ?>
		<div class="post-content columns medium-9 medium-offset-1 end">
			<?php $obj->the_content(); ?>
		</div>
	<?php else : ?>
		<?php echo $obj->get_latest_entry_content(); ?>
	<?php endif; ?>
<?php endif;
