<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ks
 */
$result = "";
$max_disp = 7;
$url = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$url_root = explode("/page/", explode("?", $url)[0])[0];
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$max_page = $wp_query->max_num_pages;
$max_start = ( $max_page - $max_disp ) > 0 ?  ( $max_page - $max_disp + 1 ) : 1;
$start =  $max_start == 1 || ($max_page <= $max_disp ) ? 1 : ( $paged - floor($max_disp / 2) );
$start = $start > 0 ? ( $start <= $max_start ? $start : $max_start ) : 1; 
$end = $start + $max_disp -1;
$end = $max_page > $end ? $end : $max_page;
$query_string = !empty($_SERVER['QUERY_STRING']) ? "?{$_SERVER['QUERY_STRING']}" : "";
$pages_html = "";
for( $i = $start; $i <= $end; $i++ ){
  $this_class = $i == $paged ? ' class="this"' : '';
  $pages_html .= "<li{$this_class}><a href=\"{$url_root}/page/{$i}/{$query_string}\" class=\"flex\">{$i}</a></li>\n";
}
$prev_page = $start > 1 ? '<li class="prev">...</li>' : "";
$next_page = $end < $max_page ? '<li class="next">...</li>' : "";
if( $max_page > 1 ){
  $result =<<<HTML
  <div class="listNavi">
	<ul class="flex">
{$prev_page}              
{$pages_html}                                      
{$next_page}              
	</ul>
  </div>
HTML;
}
echo $result;