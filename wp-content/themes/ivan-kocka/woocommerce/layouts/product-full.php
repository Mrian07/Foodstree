<div class="col-xs-12 col-sm-12 col-md-12 site-main" role="main">

	<?php while ( have_posts() ) : the_post(); ?>

		<?php wc_get_template_part( 'content', 'single-product' ); ?>

	<?php endwhile; // end of the loop. ?>

</div>