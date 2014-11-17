<?php if(get_the_tags() && ivan_get_option('single-tags') == true) : ?>
	<div class="entry-tags">
		<?php the_tags('<h5 class="tags-label">'. __('Tags:', 'ivan_domain') . '</h5>', ''); ?>
	</div>
<?php endif; ?>