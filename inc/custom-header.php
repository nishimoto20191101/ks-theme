<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	< ?php the_header_image_tag(); ? >
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package ks
 */
//インラインスタイル <style type="text/css">.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}</style>
add_action( 'widgets_init', function(){
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
});
//ファビコン
add_filter( 'site_icon_meta_tags', function($meta_tags){
	$meta_tags = [
		sprintf( '<link rel="icon" href="%s" sizes="32x32" />', esc_url( get_site_icon_url(32)) ),
		sprintf( '<link rel="icon" href="%s" sizes="192x192" />', esc_url( get_site_icon_url(192)) ),
		"\n"
	];
	return $meta_tags;
} );
//概要（抜粋）の省略文字
add_filter('excerpt_more', function($more){  return '...'; });
//wp_headに追加
add_action('wp_head', function(){
	global $post;
	$this_dir = dirname(__FILE__);
	$site_url = get_bloginfo('url');
	//keywords追加対策
	$tags_disp = get_option('tags');
	$common_disp = get_option('common_disp');
	$meta_tag = !empty($tags_disp['keywords']) ? "<meta name=\"keywords\" content=\"{$tags_disp['keywords']}\">" : "";
	// 共通js、cssなどのタグを読み込んでソース内に追加する
	$jquery = file_get_contents(get_template_directory().'/js/jquery/3.6.1/jquery.min.js');
	$common_js = file_get_contents(get_template_directory().'/js/common.min.js');
	$common_css = file_get_contents(get_template_directory().'/css/common.min.css');
	$common_css .= is_singular() ? file_get_contents(get_template_directory().'/css/editor-style.min.css') : "";
	//カスタマイズ色
	$colors = get_option('colors');
	$body_color = !empty($colors['body_bg']) ? "--color-body-bg:{$colors['body_bg']};" : "";
	$header_color = !empty($colors['header']) ? "--color-header:{$colors['header']};" : "";
	$footer_color = !empty($colors['footer']) ? "--color-footer:{$colors['footer']};" : "";
	$footer_bg = !empty($colors['footer_bg']) ? "--color-footer-bg:{$colors['footer_bg']};" : "";
	$copyright_color = !empty($colors['copyright']) ? "--color-copyright:{$colors['copyright']};" : "";
	$copyright_bg = !empty($colors['copyright_bg']) ? "--color-copyright-bg:{$colors['copyright_bg']};" : "";
	$theme_color = !empty($colors['copyright_bg']) ? "<meta name=\"theme-color\" content=\"{$colors['copyright_bg']}\">" : "";
	$noImage = !empty($common_disp['noImage']) ? ".image.noimage{background-image:url({$common_disp['noImage']})}" : '.image.noimage::before{content:"NO IMAGE"}';
	//個別css、js
	$individual_js = "";
	if( is_singular() ) {
		$post = get_post();
		//$individual_js  = mb_convert_kana(get_post_meta($post->ID, 'js', true), 's', 'UTF-8');//個別
		$individual_js = get_post_meta($post->ID, 'js', true);
		$individual_js = str_replace("：", ":", $individual_js);
	}
	echo <<<HTML
{$meta_tag}{$theme_color}
<style type="text/css">{$common_css}:root { {$body_color}{$header_color}{$footer_color}{$footer_bg};{$copyright_color}{$copyright_bg}}{$noImage}</style>
<script>{$jquery}{$common_js}
{$individual_js}
</script>
HTML;
	//投稿、ページ、または添付ファイルにピンバック URL 自動検出ヘッダーを追加
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo('pingback_url') ), '">';
	}
});
