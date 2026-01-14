<?php
/*
 * Template Name: header+footerのみ
 * Template Post Type: post, page
 *
 * @package ks
 */
get_header();
echo <<<HTML
    <aside id="primary">
      <div id="tinymce" class="entry-content">
HTML;
$post_type = get_post_type();
while ( have_posts() ) : the_post();
  the_content( sprintf(
    wp_kses(
      /* translators: %s: Name of current post. Only visible to screen readers */
      __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'ks' ),
      array(
        'span' => array(
          'class' => array(),
        ),
      )
    ),
    get_the_title()
  ) );
  // If comments are open or we have at least one comment, load up the comment template.
  if ( comments_open() || get_comments_number() ) :
    comments_template();
  endif;
endwhile;
echo <<<HTML
      </div>
    </aside>
HTML;
get_footer();
