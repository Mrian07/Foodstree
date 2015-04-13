<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package ivan_framework
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '-', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon.png" />


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>



<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>



<!-- Pincode modal -->
<div id="pincodepop">

<div id="pincode_city_cont">
<h2 class="title-heading-header">
				ENTER CITY
		</h2><br>
<input type="text" name="pincode-city" id="pincode-city" /><span id="cityloader"></span>
<ul id="pincode_city_list" style="display:none;"></ul>
</div>

<div id="pinlist_loader" style="display:none"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/pinloader.gif" /></div>

<div id="pincodelistwrap" style="display:none;"></div>


<!-- <div id="pincode_ent">
<span>Pincode: </span>
<input type="text" name="pincode" id="pincode" />
</div>


<button id="pincode-btn">Submit</button> -->
</div>
<div id="background" class="background_overlay"></div>




<?php get_template_part('part', 'loader'); ?>

<?php flush(); ?>

<div id="all-site-wrapper" class="hfeed site">

	<a href="#" id="back-top">
		<i class="fa fa-angle-up " style=""></i>
	</a>

	<?php
	/* @todo: adds who is being hooked */
	do_action( 'ivan_before' ); 
	?>

		<?php 
		/* @todo: adds who is being hooked */
		do_action( 'ivan_header_section' );
		?>

		<?php 
		// Dynamic Area displayed here...
		if( true == ivan_get_option('header-da-after-enable') ) : ?>
		<div class="<?php echo apply_filters('iv_dynamic_header_classes', 'iv-layout dynamic-header dynamic-header-after'); ?>">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
					<?php
						$_id = ivan_get_option('header-da-after');
						ivan_display_dynamic_area( $_id, true );
					?>
					</div>
				</div>
			</div>
		</div>


	<?php endif; ?>