<?php
// Don't print empty markup if there's nowhere to navigate.
$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
$next     = get_adjacent_post( false, '', false );

if ( '' != $next OR '' != $previous ) {
?>

	<?php if( '' != $next ) : ?>
	<div class="post-nav-fixed next-link">
		<a class="fixed-nav-link" href="<?php echo get_permalink( $next->ID ); ?>">
			<span class="nl-infos">
				<span class="title"><?php echo $next->post_title; ?></span>
			</span>
			<span class="nl-arrow-icon"><i class="fa fa-angle-right"></i></span>
		</a>
	</div>
	<?php endif; ?>

	<?php if( '' != $previous ) : ?>
	<div class="post-nav-fixed previous-link">
		<a class="fixed-nav-link" href="<?php echo get_permalink( $previous->ID ); ?>">
			<span class="nl-arrow-icon"><i class="fa fa-angle-left"></i></span>
			<span class="nl-infos">
				<span class="title"><?php echo $previous->post_title; ?></span>
			</span>
		</a>
	</div>
	<?php endif; ?>

<?php
}