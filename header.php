<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ks
 */
$site_url = get_bloginfo('url');
$tags = get_option('tags');
$this_url = (empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER["HTTP_HOST"] .$_SERVER["REQUEST_URI"];
$header_gtm = $body_gtm = "";
if( !empty($tags['gtm']) ){
  $header_gtm = <<<HTML
<!-- Google Tag Manager -->
<script>dataLayer=[];(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','{$tags['gtm']}');</script>
<!-- End Google Tag Manager -->
HTML;
 $body_gtm = <<<HTML
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={$tags['gtm']}"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
HTML;
}
$language = get_language_attributes();
$char = get_bloginfo( 'charset' );
$head = !empty($tags['head']) ? esc_html($tags['head']) : "";
$body_IA = !empty($tags['body_IA']) ? esc_html($tags['body_IA']) : "";
$body_class = implode(" ", get_body_class());

echo <<<HTML
<!doctype html>
<html {$language}>
<head>
{$header_gtm}
<meta charset="{$char}">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="format-detection" content="telephone=no">
<meta name="referrer" content="no-referrer-when-downgrade"/>
{$head}
HTML;
wp_head();
echo <<<HTML
</head>
<body class="{$body_class}">
{$body_gtm}{$body_IA}
HTML;
is_page_template('template-page/blank.php') || get_template_part( 'template-parts/common', 'header' );
?>
  <div id="content">