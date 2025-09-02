<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ks
 */
$site_url = get_bloginfo('url');
$template_slug = 'template-parts/';
$arc_flag = false;
if( is_archive() || is_search() || is_home() ){
	$title = apply_filters( 'get_the_archive_title_prefix',get_the_archive_title());
	$term_obj = get_queried_object();
	$post_type = is_search() ? "search" : ( !empty( $term_obj->term_id ) ? $term_obj->taxonomy : get_post_type() );
	$template_slug .= "list";
	$arc_flag = true;
}else{
	$title = get_the_title();
	if( is_page() ){
		$post_type = "page";
	}else{
		$post_type = get_post_type() ? : "single";
	}
	$template_slug .= "content";
}

get_header();

if(is_active_sidebar('content_header')){
	echo '<section id="content_header">';
	dynamic_sidebar('content_header');
	echo '</section>';
}

/*if( function_exists('yoast_breadcrumb') ){//Yoastパンくず
    yoast_breadcrumb( '<div id="breadcrumbs" class="inner">','</div>' );
}*/

echo <<<HTML
  <div id="{$post_type}" class="flex-wrap inner">
    <aside id="primary">
HTML;
if(is_active_sidebar('content_top')){
  dynamic_sidebar('content_top');
}

echo  $arc_flag  ? '<div class="list" style="overflow:hidden">' : "";

if(have_posts()){
	while ( have_posts() ){
		the_post();
		get_template_part( $template_slug, $post_type );

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ){
			comments_template();
		}

	}
}else{
	get_template_part( $template_slug, 'none' );
}

if( $arc_flag ){
	echo "	      </div>";
	get_template_part( 'template-parts/pasing' );//ページング

}else if( is_single() ){
	$list_url = get_post_type_archive_link($post_type);
	$nav__html = get_the_post_navigation( [ 'prev_text' => __('%title'), 'next_text' => __('%title'), 'screen_reader_text' => '&nbsp;'] );
	//$nav__html = get_the_post_navigation( [ 'prev_text' => __('&laquo; 前へ'), 'next_text' => __('次へ &raquo;'), 'screen_reader_text' => '&nbsp;'] );
	echo <<< HTML
			<div class="single-nav">
				<a href="{$list_url}"  class="button page trans">一覧へ<span></span></a>
				{$nav__html}
			</div>
	HTML;
}

if(is_active_sidebar('content_bottom')){
  dynamic_sidebar('content_bottom');
}
echo <<< HTML
    </aside>
HTML;
get_sidebar();
echo <<< HTML
  </div>
HTML;
if(is_active_sidebar('content_footer')){
  dynamic_sidebar('content_footer');
}
get_footer();
