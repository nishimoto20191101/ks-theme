<?php
/*
 * Template Name: sidebar無
 * Template Post Type: post, page
 *
 * @package ks
 */
$site_url = get_bloginfo('url');
$post_type = get_post_type();
get_header();

if( !in_array($post_type,["page", "single"]) && is_active_sidebar("{$post_type}_header")){
	echo '<section id="content_header">';
	dynamic_sidebar("{$post_type}_header");
	echo '</section>';
}else if(is_active_sidebar('content_header')){
	echo '<section id="content_header">';
	dynamic_sidebar('content_header');
	echo '</section>';
}

if( function_exists('yoast_breadcrumb') ){
	yoast_breadcrumb( '<div id="breadcrumbs" class="inner">','</div>' );
}
echo <<<HTML
  <div id="{$post->ID}" class="inner">
    <aside id="primary">
HTML;
if(is_active_sidebar("{$post_type}_top")){
  dynamic_sidebar("{$post_type}_top");
}else if(is_active_sidebar('content_top')){
  dynamic_sidebar('content_top');
}
/*remove_filter ('the_content', 'wpautop');   //pタグ対策
the_content();*/
while ( have_posts() ) : the_post();
	get_template_part( 'template-parts/content', $post_type );

  // If comments are open or we have at least one comment, load up the comment template.
  if ( comments_open() || get_comments_number() ) :
    comments_template();
  endif;

endwhile;
if(is_active_sidebar("{$post_type}_bottom")){
  dynamic_sidebar("{$post_type}_bottom");
}else if(is_active_sidebar('content_bottom')){
  dynamic_sidebar('content_bottom');
}
echo <<<HTML
    </aside>
  </div>
HTML;
get_footer();
