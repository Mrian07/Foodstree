<?php
global $post;

// Check if is singular project and if it's enabled...
if( is_singular('ivan_vc_projects') && ivan_get_option('breadcrumb-proj-disable') == true ) {
	return;
}

?>

<div class="ivan-breadcrumb">
	<?php

	$separator = '<li class="separator">/</li>';

	echo '<ul class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">';

	echo apply_filters('ivan_you_are_here', '<li class="intro">'. __('You are here:', 'ivan_domain') .'</li>');

	if (!is_home()) {

		echo '<li typeof="v:Breadcrumb"><a href="';
		echo iv_get_home_url();
		echo '" rel="v:url" property="v:title">';
		echo __('Home', 'ivan_domain');
		echo '</a></li>'. $separator .'';

		if (is_single()) {
			
			$cats = get_the_category();

			if( isset($cats[0]) ) :
				echo '<li typeof="v:Breadcrumb"><a href="'. get_category_link( $cats[0]->term_id ) .'">'. $cats[0]->cat_name.'</a></li>' . $separator;
			endif;

			if (is_single()) {
				echo '<li typeof="v:Breadcrumb">';
				the_title();
				echo '</li>';
			}
		} elseif( is_category() ) {

			$cats = get_the_category();

			if( isset($cats[0]) ) :
				echo '<li typeof="v:Breadcrumb">'.single_cat_title('', false).'</li>';
			endif;

		} elseif (is_page()) {
			if($post->post_parent){
				$anc = get_post_ancestors( $post->ID );
				$title = get_the_title();
				foreach ( $anc as $ancestor ) {
					$output = '<li typeof="v:Breadcrumb"><a href="'.get_permalink($ancestor).'" title="'.get_the_title($ancestor).'"  rel="v:url" property="v:title">'.get_the_title($ancestor).'</a></li> <li class="separator">/</li>';
				}
				echo $output;
				echo '<li typeof="v:Breadcrumb"><span title="'.$title.'"> '.$title.'</span></li>';
			} else {
				echo '<li typeof="v:Breadcrumb"><span> '.get_the_title().'</span></li>';
			}
		}
		elseif (is_tag()) { echo '<li typeof="v:Breadcrumb">'.single_cat_title('', false).'</li>'; }
		elseif (is_day()) {echo'<li typeof="v:Breadcrumb">'. __('Archive for', 'ivan_domain').' '; the_time('F jS, Y'); echo'</li>';}
		elseif (is_month()) {echo '<li typeof="v:Breadcrumb">'. __('Archive for', 'ivan_domain').' '; the_time('F, Y'); echo'</li>';}
		elseif (is_year()) {echo '<li typeof="v:Breadcrumb">'. __('Archive for', 'ivan_domain').' '; the_time('Y'); echo'</li>';}
		elseif (is_author()) {echo '<li typeof="v:Breadcrumb">'. __('Author Archive', 'ivan_domain').''; echo'</li>';}
		elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo '<li typeof="v:Breadcrumb">'.__('Blog Archives', 'ivan_domain').''; echo'</li>';}
		elseif (is_search()) {echo '<li typeof="v:Breadcrumb">'. __('Search Results', 'ivan_domain'); echo'</li>';}
	}
	elseif (is_home()) { echo '<li typeof="v:Breadcrumb">'. __('Home', 'ivan_domain') .'</li>'; }

	echo '</ul>';
	?>
</div><!-- .ivan-breadcrumb -->