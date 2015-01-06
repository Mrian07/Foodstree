<?php
/**
 *
 * Template Part called at class Ivan_Layout_Title_Wrapper_Normal
 *
 * @package   IvanFramework
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Your Name or Company Name
 * @version 1.0
 * @since 1.0
 */

$_classes = '';

// Alternative Color Schemes
if( ivan_get_option('title-wrapper-color-scheme') != null ) {
	$_classes .= ' ' . ivan_get_option('title-wrapper-color-scheme');
}

?>

<div id="iv-layout-title-wrapper" class="<?php echo apply_filters( 'iv_title_wrapper_classes', 'iv-layout title-wrapper title-wrapper-normal '. $_classes ); ?>">
	<div class="container">
		<div class="row">

			<div class="col-xs-12 col-sm-12 col-md-12 ivan-title-inner">
				<?php do_action('ivan_display_title'); // Display Title ?>

				<?php // Display optional description of home
				if( is_home() || is_singular('post') ) :
					if( ivan_get_option('title-desc-blog') != '' ) : ?>
						<div class="title-description">
							<p><?php echo nl2br(ivan_get_option('title-desc-blog')); ?>fggg</p>
						</div>
					<?php 
					endif;

				 // Display optional description to pages or projects, for example
				elseif( is_singular() ) :
					if( ivan_get_post_option('title-sub-text') != '' ) : ?>
						<div class="title-description">
							<p><?php echo nl2br(ivan_get_post_option('title-sub-text')); ?></p>
						</div>
					<?php 
					endif;
				endif;
				?>

				<?php if( ivan_get_option('breadcrumb-enable') ) : ?>
					<?php get_template_part('framework/templates/title_wrapper/part', 'breadcrumb'); ?>
				<?php endif; ?>

			</div>

		</div>
	</div>
</div>