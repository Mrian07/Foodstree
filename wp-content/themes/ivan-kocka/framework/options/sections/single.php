<?php
/*
 * Templates Section
*/

$this->sections[] = array(
	'title' => __('Single', 'ivan_domain_redux'),
	'desc' => __('Change single post templates.', 'ivan_domain_redux'),
	'icon' => 'el-icon-screen',
	'fields' => array(

		array(
			'id' => 'random-templates',
			'type' => 'info',
			'desc' => __('Single Post.', 'ivan_domain_redux')
		),

		/* Base Layouts */
		array(
			'id'=>'single-layout',
			'type' => 'select',
			'title' => __('Base Layout', 'ivan_domain_redux'), 
			'subtitle' => __('Select the layout to be used in blog.', 'ivan_domain_redux'),
			'options' => apply_filters('ivan_single_base_layouts', array( 
				'large' => 'Large',
				//'full' => 'Full Width',
				) ),
			'default' => 'large',
			'validate' => 'not_empty',
		),

			/* Sub Layouts > Large */
			array(
				'id'=> 'single-sub-large',
				'type' => 'select',
				'title' => __('Layout Style', 'ivan_domain_redux'), 
				'subtitle' => __('Select the layout style to be applied in the blog posts.', 'ivan_domain_redux'),
				'options' => apply_filters('ivan_single_large_layouts', array( 
					'simple' => "Simple",
					) ),
				'default' => 'simple',
				'required' => array( 'single-layout', '=', array('large') ),
			),

			/* Sub Layouts > Masonry */
			/*
			array(
				'id'=> 'single-sub-full',
				'type' => 'select',
				'title' => __('Layout Style', 'ivan_domain_redux'), 
				'subtitle' => __('Select the layout style to be applied in the blog posts.', 'ivan_domain_redux'),
				'options' => apply_filters('ivan_single_full_layouts', array( 
					'polaroid' => "Polaroid",
					) ),
				'default' => 'polaroid',
				'required' => array( 'single-layout', '=', array('full') ),
			),
			*/

		/*
		array(
			'id'=>'single-no-margin-aside',
			'type' => 'switch', 
			'title' => __('Aside: Remove aside margins?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, margins will be removed in aside layout.', 'ivan_domain_redux'),
			"default" => 0,
			'required' => array( 'main-layout', '=', array('Ivan_Main_Layout_Aside_Left', 'Ivan_Main_Layout_Aside_Right') ),
		),

		array(
			'id'=>'single-no-margin-top',
			'type' => 'switch', 
			'title' => __('Aside: Remove top margins?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, margins will be removed from top in aside layout.', 'ivan_domain_redux'),
			"default" => 0,
			'required' => array( 'main-layout', '=', array('Ivan_Main_Layout_Aside_Left', 'Ivan_Main_Layout_Aside_Right') ),
		),
		*/

		array(
			'id'=>'single-reduced-width',
			'type' => 'switch', 
			'title' => __('Use Reduced Width?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, the post will use reduced width. Recommended to full single layout.', 'ivan_domain_redux'),
			"default" => 0,
		),

		array(
			'id'=>'single-sidebar-right',
			'type' => 'switch', 
			'title' => __('Enable Sidebar at Right?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, sidebar will be displayed in the specified location.', 'ivan_domain_redux'),
			"default" => 1,
		),

		array(
			'id'=>'single-sidebar-left',
			'type' => 'switch', 
			'title' => __('Enable Sidebar at Left?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, sidebar will be displayed in the specified location.', 'ivan_domain_redux'),
			"default" => 0,
		),

		array(
			'id'=>'single-disable-title',
			'type' => 'switch', 
			'title' => __('Disable Title Wrapper?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, title wrapper will not be displayed.', 'ivan_domain_redux'),
			"default" => 0,
		),

		array(
			'id'=>'single-boxed-page',
			'type' => 'switch', 
			'title' => __('Display Single Boxed?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, the single will be displayed in a boxed layout.', 'ivan_domain_redux'),
			"default" => 0,
		),

		array(
			'id' => 'random-templates',
			'type' => 'info',
			'desc' => __('Effects/Additional Styles', 'ivan_domain_redux')
		),

		array(
			'id'=>'single-disable-thumb',
			'type' => 'switch', 
			'title' => __('Disable Thumbnails?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, thumbnails will not be displayed in single post.', 'ivan_domain_redux'),
			"default" => 0,
		),

		array(
			'id' => 'random-templates',
			'type' => 'info',
			'desc' => __('Components', 'ivan_domain_redux')
		),

		array(
			'id'=>'single-post-nav',
			'type' => 'switch', 
			'title' => __('Enable Post Navigation?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, navigation will be displayed below content.', 'ivan_domain_redux'),
			"default" => 1,
		),

		array(
			'id'=>'single-author-box',
			'type' => 'switch', 
			'title' => __('Enable author box?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, the author box with details and social icons will be displayed.', 'ivan_domain_redux'),
			"default" => 0,
		),

		array(
			'id'=>'single-related',
			'type' => 'switch', 
			'title' => __('Enable Related Posts?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, the related posts box will be displayed.', 'ivan_domain_redux'),
			"default" => 0,
		),

		array(
			'id'=>'single-tags',
			'type' => 'switch', 
			'title' => __('Enable Tags after Content?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, the tags will be displayed after post content.', 'ivan_domain_redux'),
			"default" => 1,
		),

		array(
			'id' => 'random-templates',
			'type' => 'info',
			'desc' => __('Single Project', 'ivan_domain_redux')
		),

		array(
			'id'=>'project-nav',
			'type' => 'switch', 
			'title' => __('Display Navigation in Projects?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, next and previous project will be displayed in single project pages.', 'ivan_domain_redux'),
			"default" => 1,
		),

		array(
			'id'=>'project-related',
			'type' => 'switch', 
			'title' => __('Display Related Projects?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, the related projects will be displayed below project contents.', 'ivan_domain_redux'),
			"default" => 1,
		),

		array(
			'id' => 'random-single',
			'type' => 'info',
			'desc' => __('Dynamic Area', 'ivan_domain_redux')
		),

		array(
			'id'=>'single-da-after-enable',
			'type' => 'switch', 
			'title' => __('Enable Dynamic Area After Post Content?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, a dynamic area will be displayed after post contents. Great to a newsletter form!', 'ivan_domain_redux'),
			"default" => 0,
		),

		array(
			'id'=>'single-da-after',
			'type' => 'select',
			'title' => __('After Content Dynamic Content Page', 'ivan_domain_redux'), 
			'subtitle' => __('Select the page from where the content will be loaded and displayed.', 'ivan_domain_redux'),
			'data' => 'pages',
			'required' => array( 'single-da-after-enable', '=', 1),
		),

		array(
			'id' => 'random-templates',
			'type' => 'info',
			'desc' => __('Advanced Configuration', 'ivan_domain_redux')
		),

		array(
			'id'=>'single-thumb-size',
			'type' => 'text',
			'title' => __('Custom Single Thumbnail Size', 'ivan_domain_redux'), 
			'subtitle' => __('Select a custom thumbnail size to your blog.', 'ivan_domain_redux'),
			'description' => 'Type the thumbnail name like "full", "medium" or a custom size defined.',
			'default' => '',
		),

	), // #fields
);