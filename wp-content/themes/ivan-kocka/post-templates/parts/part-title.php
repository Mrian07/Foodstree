<?php
$title_prefix = '';

if( is_sticky() ) :
	$title_prefix = '<span class="sticky-post-holder"><span class="inner-sticky-txt">' . __("Featured", 'ivan_domain') .'</span><i class="fa fa-bolt"></i></span>';
endif; ?>
<h1 class="entry-title"><?php echo $title_prefix; ?><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>