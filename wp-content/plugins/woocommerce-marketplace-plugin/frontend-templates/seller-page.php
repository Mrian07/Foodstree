<?php get_header(); ?>


<div class="container">

	<?php
	$seller_id = get_userid_by_company(get_query_var('seller'));
	if($seller_id){
	?>


	<h2><?php echo get_seller_display_name($seller_id); ?></h2>

	<?php echo seller_listing($seller_id); ?>

	<?php } ?>

</div>


<?php get_footer(); ?>