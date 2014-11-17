<div class="entry-meta">

	<span class="date"><?php echo get_the_date(); ?></span>

	<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>

		<span class="separator">/</span>
		
		<span class="comments"><a href="<?php comments_link(); ?>"><?php comments_number( __('No Comments', 'ivan_domain'), __('1 Comment', 'ivan_domain'), __('% Comments', 'ivan_domain') ); ?></a></span>
	<?php endif; ?>

	<span class="separator">/</span>

	<?php echo getPostLikeLink( get_the_ID() ); ?>

</div><!-- .entry-meta -->