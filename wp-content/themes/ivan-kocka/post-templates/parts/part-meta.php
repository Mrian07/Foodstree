<div class="entry-meta">

	<span class="date"><?php _e("Posted On", 'ivan_domain'); ?> <?php echo get_the_date(); ?></span>

	<?php _e("By", 'ivan_domain'); ?> <a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php the_author(); ?></a></span>

	<span class="cats"><?php _e("In", 'ivan_domain'); ?> <?php the_category(', '); ?></span>

	<span class="separator">/</span>	

	<?php echo getPostLikeLink( get_the_ID() ); ?>

	<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="comments pull-right"><a href="<?php comments_link(); ?>"><i class="fa fa-comment comment-icon"></i> <?php comments_number( __('No Comments', 'ivan_domain'), __('1 Comment', 'ivan_domain'), __('% Comments', 'ivan_domain') ); ?></a></span>
	<?php endif; ?>

</div><!-- .entry-meta -->