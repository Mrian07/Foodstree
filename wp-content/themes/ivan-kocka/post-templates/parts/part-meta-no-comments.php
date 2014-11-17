<div class="entry-meta">

	<span class="date"><?php _e("Posted On", 'ivan_domain'); ?> <?php echo get_the_date(); ?></span>

	<?php _e("By", 'ivan_domain'); ?> <a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php the_author(); ?></a></span>

	<span class="cats"><?php _e("In", 'ivan_domain'); ?> <?php the_category(', '); ?></span>

	<span class="separator">/</span>	

	<?php echo getPostLikeLink( get_the_ID() ); ?>

</div><!-- .entry-meta -->