<?php get_header(); ?>


<div class="container">

	<h2><?php echo get_seller_name(get_query_id()); ?></h2>

	<?php echo seller_listing(get_query_id()); ?>

</div>


<?php get_footer(); ?>