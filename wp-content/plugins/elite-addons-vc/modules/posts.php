<?php
/***
 * Module > Posts
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_ivan_posts extends WPBakeryShortCode {

		// Shortcode
		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract shortcode attributes
			extract( shortcode_atts( array(
				'loop' => '',
				'ivan_columns' => '3',
				'ivan_margin' => '', // no-margin to remove margins
				'layout' => 'grid', // grid, carousel, list or list-thumb
					'special' => '', // yes to enable special sizes
					'enable_sizes' => '', // yes to enable sizes by tag
				'ivan_img_size' => 'large',
				'post_style' => ' default-style',
				'd_gradient' => '',
				'ivan_zoom' => '', // zoom-hover to enable the effect
				'ivan_gray' => '', // gray-enabled to enable the effect
				'no_meta' => '',
				'no_date' => '',
				'no_cats' => '',
				'no_excerpt' => '',
				'chars_excerpt' => '',
				'd_chars_excerpt' => '',
				'one_cat' => 'yes',
				'ivan_carousel_nav' => 'yes', // Yes to enable carousel nav when avaliable
				'ivan_carousel_bullets' => 'no', // Yes to enable carousel bullets when avaliable

				'arrows_hover' => '',
				'arr_style' => 'style-outline-circle',
				'force_g' => 'yes',

				'el_class' => '',
				'template' => '',
			), $atts) );

			//$post_style = ' bottom-cover';
			//$layout = 'carousel';

			//$d_chars_excerpt = '160';

			if(empty($loop)) return '';

			$output = '';

			$loop_args = array();
			$query = false;
			list($loop_args, $query)  = vc_build_loop_query($loop, get_the_ID());

			$loop_args['ignore_sticky_posts'] = true;

			$query = new WP_Query($loop_args);

			//$output .= '<div>'.var_export($loop_args, true).'</div>';

			if(!$query)
				return;

			//
			// Start Customizer Prefix
			//
				$prefixClass = '';
				if( isset($atts['c_id']) ) {
					$this->prefix = $atts['c_id'] . ' ';
					$prefixClass = str_replace('.', '', $atts['c_id']);
				} else {
					$this->prefix = '.vc_custom_' . rand(25, 3000) . ' ';
					$prefixClass = str_replace('.', '', $this->prefix);
				}
			// End Customizer Prefix

			$containerClass = '';

			// Apply force gray cirlce
			if( $layout == 'carousel' && $ivan_carousel_bullets == 'yes' && $force_g == 'yes'  ) {
				$arr_style .= ' outer-gray';
				$el_class .= ' outer-gray';
			}

			if( $layout == 'carousel' && $ivan_carousel_bullets == 'yes' ) {
				$arr_style .= ' with-bullets';
				$el_class .= ' with-bullets';
				$containerClass .= ' with-bullets ';
			}

			if('yes' == $arrows_hover)
				$arr_style .= ' arrows-at-hover';

			$arrow_styles = $arr_style; // adds the final style
			
			// Load Scripts and Configure classes
			$ivan_query = $query;

			$colNumber = $ivan_columns;
			$columns = 12 / $colNumber; // 12 Bootstrap Columns / number of columns

			

			if($layout == 'masonry') {
				$layout = 'grid';
				$containerClass .= 'masonry-posts ';

			} else if($layout == 'grid') {
				$containerClass .= 'grid-posts ';
			}

			// Container Classes
			$containerClass .= 'ivan-posts ' . $layout;
			$containerClass .= ' row';
			$containerClass .= $ivan_margin;

			// Extra classes to add effects like zoom
			$additionalClass = '';
			$additionalClass .= $ivan_zoom;
			$additionalClass .= $ivan_gray;

			// Add custom template class
			if('' != $template)
				$el_class .= ' ' . $template;

			// Display Main Wrapper
			$output .= '<div class="ivan-posts-main-wrapper ' . $el_class . ' ' . $prefixClass . '">';
				$output .= '<div class="wpb_wrapper ivan-posts-inner">';

				if( $ivan_query->have_posts() ) :

					// Start Display Posts
					$output .= '<div class="ivan-posts-main">';

						// Enqueue carousel assets
						if( 'carousel' == $layout || is_admin() ) {
							wp_enqueue_script( 'ivan_owl_carousel' );
							wp_enqueue_style( 'ivan_owl_carousel' );
						}

						if( 'carousel' == $layout ) {
							// Adjust required when using carousel feature
							$columns = 12;
						}

						// Enqueue JS to start things
						wp_enqueue_script('ivan_vc_projects');

						$output .= '<div class="'.$containerClass.'">';

							$output .= '<div class="gutter-sizer"></div>';

							// Carousel Wrapper - it's required
							if( 'carousel' == $layout ) {
								$output .= '<div class="owl-carousel">';
							}

							//
							// START Query Loop
							ob_start();

							$counter = 1; // Will be used in special sizes

							while( $ivan_query->have_posts() ) : $ivan_query->the_post();

								$temp_chars_excerpt = $chars_excerpt;

								if('grid' == $layout OR 'carousel' == $layout) :

									$singleTags = '';
									// Allow better column control being local var
									$singleColumn = $columns;

									// Logic of Special Sizes goes below...
									if('yes' == $special && 'grid' == $layout && ($counter == 1 OR $counter == 2)) {

										if($singleColumn == 4) {
											$singleTags .= ' large-width';
											$singleColumn = 6;
										}

										else if($singleColumn == 3) {
											$singleTags .= ' large-width';
											$singleColumn = 6;
										}
										else if($singleColumn == 6 && $counter == 1) {
											$singleTags .= ' large-width';
											$singleColumn = 12;
										}
											
									}

									$singleColumnXS = '12';
									if('carousel' == $layout)
										$singleColumnXS = '12';

									// Logic of Sizes by Tag
									if('yes' == $enable_sizes) {
										$_tags = get_the_terms(get_the_ID(), apply_filters('ivan_project_sizes', 'ivan_vc_projects_sizes') );
										if($_tags) {
											foreach ($_tags as $_tag) {
												if($_tag->name == 'double-width') {
													if($singleColumn == 4) // 3 Cols
														$singleColumn = 8;
													else if($singleColumn == 3) // 4 Cols
														$singleColumn = 6;
													else if($singleColumn == 6) // 2 Cols
														$singleColumn = 12;

													$singleColumnXS = '12';
													$singleTags .= ' double-width';
													$singleTags .= ' large-width';

													if( $d_chars_excerpt != '' )
														$temp_chars_excerpt = $d_chars_excerpt;
												}
												else if($_tag->name == 'double-height') {
													$singleTags .= ' double-height';
												}
												else if($_tag->name == 'half-height') {
													$singleTags .= ' half-height';
												}
												else if($_tag->name == 'full') {
													$singleColumn = 12;
													$singleTags .= 'full-size';
													$singleColumnXS = '12';

													if( $d_chars_excerpt != '' )
														$temp_chars_excerpt = $d_chars_excerpt;
												}
											}
										}
									}

									// No Thumb logic below...
									$_thumbClass = '';
									if(has_post_thumbnail() == false) {
										$_thumbClass = ' no-thumb';
									}

									?>
									<div class="col-xs-<?php echo $singleColumnXS; ?> col-sm-<?php echo $singleColumn; ?> col-md-<?php echo $singleColumn; ?> ivan-post <?php echo $additionalClass . $singleTags; ?> <?php echo $post_style; ?>">
										<div class="ivan-post-inner">

											<a href="<?php the_permalink(); ?>" class="thumbnail <?php echo $_thumbClass; ?>">
												<?php echo get_the_post_thumbnail( get_the_ID(), $ivan_img_size ); ?>
												
												<?php if( $d_gradient != 'yes') : ?>
													<span class="ivan-hover-fx"></span>
												<?php endif; ?>

												<?php if( $post_style == ' simple-centered') : ?>
													<span class="entry-default"></span>
													<span class="more-cross"></span>
												<?php endif; ?>

											</a>

											<div class="entry">
												<div class="entry-inner">
													<div class="centered">

													<?php if($post_style != ' simple-centered') : ?>
														<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
													<?php endif; ?>

													<?php if('yes' != $no_meta && ( $post_style == ' border-cover' OR $post_style == ' bottom-cover' ) ) : ?>
														<div class="ivan-vc-separator small center"></div>
													<?php endif; ?>

													<?php if('yes' != $no_meta) : ?>
														<div class="meta">

															<?php
																$icon_cats = '<i class="fa fa-folder-open-o"></i> ';
																$icon_date = '<i class="fa fa-clock-o"></i> ';

																if($post_style == ' simple-centered') :
																	$icon_date = '';
																	$icon_cats = '';
																endif;
															?>
										
															<?php if( $no_cats != 'yes' ) :
																if('yes' == $one_cat) {
																	$cats = get_the_category();

																	if( isset($cats[0]) ) : ?>
																		<span class="cats"><?php echo $icon_cats; ?><a href="<?php echo get_category_link( $cats[0]->term_id ); ?>"><?php echo $cats[0]->cat_name; ?></a></span>
																	<?php endif;
																} else { ?>

																	<span class="cats"><?php echo $icon_cats; ?><?php the_category(', '); ?></span>

																<?php } // one_cat if ?>
															<?php endif; ?>

															<?php if( $no_date != 'yes' ) : ?>
																<span class="date"><?php echo $icon_date; ?><?php echo get_the_date(); ?></span>
															<?php endif; ?>
															
														</div>
													<?php endif; ?>

													<?php if($post_style == ' simple-centered') : ?>
														<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
													<?php endif; ?>

													<?php if( $no_excerpt != 'yes' && ($post_style != ' border-cover' && $post_style != ' bottom-cover' ) ) : ?>
														<?php if(has_excerpt()) : ?>
															<div class="excerpt">
																<?php 
																	$excerpt = get_the_excerpt();

																	if($temp_chars_excerpt != '') {
																		if($temp_chars_excerpt < strlen($excerpt) - 3)
																			$excerpt = substr($excerpt, 0, $temp_chars_excerpt) . apply_filters('iv_vc_excerpt_dots', '...');
																	}

																	echo $excerpt;
																?>
															</div>
														<?php endif; ?>
													<?php endif; ?>

													</div>
												</div><!-- .entry-inner -->
											</div><!-- .entry -->

										</div><!-- .ivan-post-inner -->
										<div></div>
									</div><!-- .ivan-post -->

								<?php
								// If is list layout
								elseif('list' == $layout) : ?>
									<div class="col-xs-12 col-sm-12 col-md-12 ivan-post <?php echo $additionalClass; ?>">
										<div class="ivan-post-inner">

											<div class="entry list">
												<div class="entry-inner">

													<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

													<?php if('yes' != $no_meta) : ?>
														<div class="meta">
															<?php
															if( $no_cats != 'yes' ) :
																if('yes' == $one_cat) {
																	$cats = get_the_category();

																	if( isset($cats[0]) ) : ?>
																		<span class="cats"><i class="fa fa-folder-open-o"></i> <a href="<?php echo get_category_link( $cats[0]->term_id ); ?>"><?php echo $cats[0]->cat_name; ?></a></span>
																	<?php endif;
																} else { ?>

																	<span class="cats"><i class="fa fa-folder-open-o"></i> <?php the_category(', '); ?></span>

																<?php } // one_cat if ?>
															<?php endif; ?>
															<?php if( $no_date != 'yes' ) : ?>
																<span class="date"><i class="fa fa-clock-o"></i> <?php echo get_the_date(); ?></span>
															<?php endif; ?>
														</div>
													<?php endif; ?>

													<?php if( $no_excerpt != 'yes') : ?>
														<?php if(has_excerpt()) : ?>
															<div class="excerpt">
																<?php 
																	$excerpt = get_the_excerpt();
																	if($chars_excerpt != '') {
																		if($chars_excerpt < strlen($excerpt) - 3)
																			$excerpt = substr($excerpt, 0, $chars_excerpt) . apply_filters('iv_vc_excerpt_dots', '...');
																	}
																	echo $excerpt;
																?>
															</div>
														<?php endif; ?>
													<?php endif; ?>

												</div><!-- .entry-inner -->
											</div><!-- .entry -->

										</div><!-- .ivan-post-inner -->
									</div><!-- .ivan-post -->

								<?php
								// If is list-thumb layout
								elseif('list-thumb' == $layout) : ?>

									<?php
										$columnThumb = 2;
										$columnMeta = 10;
										$localClasses = '';

										if($counter == 1 && 'yes' == $special) {
											$columnThumb = 12;
											$columnMeta = 12;

											$localClasses .= ' first-post';
										}
										else {
											$ivan_img_size = 'thumbnail';
											$localClasses .= ' normal-post';
										}

										// No Thumb logic below...
										$_thumbClass = '';
										if(has_post_thumbnail() == false) {
											$_thumbClass = ' no-thumb';
										}
									?>
									<div class="col-xs-12 col-sm-12 col-md-12 ivan-post <?php echo $additionalClass . $localClasses; ?>">
										<div class="ivan-post-inner">

											<a href="<?php the_permalink(); ?>" class="thumbnail <?php echo $_thumbClass; ?>">
												<span class="ivan-hover-fx"></span>
												<?php echo get_the_post_thumbnail( get_the_ID(), $ivan_img_size ); ?>
											</a>

											<div class="entry list-thumb">
												<div class="entry-inner">

													<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

													<?php if('yes' != $no_meta) : ?>
														<div class="meta">
															<?php
															if( $no_cats != 'yes' ) :
																if('yes' == $one_cat) {
																	$cats = get_the_category();

																	if( isset($cats[0]) ) : ?>
																		<span class="cats"><i class="fa fa-folder-open-o"></i> <a href="<?php echo get_category_link( $cats[0]->term_id ); ?>"><?php echo $cats[0]->cat_name; ?></a></span>
																	<?php endif;
																} else { ?>

																	<span class="cats"><i class="fa fa-folder-open-o"></i> <?php the_category(', '); ?></span>

																<?php } // one_cat if ?>
															<?php endif; ?>
															<?php if( $no_date != 'yes' ) : ?>
																<span class="date"><i class="fa fa-clock-o"></i> <?php echo get_the_date(); ?></span>
															<?php endif; ?>
														</div>
													<?php endif; ?>

													<?php if( $no_excerpt != 'yes' OR ( $counter == 1 && 'yes' == $special ) ) : ?>
														<?php if(has_excerpt()) : ?>
															<div class="excerpt">
																<?php 
																	$excerpt = get_the_excerpt();

																	if( $d_chars_excerpt != '' && ( $counter == 1 && 'yes' == $special ) )
																		$temp_chars_excerpt = $d_chars_excerpt;

																	if($temp_chars_excerpt != '') {
																		if($temp_chars_excerpt < strlen($excerpt) - 3)
																			$excerpt = substr($excerpt, 0, $temp_chars_excerpt) . apply_filters('iv_vc_excerpt_dots', '...');
																	}

																	echo $excerpt;
																?>
															</div>
														<?php endif; ?>
													<?php endif; ?>

												</div><!-- .entry-inner -->
											</div><!-- .entry -->

										</div><!-- .ivan-post-inner -->
										<div></div>

										<div class="clearfix"></div><!-- .clearfix -->
									</div><!-- .ivan-post -->
								
								<?php endif; // end check layout ?>

								<?php
								$counter++; // Increase the counter...
							endwhile;
							$output .= ob_get_clean();
							wp_reset_query();
							// END Query Loop
							//

							// Carousel Wrapper - it's required
							if( 'carousel' == $layout ) {
								$output .= '</div>';
							}

						$output .= '</div>'; // .row

					$output .= '</div>'; // .ivan-posts-main

				endif; // end have_posts

				$output .= '</div>';// .ivan-posts-inner
			$output .= '</div>';// .ivan-posts-main-wrapper

			// Store Carousel Code
			$carouselCode = '';

			if( 'carousel' == $layout ) {

				$_prefix = $prefixClass;

				$carouselCode .= '
					var _carousel = jQuery(".'.$_prefix.' .owl-carousel");
					var _navH = 0;
				';

				$carouselCode .= '
				_carousel.owlCarousel({
					items: '. $colNumber .',
					theme: "'. $arrow_styles . '",
					itemsDesktop:[1199,'. $colNumber .'],
					autoHeight: true';

				if($ivan_columns == '1')
					$carouselCode .= ',singleItem: true';

				if('yes' == $ivan_carousel_nav) {
				$carouselCode .= ',navigation: true,
					navigationText: [\'<i class="fa fa-angle-left"></i>\', \'<i class="fa fa-angle-right"></i>\']';
				}

				if('yes' == $ivan_carousel_bullets) {
				$carouselCode .= ',pagination: true';
				}
				else {
					$carouselCode .= ',pagination: false';
				}

				$carouselCode .= '});';			

				/*if('yes' == $ivan_carousel_nav) {

					if('yes' == $ivan_carousel_bullets)
						$carouselCode .= '
						_carousel.find(".owl-controls").each(function() {
							_navH = jQuery(this).outerHeight(true) / 2;
						});
						';

					$carouselCode .= '
						_carousel.find(".owl-buttons div").each(function(){
							var _h = (jQuery(this).outerHeight() / 2) + _navH;
							jQuery(this).css("margin-top", "-" + _h + "px" );
						});
					';
				}
				*/
			}

			if(!is_admin()) {

				if('carousel' == $layout) :
					$output .= '<script type="text/javascript">
						jQuery(document).ready( function() {
							';
						
							$output .= $carouselCode;
						
					$output .= '});</script>';
				endif;
			
			} else {
				$output .= '<textarea class="ivan-script">

					jQuery(document).ready( function() {
						';

					if('grid' == $layout) :
						$output .= 'ivan_vc_init_blog();';
					endif;

					if('carousel' == $layout) :
						$output .= $carouselCode;
					endif;

				$output .= '});</textarea>';
			}							

			//
			// Customizer CSS Output
			//
				$style = '';
				foreach ($this->selectors as $key => $value) {
					if( isset($atts[$key]) && '' != $atts[$key]) {
						$style .= ivan_vc_customizer_get_style( $atts[$key], $this->selectors[$key], $this->prefix );
					}
				}

				// Print style
				if(is_admin()) {
					$output .= '<style type="text/css">'
					. $style
					. '</style>';
				}
				else {
					$ivan_custom_css .= $style;
				}
			// End Customizer Output
			
			return $output;
		}

		// H1 Selectors
		public $selectors = array(
			'post_css' => array(
				// Font
				//'font-family' => 'h1',
				//'font-weight' => 'h1',
				//'font-size' => 'h1',
				//'line-height' => 'h1',
				//'color' => 'h1',
				// Spacing
				'margin-top' => '.ivan-post-inner',
				'margin-right' => '.ivan-post-inner',
				'margin-bottom' => '.ivan-post-inner',
				'margin-left' => '.ivan-post-inner',
				'padding-top' => '.ivan-post-inner',
				'padding-right' => '.ivan-post-inner',
				'padding-bottom' => '.ivan-post-inner',
				'padding-left' => '.ivan-post-inner',
				// Bg
				'background-color' => '.ivan-post-inner',
				// Border
				'border-top-width' => '.ivan-post-inner',
				'border-right-width' => '.ivan-post-inner',
				'border-bottom-width' => '.ivan-post-inner',
				'border-left-width' => '.ivan-post-inner',
				'border-style' => '.ivan-post-inner',
				'border-color' => '.ivan-post-inner',
				// Border Radius
				'border-top-left-radius' => '.ivan-post-inner',
				'border-top-right-radius' => '.ivan-post-inner',
				'border-bottom-left-radius' => '.ivan-post-inner',
				'border-bottom-right-radius' => '.ivan-post-inner',
				// Hovers
				//'color-hover' => 'a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
			'thumb_css' => array(
				// Font
				//'font-family' => 'h1',
				//'font-weight' => 'h1',
				//'font-size' => 'h1',
				//'line-height' => 'h1',
				//'color' => 'h1',
				// Spacing
				//'margin-top' => '.entry-inner',
				//'margin-right' => '.entry-inner',
				//'margin-bottom' => '.entry-inner',
				//'margin-left' => '.entry-inner',
				//'padding-top' => '.entry-inner',
				//'padding-right' => '.entry-inner',
				//'padding-bottom' => '.entry-inner',
				//'padding-left' => '.entry-inner',
				// Bg
				//'background-color' => '.entry-inner',
				// Border
				'border-top-width' => '.thumbnail',
				'border-right-width' => '.thumbnail',
				'border-bottom-width' => '.thumbnail',
				'border-left-width' => '.thumbnail',
				'border-style' => '.thumbnail',
				'border-color' => '.thumbnail',
				// Border Radius
				'border-top-left-radius' => '.thumbnail, img',
				'border-top-right-radius' => '.thumbnail, img',
				'border-bottom-left-radius' => '.thumbnail, img',
				'border-bottom-right-radius' => '.thumbnail, img',
				// Hovers
				//'color-hover' => 'a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
			'entry_css' => array(
				// Font
				//'font-family' => 'h1',
				//'font-weight' => 'h1',
				//'font-size' => 'h1',
				//'line-height' => 'h1',
				//'color' => 'h1',
				// Spacing
				'margin-top' => '.entry',
				'margin-right' => '.entry',
				'margin-bottom' => '.entry',
				'margin-left' => '.entry',
				'padding-top' => '.entry-inner',
				'padding-right' => '.entry-inner',
				'padding-bottom' => '.entry-inner',
				'padding-left' => '.entry-inner',
				// Bg
				'background-color' => '.entry-inner',
				// Border
				'border-top-width' => '.entry-inner',
				'border-right-width' => '.entry-inner',
				'border-bottom-width' => '.entry-inner',
				'border-left-width' => '.entry-inner',
				'border-style' => '.entry-inner',
				'border-color' => '.entry-inner',
				// Border Radius
				'border-top-left-radius' => '.entry-inner',
				'border-top-right-radius' => '.entry-inner',
				'border-bottom-left-radius' => '.entry-inner',
				'border-bottom-right-radius' => '.entry-inner',
				// Hovers
				//'color-hover' => 'a:hover',
				'border-color-hover' => '.entry:hover .entry-inner',
				//'background-color-hover' => 'a:hover',
			),
			'title_css' => array(
				// Font
				'font-family' => '.entry h3',
				'font-weight' => '.entry h3',
				'font-size' => '.entry h3',
				'line-height' => '.entry h3',
				'text-transform' => '.entry h3',
				'color' => '.entry h3 a',
				'text-align' => '.entry h3',
				// Spacing
				'margin-top' => '.entry h3',
				'margin-right' => '.entry h3',
				'margin-bottom' => '.entry h3',
				'margin-left' => '.entry h3',
				//'padding-top' => '.entry h3 a',
				//'padding-right' => '.entry h3 a',
				//'padding-bottom' => '.entry h3 a',
				//'padding-left' => '.entry h3 a',
				// Bg
				'background-color' => '.entry h3 a',
				// Border
				//'border-top-width' => '.entry h3 a',
				//'border-right-width' => '.entry h3 a',
				//'border-bottom-width' => '.entry h3 a',
				//'border-left-width' => '.entry h3 a',
				//'border-style' => '.entry h3 a',
				//'border-color' => '.entry h3 a',
				// Hovers
				'color-hover' => '.entry h3 a:hover',
				//'border-color-hover' => '.entry h3 a:hover',
				//'background-color-hover' => '.entry h3 a:hover',
			),
			'meta_css' => array(
				// Font
				'font-family' => '.meta',
				'font-weight' => '.meta',
				'font-size' => '.meta',
				'line-height' => '.meta',
				'text-transform' => '.meta',
				'color' => '.meta, .meta a',
				'text-align' => '.meta',
				// Spacing
				'margin-top' => '.meta',
				'margin-right' => '.meta',
				'margin-bottom' => '.meta',
				'margin-left' => '.meta',
				//'padding-top' => '.meta',
				//'padding-right' => '.meta',
				//'padding-bottom' => '.meta',
				//'padding-left' => '.meta',
				// Bg
				//'background-color' => '.entry-inner',
				// Border
				//'border-top-width' => 'h1',
				//'border-right-width' => 'h1',
				//'border-bottom-width' => 'h1',
				//'border-left-width' => 'h1',
				//'border-style' => 'h1',
				//'border-color' => 'h1',
				// Hovers
				'color-hover' => '.meta a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
			'excerpt_css' => array(
				// Font
				'font-family' => '.entry .excerpt',
				'font-weight' => '.entry .excerpt',
				'font-size' => '.entry .excerpt',
				'line-height' => '.entry .excerpt',
				'text-transform' => '.entry .excerpt',
				'color' => '.entry .excerpt',
				'text-align' => '.entry .excerpt',
				// Spacing
				'margin-top' => '.entry .excerpt',
				'margin-right' => '.entry .excerpt',
				'margin-bottom' => '.entry .excerpt',
				'margin-left' => '.entry .excerpt',
				//'padding-top' => '.entry .excerpt',
				//'padding-right' => '.entry .excerpt',
				//'padding-bottom' => '.entry .excerpt',
				//'padding-left' => '.entry .excerpt',
				// Bg
				//'background-color' => '.entry-inner',
				// Border
				//'border-top-width' => 'h1',
				//'border-right-width' => 'h1',
				//'border-bottom-width' => 'h1',
				//'border-left-width' => 'h1',
				//'border-style' => 'h1',
				//'border-color' => 'h1',
				// Hovers
				//'color-hover' => '.entry h3 a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
			'mark_css' => array(
				// Bg
				'background-color' => '.ivan-vc-separator.small',
				// Dimensions
				'width' => '.ivan-vc-separator.small',
				'height' => '.ivan-vc-separator.small',
				// Spacing
				'margin-top' => '.ivan-vc-separator.small',
				'margin-right' => '.ivan-vc-separator.small',
				'margin-bottom' => '.ivan-vc-separator.small',
				'margin-left' => '.ivan-vc-separator.small',
			),
			'bullets_css' => array(
				// Font
				//'font-family' => '.ivan-vc-filters a',
				//'font-weight' => '.ivan-vc-filters a',
				//'font-size' => '.ivan-vc-filters a',
				//'line-height' => '.ivan-vc-filters a',
				//'text-transform' => '.ivan-vc-filters a',
				//'color' => '.owl-buttons div',
				// Dimensions
				'width' => '.owl-controls .owl-page span',
				'height' => '.owl-controls .owl-page span',
				// Spacing
				'margin-top' => '.owl-pagination',
				'margin-bottom' => '.owl-pagination',
				'margin-right' => '.owl-controls .owl-page span',
				'margin-left' => '.owl-controls .owl-page span',
				'padding-top' => '.owl-controls .owl-page span',
				'padding-right' => '.owl-controls .owl-page span',
				'padding-bottom' => '.owl-controls .owl-page span',
				'padding-left' => '.owl-controls .owl-page span',
				// Border Radius
				'border-top-left-radius' => '.owl-controls .owl-page span',
				'border-top-right-radius' => '.owl-controls .owl-page span',
				'border-bottom-left-radius' => '.owl-controls .owl-page span',
				'border-bottom-right-radius' => '.owl-controls .owl-page span',
				// Bg
				'background-color' => '.owl-controls .owl-page span',
				// Border
				'border-top-width' => '.owl-controls .owl-page span',
				'border-right-width' => '.owl-controls .owl-page span',
				'border-bottom-width' => '.owl-controls .owl-page span',
				'border-left-width' => '.owl-controls .owl-page span',
				'border-style' => '.owl-controls .owl-page span',
				'border-color' => '.owl-controls .owl-page span',
				// Hovers
				//'color-hover' => '.owl-controls .owl-page span:hover, .owl-controls .owl-page.active span',
				'border-color-hover' => '.owl-controls .owl-page span:hover, .owl-controls .owl-page.active span',
				'background-color-hover' => '.owl-controls .owl-page span:hover, .owl-controls .owl-page.active span',
			),
			'navigation_css' => array(
				// Font
				//'font-family' => '.ivan-vc-filters a',
				//'font-weight' => '.ivan-vc-filters a',
				'font-size' => '.owl-buttons div',
				//'line-height' => '.ivan-vc-filters a',
				//'text-transform' => '.ivan-vc-filters a',
				'color' => '.owl-buttons div',
				// Dimensions
				'width' => '.owl-buttons div',
				'height' => '.owl-buttons div',
				// Spacing
				'padding-top' => '.owl-buttons div',
				'padding-right' => '.owl-buttons div',
				'padding-bottom' => '.owl-buttons div',
				'padding-left' => '.owl-buttons div',
				// Border Radius
				'border-top-left-radius' => '.owl-buttons div',
				'border-top-right-radius' => '.owl-buttons div',
				'border-bottom-left-radius' => '.owl-buttons div',
				'border-bottom-right-radius' => '.owl-buttons div',
				// Bg
				'background-color' => '.owl-buttons div',
				// Border
				'border-top-width' => '.owl-buttons div',
				'border-right-width' => '.owl-buttons div',
				'border-bottom-width' => '.owl-buttons div',
				'border-left-width' => '.owl-buttons div',
				'border-style' => '.owl-buttons div',
				'border-color' => '.owl-buttons div',
				// Hovers
				'color-hover' => '.owl-buttons div:hover',
				'border-color-hover' => '.owl-buttons div:hover',
				'background-color-hover' => '.owl-buttons div:hover',
			),
		);

		public $prefix = '';

	} // #end class

	// Init global var to store this module data
	global $ivan_vc_posts;
	$ivan_vc_posts = new WPBakeryShortCode_ivan_posts( array('name' => 'Posts', 'base' => 'ivan_posts') );

 } // #end class check