<?php
/*
 * Template Name: Blank
 * Template Post Type: post, page
 *
 * @package ks
 */
//表示
get_header();
/*remove_filter ('the_content', 'wpautop');   //pタグ対策
the_content();*/
echo'   <div id="tinymce" class="entry-content">';
while ( have_posts() ) : the_post();
  the_content( sprintf(
    wp_kses(
      /* translators: %s: Name of current post. Only visible to screen readers */
      __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'ks' ),
      [
        'span' => [
          'class' => [],
        ],
      ]
    ),
    get_the_title()
  ) );
  // If comments are open or we have at least one comment, load up the comment template.
  if ( comments_open() || get_comments_number() ) :
    comments_template();
  endif;
endwhile;
echo '</div>';
get_footer();

