<?php if( true == ivan_get_option('single-da-after-enable') ) : ?>
<div class="iv-layout dynamic-area dynamic-single dynamic-single-after">
	<?php
		$_id = ivan_get_option('single-da-after');
		ivan_display_dynamic_area( $_id );
	?>
</div>
<?php endif; ?>