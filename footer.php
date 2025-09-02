<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ks
 */
echo "</div>";
is_page_template('template-page/blank.php') || get_template_part( 'template-parts/common', 'footer' );
wp_footer();
?>
</body>
</html>