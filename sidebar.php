<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ks
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
$post_type = get_post_type();
echo '<aside id="secondary" class="widget-area">';
if(is_active_sidebar("{$post_type}_sidebar")){
	dynamic_sidebar("{$post_type}_sidebar");
}else{
	dynamic_sidebar( 'sidebar-1' );
}
echo '</aside><!-- #secondary -->';
