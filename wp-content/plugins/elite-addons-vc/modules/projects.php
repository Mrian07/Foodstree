<?php
/***
 * Module > Projects
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_ivan_projects extends WPBakeryShortCode {

		// Shortcode
		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract shortcode attributes
			extract( shortcode_atts( array(
				'ivan_columns' => '4',
				'ivan_type' => 'mansory',
				'ivan_cpt' => 'ivan_vc_projects',
				'ivan_margin' => '',
				'ivan_zoom' => ' zoom-hover',
				'ivan_cover' => '',
				'ivan_grayscale' => 'no',
				'ivan_cover_hover' => ' appear-hover',
				'ivan_posts_per_page' => 10,
				'ivan_img_size' => 'large',
				'ivan_custom_height' => '',
				'ivan_sortable_filters' => 'no',
				'ivan_enable_cover' => 'yes',
					'ivan_enable_title' => 'yes',
					'ivan_enable_categories' => 'yes',
					'ivan_enable_excerpt' => 'no',
					'ivan_enable_read_more' => 'no',
					'ivan_enable_read_more_txt' => 'View More',
				'ivan_category' => '',
				'ivan_portfolio' => '',
				'ivan_carousel_nav' => 'yes',
				'ivan_carousel_bullets' => 'yes',
				'ivan_enable_sizes' => 'no',
				'ivan_open' => '',
				'ico_family' => 'fa fa-',
				'ico' => '',
				'ico_custom' => '',
				'all_txt' => __('All', 'iv_js_composer'),
				'filter_align' => '',
				'chars_excerpt' => '',
				'd_chars_excerpt' => '',
				'el_class' => '',
				'template' => '',

				'arrows_hover' => '',
				'arr_style' => 'style-outline-circle',
				'force_g' => 'yes',

				'rel_id' => '',
				'rel_tags' => '',
			), $atts) );
			
			$output = '';

			// Test vars to enable everything
			//$ivan_enable_excerpt = 'yes';
			//$ivan_enable_read_more = 'yes';
			//$chars_excerpt = '50';

			//$ivan_cover = '';
			//$ivan_cover = ' light-caption';
			//$ivan_cover = ' hide-entry';
			//$ivan_cover = ' cover-entry';

			//$ivan_cover = ' soft-cover';
			//$ivan_cover = ' outer-square';
			//$ivan_cover = ' lateral-cover';
			//$ivan_cover = ' smooth-cover';
			//$ivan_cover = ' border-cover';

			/*
			$ivan_enable_title = 'no';
			$ivan_enable_categories = 'no';
			$ivan_enable_excerpt = '';
			$ivan_enable_read_more = '';
			$ico = '';
			*/

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

			// Apply force gray cirlce
			if( $ivan_type == 'carousel' && $ivan_carousel_bullets == 'yes' && $force_g == 'yes'  ) {
				$arr_style .= ' outer-gray';
				$el_class .= ' outer-gray';
			}

			if( $ivan_type == 'carousel' && $ivan_carousel_bullets == 'yes' ) {
				$arr_style .= ' with-bullets';
				$el_class .= ' with-bullets';
			}

			if('yes' == $arrows_hover)
				$arr_style .= ' arrows-at-hover';

			$arrow_styles = $arr_style; // adds the final style

			// Args
			$args = array(
				'post_type' => apply_filters('ivan_project_post_type', $ivan_cpt),
				'posts_per_page' => $ivan_posts_per_page,
				'post_status' => 'publish',
			);

			if('' != $ivan_category) {
				$args[apply_filters('ivan_project_cats', 'ivan_vc_projects_cats')] = $ivan_category;
			}

			if('' != $ivan_portfolio) {
				$args[apply_filters('ivan_project_portfolio', 'ivan_vc_projects_portfolios')] = $ivan_portfolio;
			}

			// Used by Related Posts
			if($rel_id != '') {
				$args['post__not_in'] = array($rel_id);

				$args['ivan_vc_projects_cats'] = $rel_tags;
			}

			$ivan_query = new WP_Query( $args );

			$colNumber = $ivan_columns;
			$columns = 12 / $colNumber; // 12 Bootstrap Columns / number of columns

			// Container
			$type = $ivan_type;

			$containerClass = 'ivan-projects ivan-projects-' . $type;
			$containerClass .= ' row';
			$containerClass .= $ivan_margin;

			// If prefix is not defined
			if('' == $this->prefix) {
				$this->prefix = 'vc_custom_' . rand(25, 15000);
			}

			// Add custom template class
			if('' != $template)
				$el_class .= ' ' . $template;

			$mainWrapperClass = '';
			if($ivan_cover != '')
				$mainWrapperClass = $ivan_cover.'-wrapper';

			$output .= '<div class="ivan-projects-main-wrapper '.$mainWrapperClass.' '. $el_class .' ' . $prefixClass . '">';

			// Removes Zoom Effect when Outer Square
			//if( ' outer-square' == $ivan_cover )

			//	$ivan_zoom = '';

			$additionalClass = '';
			$additionalClass .= $ivan_zoom;
			$additionalClass .= $ivan_cover;
				$additionalClass .= $ivan_cover_hover;

			// Adds default cover class
			if( $ivan_cover == '' )
				$additionalClass .= ' default-caption';

			if('yes' == $ivan_grayscale)
				$additionalClass .= ' gray-enabled';

			if( $ivan_enable_title == 'no' && $ivan_enable_categories == 'no' && $ivan_enable_excerpt == '')
				$additionalClass .= ' only-icon-btn';

			if( $ivan_enable_title == 'no' && $ivan_enable_categories == 'no' && $ivan_enable_excerpt == '' && $ivan_enable_read_more == '')
				$additionalClass .= ' only-icon';

			if( $ivan_enable_title == 'no' && $ivan_enable_categories == 'no' && $ivan_enable_excerpt == '' && ('' == $ico && '' == $ico_custom) )
				$additionalClass .= ' only-icon';

			// Icon Logic
			$icon_markup = '';

			if( (' cover-entry' == $ivan_cover OR ' soft-cover' == $ivan_cover ) && ('' != $ico || '' != $ico_custom) ) {
				$icon_markup = '<i class="'.$ico_family.$ico.'"></i>';
					
				if('' != $ico_custom)
					$icon_markup = '<i class="'.$ico_custom.'"></i>';
			}

			if( $ivan_query->have_posts() ) :

			if( 'carousel' == $type || is_admin() ) {
				wp_enqueue_script( 'ivan_owl_carousel' );
				wp_enqueue_style( 'ivan_owl_carousel' );
			}

			if( 'carousel' == $type ) {
				$columns = 12;
			}

			wp_enqueue_script('ivan_vc_projects');

			// Sortable
			$enableSortable = $ivan_sortable_filters;

			if('yes' == $enableSortable && 'carousel' != $type) {
				$filters = get_terms(apply_filters('ivan_project_filters', "ivan_vc_projects_cats") );

				if( 0 < count($filters) ) {
					$output .= '<div class="ivan-vc-filters-wrapper"><div class="ivan-vc-filters '.$filter_align.'">';

					$output .= apply_filters('ivan_filter_grid', '<span class="filter-grid"><i class="fa fa-th"></i></span>');

					$output .= '<a href="#" data-filter="all" class="current">'. $all_txt .'</a>';

					foreach ($filters as $filter) {
						$filterName = strtolower($filter->name);
						$filterName = str_replace(' ', '-', $filterName);

						$output .= '<a href="#" data-filter="'.$filterName.'">'. $filter->name . '</a>';
					}

					$output .= '</div></div>';
				}
			}

			$output .= '<div class="'.$containerClass.'">';

			$output .= '<div class="gutter-sizer"></div>';

			// Carousel Markup
			if( 'carousel' == $type ) {
				$output .= '<div class="owl-carousel">';
			}

				ob_start();
				while( $ivan_query->have_posts() ) : $ivan_query->the_post();

					$temp_chars_excerpt = $chars_excerpt;

					// Sortable Magin
					$sortableData = '';

					// Categories
					$categories = '';

					$filters = get_the_terms(get_the_ID(), apply_filters('ivan_project_filters', "ivan_vc_projects_cats") );
					if ( $filters && ! is_wp_error( $filters ) ) {
						$ids = array('all');
						$cats = array();
						foreach ( $filters as $filter ) {
							$cats[] = $filter->name;
							$ids[] = strtolower($filter->name);
						}
						
						$ids = str_replace(' ', '-', $ids);	

						// join ids in a single string
						$sortableData = join( " ", $ids );

						// join IDs splitted by comma
						$categories = join( ", ", $cats);
					}

					$singleColumn = $columns;
					$singleTags = '';
					
					$singleColumnXS = '6';
					if('carousel' == $type OR $ivan_columns == '1')
						$singleColumnXS = '12';

					// If mansory, apply custom tags to change size
					if('mansory' == $type && 'yes' == $ivan_enable_sizes) {
						$_tags = get_the_terms(get_the_ID(), apply_filters('ivan_project_sizes', "ivan_vc_projects_sizes") );
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
				
				?>

				<?php
				// Permalink or lightbox logic
				$_permalink = get_permalink();

				if('lightbox' == $ivan_open && true == has_post_thumbnail() ) {
					$lightboxImg = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
					$_permalink = $lightboxImg[0];

					$additionalClass .= ' with-lightbox';
				}

				?>

				<div class="col-xs-<?php echo $singleColumnXS; ?> col-sm-<?php echo $singleColumn; ?> col-md-<?php echo $singleColumn; ?> taphover ivan-project <?php echo $singleTags; ?> <?php echo $additionalClass; ?> <?php echo $sortableData; ?>">

					<div class="ivan-project-inner">

						<?php
						// Custom Thumbnail Height
						$_customHeight = '';
						$_thumbClass = '';
						if( $ivan_custom_height != '') {
							$_customHeight = 'height:' . $ivan_custom_height . 'px;';
						}

						if(has_post_thumbnail() == false) {
							$_thumbClass = ' no-thumb';
						}
						?>

						<a href="<?php echo $_permalink; ?>" class="thumbnail<?php echo $_thumbClass; ?>" style="<?php echo $_customHeight; ?>">
							<?php echo get_the_post_thumbnail( get_the_ID(), $ivan_img_size ); ?>

							<span class="ivan-hover-fx"></span>

							<?php if( $ivan_cover == '' OR $ivan_cover == ' light-caption') : ?>
								<span class="entry-default"></span>
								<span class="more-cross"></span>
							<?php endif; ?>

						</a>

						<?php if('yes' == $ivan_enable_cover) : ?>
						<div class="entry">
							<div class="entry-inner">

								<?php if( ' soft-cover' == $ivan_cover ) : ?>
									<a href="<?php echo $_permalink; ?>" class="soft-link-overlay"></a>
								<?php endif; ?>

								<div class="centered">

									<?php if( (' cover-entry' == $ivan_cover OR ' soft-cover' == $ivan_cover ) && ('' != $ico || '' != $ico_custom) ) : ?>
										<div class="icon-wrapper"><a href="<?php echo $_permalink; ?>" class="icon-inner"><?php echo $icon_markup; ?></a></div>
									<?php endif; ?>

									<?php if('yes' == $ivan_enable_title) : ?>
									<h3><a href="<?php echo $_permalink; ?>"><?php the_title(); ?></a></h3>
									<?php endif; ?>

									<?php if('' != $categories && 'yes' == $ivan_enable_categories) : ?>
										<div class="categories">
											<?php echo $categories; ?>
										</div>
									<?php endif; ?>

									<?php if( ( ' outer-square' == $ivan_cover OR ' lateral-cover' == $ivan_cover ) OR ( ( ' smooth-cover' == $ivan_cover OR ' border-cover' == $ivan_cover ) && $ivan_enable_excerpt == 'yes' ) ) : ?>
										<div class="ivan-vc-separator small left"></div> 
									<?php endif; ?>

									<?php if('yes' == $ivan_enable_excerpt) : ?>
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

									<?php if('yes' == $ivan_enable_read_more && (' cover-entry' == $ivan_cover OR ' soft-cover' == $ivan_cover OR ' outer-square' == $ivan_cover OR ' lateral-cover' == $ivan_cover ) ) : ?>
									<div class="read-more">
										<a href="<?php echo $_permalink; ?>" class="button"><?php echo $ivan_enable_read_more_txt; ?></a>
									</div>
									<?php endif; ?>

								</div>
							</div>
						</div>
						<?php endif; ?>
					</div>

					<div></div>
				</div>

				<?php
				endwhile;
				$output .= ob_get_clean();

				if( 'carousel' == $type ) {
					$output .= '</div>';
				}
			$output .= '</div>';// #row
			$output .= '</div>';// #main-wrapper

			// Store Carousel Code
			$carouselCode = '';

			if( 'carousel' == $type ) {

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
				}*/
			}

			if(!is_admin()) {

				if('carousel' == $type) :
					$output .= '<script type="text/javascript">
						jQuery(document).ready( function() {
							';
						
							$output .= $carouselCode;
						
					$output .= '});</script>';
				endif;
			
			} else {
				$output .= '<textarea class="ivan-script">

					jQuery(document).ready( function() {

						ivan_vc_init_mansory();
						ivan_vc_init_grid();
						';

					if('carousel' == $type) :
						$output .= $carouselCode;
					endif;

				$output .= '});</textarea>';
			}		

			wp_reset_query();

			endif;// #end main query
			
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
			'thumb_css' => array(
				// Font
				//'font-family' => 'h1',
				//'font-weight' => 'h1',
				//'font-size' => 'h1',
				//'line-height' => 'h1',
				//'color' => 'h1',
				// Spacing
				//'margin-top' => '.ivan-project .entry',
				//'margin-right' => '.ivan-project .entry',
				//'margin-bottom' => '.ivan-project .entry',
				//'margin-left' => '.ivan-project .entry',
				//'padding-top' => '.ivan-project .entry-inner',
				//'padding-right' => '.ivan-project .entry-inner',
				//'padding-bottom' => '.ivan-project .entry-inner',
				//'padding-left' => '.ivan-project .entry-inner',
				// Bg
				//'background-color' => '.ivan-project .entry',
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
				'margin-top' => '.ivan-project .entry',
				'margin-right' => '.ivan-project .entry',
				'margin-bottom' => '.ivan-project .entry',
				'margin-left' => '.ivan-project .entry',
				'padding-top' => '.ivan-project .entry-inner',
				'padding-right' => '.ivan-project .entry-inner',
				'padding-bottom' => '.ivan-project .entry-inner',
				'padding-left' => '.ivan-project .entry-inner',
				// Bg
				'background-color' => '.ivan-project .entry',
				// Border
				'border-top-width' => '.ivan-project .entry',
				'border-right-width' => '.ivan-project .entry',
				'border-bottom-width' => '.ivan-project .entry',
				'border-left-width' => '.ivan-project .entry',
				'border-style' => '.ivan-project .entry',
				'border-color' => '.ivan-project .entry',
				// Border Radius
				'border-top-left-radius' => '.ivan-project .entry',
				'border-top-right-radius' => '.ivan-project .entry',
				'border-bottom-left-radius' => '.ivan-project .entry',
				'border-bottom-right-radius' => '.ivan-project .entry',
				// Hovers
				//'color-hover' => 'a:hover',
				//'border-color-hover' => 'a:hover',
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
				// Spacing
				//'margin-top' => '.ivan-project .entry',
				//'margin-right' => '.ivan-project .entry',
				//'margin-bottom' => '.ivan-project .entry',
				//'margin-left' => '.ivan-project .entry',
				//'padding-top' => '.ivan-project .entry',
				//'padding-right' => '.ivan-project .entry',
				//'padding-bottom' => '.ivan-project .entry',
				//'padding-left' => '.ivan-project .entry',
				// Bg
				//'background-color' => '.ivan-project .entry',
				// Border
				//'border-top-width' => 'h1',
				//'border-right-width' => 'h1',
				//'border-bottom-width' => 'h1',
				//'border-left-width' => 'h1',
				//'border-style' => 'h1',
				//'border-color' => 'h1',
				// Hovers
				'color-hover' => '.entry h3 a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
			'cats_css' => array(
				// Font
				'font-family' => '.entry .categories',
				'font-weight' => '.entry .categories',
				'font-size' => '.entry .categories',
				'line-height' => '.entry .categories',
				'text-transform' => '.entry .categories',
				'color' => '.entry .categories',
				// Spacing
				//'margin-top' => '.ivan-project .entry',
				//'margin-right' => '.ivan-project .entry',
				//'margin-bottom' => '.ivan-project .entry',
				//'margin-left' => '.ivan-project .entry',
				//'padding-top' => '.ivan-project .entry',
				//'padding-right' => '.ivan-project .entry',
				//'padding-bottom' => '.ivan-project .entry',
				//'padding-left' => '.ivan-project .entry',
				// Bg
				//'background-color' => '.ivan-project .entry',
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
			'excerpt_css' => array(
				// Font
				'font-family' => '.entry .excerpt',
				'font-weight' => '.entry .excerpt',
				'font-size' => '.entry .excerpt',
				'line-height' => '.entry .excerpt',
				'text-transform' => '.entry .excerpt',
				'color' => '.entry .excerpt',
				// Spacing
				//'margin-top' => '.ivan-project .entry',
				//'margin-right' => '.ivan-project .entry',
				//'margin-bottom' => '.ivan-project .entry',
				//'margin-left' => '.ivan-project .entry',
				//'padding-top' => '.ivan-project .entry',
				//'padding-right' => '.ivan-project .entry',
				//'padding-bottom' => '.ivan-project .entry',
				//'padding-left' => '.ivan-project .entry',
				// Bg
				//'background-color' => '.ivan-project .entry',
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
			'read_more_css' => array(
				// Font
				'font-family' => '.read-more a',
				'font-weight' => '.read-more a',
				'font-size' => '.read-more a',
				'line-height' => '.read-more a',
				'text-transform' => '.read-more a',
				'color' => '.read-more a',
				// Spacing
				//'margin-top' => '.ivan-project .entry',
				//'margin-right' => '.ivan-project .entry',
				//'margin-bottom' => '.ivan-project .entry',
				//'margin-left' => '.ivan-project .entry',
				'padding-top' => '.read-more a',
				'padding-right' => '.read-more a',
				'padding-bottom' => '.read-more a',
				'padding-left' => '.read-more a',
				// Bg
				'background-color' => '.read-more a',
				// Border Radius
				'border-top-left-radius' => '.read-more a',
				'border-top-right-radius' => '.read-more a',
				'border-bottom-left-radius' => '.read-more a',
				'border-bottom-right-radius' => '.read-more a',
				// Border
				'border-top-width' => '.read-more a',
				'border-right-width' => '.read-more a',
				'border-bottom-width' => '.read-more a',
				'border-left-width' => '.read-more a',
				'border-style' => '.read-more a',
				'border-color' => '.read-more a',
				// Hovers
				'color-hover' => '.read-more a:hover',
				'border-color-hover' => '.read-more a:hover',
				'background-color-hover' => '.read-more a:hover',
			),
			'icon_css' => array(
				// Font
				//'font-family' => 'h2',
				//'font-weight' => 'h2',
				'font-size' => '.icon-inner',
				//'line-height' => 'h2',
				//'text-transform' => 'h2',
				'color' => '.icon-inner',
				// Spacing
				'margin-top' => '.icon-inner',
				'margin-right' => '.icon-inner',
				'margin-bottom' => '.icon-inner',
				'margin-left' => '.icon-inner',
				'padding-top' => '.icon-inner',
				'padding-right' => '.icon-inner',
				'padding-bottom' => '.icon-inner',
				'padding-left' => '.icon-inner',
				// Bg
				'background-color' => '.icon-inner',
				// Border Radius
				'border-top-left-radius' => '.icon-inner',
				'border-top-right-radius' => '.icon-inner',
				'border-bottom-left-radius' => '.icon-inner',
				'border-bottom-right-radius' => '.icon-inner',
				// Border
				'border-top-width' => '.icon-inner',
				'border-right-width' => '.icon-inner',
				'border-bottom-width' => '.icon-inner',
				'border-left-width' => '.icon-inner',
				'border-style' => '.icon-inner',
				'border-color' => '.icon-inner',
				// Hovers
				'color-hover' => '.icon-inner:hover',
				'border-color-hover' => '.icon-inner:hover',
				'background-color-hover' => '.icon-inner:hover',
			),
			'filter_css' => array(
				// Font
				'font-family' => '.ivan-vc-filters a, .filter-grid',
				'font-weight' => '.ivan-vc-filters a, .filter-grid',
				'font-size' => '.ivan-vc-filters a, .filter-grid',
				'line-height' => '.ivan-vc-filters a, .filter-grid',
				'text-transform' => '.ivan-vc-filters a, .filter-grid',
				'color' => '.ivan-vc-filters a',
				'text-align' => '.ivan-vc-filters',
				// Spacing
				'margin-top' => '.ivan-vc-filters-wrapper',
				'margin-right' => '.ivan-vc-filters a, .filter-grid',
				'margin-bottom' => '.ivan-vc-filters-wrapper',
				'margin-left' => '.ivan-vc-filters a',
				'padding-top' => '.ivan-vc-filters a',
				'padding-right' => '.ivan-vc-filters a',
				'padding-bottom' => '.ivan-vc-filters a',
				'padding-left' => '.ivan-vc-filters a',
				// Bg
				'background-color' => '.ivan-vc-filters a, .filter-grid',
				// Border Radius
				'border-top-left-radius' => '.ivan-vc-filters a, .filter-grid',
				'border-top-right-radius' => '.ivan-vc-filters a, .filter-grid',
				'border-bottom-left-radius' => '.ivan-vc-filters a, .filter-grid',
				'border-bottom-right-radius' => '.ivan-vc-filters a, .filter-grid',
				// Border
				'border-top-width' => '.ivan-vc-filters a, .filter-grid',
				'border-right-width' => '.ivan-vc-filters a, .filter-grid',
				'border-bottom-width' => '.ivan-vc-filters a, .filter-grid',
				'border-left-width' => '.ivan-vc-filters a, .filter-grid',
				'border-style' => '.ivan-vc-filters a, .filter-grid',
				'border-color' => '.ivan-vc-filters a, .filter-grid',
				// Hovers
				'color-hover' => '.ivan-vc-filters a:hover, .ivan-vc-filters a.current, .filter-grid',
				'border-color-hover' => '.ivan-vc-filters a:hover, .ivan-vc-filters a.current',
				'background-color-hover' => '.ivan-vc-filters a:hover, .ivan-vc-filters a.current',
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
	global $ivan_vc_projects;
	$ivan_vc_projects = new WPBakeryShortCode_ivan_projects( array('name' => 'Projects', 'base' => 'ivan_projects') );

 } // #end class check

