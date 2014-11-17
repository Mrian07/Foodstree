<div class="col-xs-12 col-sm-9 col-md-9 pull-right site-main sidebar-enabled sidebar-left" role="main">

	<?php while ( have_posts() ) : the_post(); ?>

		<?php wc_get_template_part( 'content', 'single-product' ); ?>

	<?php endwhile; // end of the loop. ?>

</div>

<?php get_sidebar('product'); ?>