<?php
/*
 * Templates Section
*/

$this->sections[] = array(
	'title' => __('Blog', 'ivan_domain_redux'),
	'desc' => __('Change blog and archives templates.', 'ivan_domain_redux'),
	'icon' => 'el-icon-screen',
	'fields' => array(

		array(
			'id' => 'random-templates',
			'type' => 'info',
			'desc' => __('Main Blog.', 'ivan_domain_redux')
		),

		/* Base Layouts */
		array(
			'id'=>'blog-layout',
			'type' => 'select',
			'title' => __('Base Layout', 'ivan_domain_redux'), 
			'subtitle' => __('Select the layout to be used in blog.', 'ivan_domain_redux'),
			'options' => apply_filters('ivan_blog_base_layouts', array( 
				'large' => 'Large',
				'medium' => 'Medium',
				'masonry' => 'Masonry',
				'full' => 'Full Width',
				) ),
			'default' => 'large',
			'validate' => 'not_empty',
		),

			/* Sub Layouts > Large */
			array(
				'id'=> 'blog-sub-large',
				'type' => 'select',
				'title' => __('Layout Style', 'ivan_domain_redux'), 
				'subtitle' => __('Select the layout style to be applied in the blog posts.', 'ivan_domain_redux'),
				'options' => apply_filters('ivan_blog_large_layouts', array( 
					'simple' => "Simple",
					'bottom-meta' => "Meta at Bottom",
					'aside-date' => "Aside Date",
					) ),
				'default' => 'simple',
				'required' => array( 'blog-layout', '=', array('large') ),
			),

			/* Sub Layouts > Medium */
			array(
				'id'=> 'blog-sub-medium',
				'type' => 'select',
				'title' => __('Layout Style', 'ivan_domain_redux'), 
				'subtitle' => __('Select the layout style to be applied in the blog posts.', 'ivan_domain_redux'),
				'options' => apply_filters('ivan_blog_medium_layouts', array( 
					'simple' => "Simple",
					) ),
				'default' => 'simple',
				'required' => array( 'blog-layout', '=', array('medium') ),
			),

			/* Sub Layouts > Masonry */
			array(
				'id'=> 'blog-sub-masonry',
				'type' => 'select',
				'title' => __('Layout Style', 'ivan_domain_redux'), 
				'subtitle' => __('Select the layout style to be applied in the blog posts.', 'ivan_domain_redux'),
				'options' => apply_filters('ivan_blog_masonry_layouts', array( 
					'simple' => "Simple",
					) ),
				'default' => 'simple',
				'required' => array( 'blog-layout', '=', array('masonry') ),
			),

			/* Sub Layouts > Masonry */
			array(
				'id'=> 'blog-sub-full',
				'type' => 'select',
				'title' => __('Layout Style', 'ivan_domain_redux'), 
				'subtitle' => __('Select the layout style to be applied in the blog posts.', 'ivan_domain_redux'),
				'options' => apply_filters('ivan_blog_full_layouts', array( 
					'polaroid' => "Polaroid",
					) ),
				'default' => 'polaroid',
				'required' => array( 'blog-layout', '=', array('full') ),
			),

		/*
		array(
			'id'=>'blog-no-margin-aside',
			'type' => 'switch', 
			'title' => __('Aside: Remove aside margins?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, margins will be removed in aside layout.', 'ivan_domain_redux'),
			"default" => 0,
			'required' => array( 'main-layout', '=', array('Ivan_Main_Layout_Aside_Left', 'Ivan_Main_Layout_Aside_Right') ),
		),

		array(
			'id'=>'blog-no-margin-top',
			'type' => 'switch', 
			'title' => __('Aside: Remove top margins?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, margins will be removed from top in aside layout.', 'ivan_domain_redux'),
			"default" => 0,
			'required' => array( 'main-layout', '=', array('Ivan_Main_Layout_Aside_Left', 'Ivan_Main_Layout_Aside_Right') ),
		),
		*/

		array(
			'id' => 'blog-columns',
			'type' => 'slider',
			'title' => __('Columns', 'ivan_domain_redux'),
			'desc' => __('Define the columns numbers to be used in the blog.', 'ivan_domain_redux'),
			"default" => "3",
			"min" => "1",
			"step" => "1",
			"max" => "4",
			'required' => array( 'blog-layout', '=', array('masonry') ),
		),

		/*
		array(
			'id'=>'blog-no-margin',
			'type' => 'switch', 
			'title' => __('Remove margins of posts?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, margins will be removed creating a grid that is useful to aside layouts.', 'ivan_domain_redux'),
			"default" => 0,
			'required' => array( 'blog-layout', '=', array('masonry') ),
		),
		*/

		array(
			'id'=>'blog-sidebar-right',
			'type' => 'switch', 
			'title' => __('Enable Sidebar at Right?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, sidebar will be displayed in the specified location.', 'ivan_domain_redux'),
			"default" => 1,
		),

		array(
			'id'=>'blog-sidebar-left',
			'type' => 'switch', 
			'title' => __('Enable Sidebar at Left?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, sidebar will be displayed in the specified location.', 'ivan_domain_redux'),
			"default" => 0,
		),

		array(
			'id'=>'blog-disable-title',
			'type' => 'switch', 
			'title' => __('Disable Title Wrapper?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, title wrapper will not be displayed.', 'ivan_domain_redux'),
			"default" => 0,
		),

		array(
			'id'=>'blog-boxed-page',
			'type' => 'switch', 
			'title' => __('Display Blog Boxed?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, the blog will be displayed in a boxed layout.', 'ivan_domain_redux'),
			"default" => 0,
		),

		array(
			'id'=>'blog-first-featured',
			'type' => 'switch', 
			'title' => __('First Post Featured?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, the first post will receive a different template.', 'ivan_domain_redux'),
			"default" => 0,
			'required' => array( 'blog-layout', '=', array('masonry') ),
		),

		array(
			'id' => 'random-templates',
			'type' => 'info',
			'desc' => __('Effects/Additional Styles', 'ivan_domain_redux')
		),

		array(
			'id'=>'blog-boxed-style',
			'type' => 'switch', 
			'title' => __('Enable boxed style?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, posts will be displayed in a boxed style. Useful when using custom background colors.', 'ivan_domain_redux'),
			"default" => 0,
			'required' => array( 'blog-layout', '!=', array('masonry') ),
		),

		array(
			'id'=>'blog-disable-thumb',
			'type' => 'switch', 
			'title' => __('Disable Thumbnails?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, thumbnails will not be displayed in the blog.', 'ivan_domain_redux'),
			"default" => 0,
		),

		array(
			'id'=>'blog-hover-thumb',
			'type' => 'switch', 
			'title' => __('Enable Hover Effect in Thumbnail?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, the effect will be displayed in thumbnail images.', 'ivan_domain_redux'),
			"default" => 0,
		),

		array(
			'id'=>'blog-gray-thumb',
			'type' => 'switch', 
			'title' => __('Enable Grayscale Effect in Thumbnail?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, the effect will be displayed in thumbnail images.', 'ivan_domain_redux'),
			"default" => 0,
		),

		array(
			'id' => 'random-templates',
			'type' => 'info',
			'desc' => __('Archives', 'ivan_domain_redux')
		),

		array(
			'id'=>'archives-disable-title',
			'type' => 'switch', 
			'title' => __('Disable Title Wrapper?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, title wrapper will not be displayed in archives pages.', 'ivan_domain_redux'),
			"default" => 0,
		),

		array(
			'id' => 'random-templates',
			'type' => 'info',
			'desc' => __('Advanced Configuration', 'ivan_domain_redux')
		),

		array(
			'id'=>'blog-thumb-size',
			'type' => 'text',
			'title' => __('Custom Blog Thumbnail Size', 'ivan_domain_redux'), 
			'subtitle' => __('Select a custom thumbnail size to your blog.', 'ivan_domain_redux'),
			'description' => 'Type the thumbnail name like "full", "medium" or a custom size defined.',
			'default' => '',
		),
		
	), // #fields
);