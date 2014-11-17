<?php
	$icon = '';
	$format = get_post_format();
	if( '' == $format )
		$format = 'standard';
?>

<div class="format-icon format-icon-<?php echo $format; ?>"></div>