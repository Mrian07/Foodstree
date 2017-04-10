<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package ivan_framework
 */
?>

		<?php 
		/* @todo: adds who is being hooked */
		do_action( 'ivan_footer_section' ); 
		?>

	<?php
	/* @todo: adds who is being hooked */
	do_action( 'ivan_after' ); 
	?>

</div><!-- #all-site-wrapper -->

<?php wp_footer(); ?>

</body>
</html>

<script type="text/javascript">
  
  jQuery("#menu-item-2074").on("click", function(e){ 
      e.preventDefault();
      jQuery('#main-div').fadeIn();
  });
  
</script>

