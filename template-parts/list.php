<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ks
 */
//$theme_uri = get_template_directory_uri(); 
$post_type = get_post_type();
$post_id = get_the_ID();
//タイトル
$title = get_the_title();
//投稿日
$date = get_the_date(get_option('date_format'));
//NEWアイコン
$days = 14; //Newを表示させたい期間の日数
$later = date('U',( get_the_date('U') - get_the_time('U', $post_id) )) / 86400 ;
$new = $days > $later ? ' new' : '';
//タクソノミー
$terms = get_categories("taxonomy=category") ? get_the_terms($post->ID, "category") : [];
$terms_org = get_categories("taxonomy={$post_type}_cat") ? get_the_terms($post->ID, "{$post_type}_cat") : [];
$terms = empty($terms) ? $terms_org : ( !empty($terms_org) ? array_merge($terms, $terms_org) : $terms );
$terms__html = '';
if(!empty($terms)){
	foreach( $terms as $key => $term){
		$terms__html .= !empty($term->slug) && $term->term_id != 1 ? "<span class=\"term {$term->slug}\">".esc_html( $term->name )."</span>" : "";
	}
  !empty($terms__html) && ( $terms__html = "<span class=\"flex terms\">{$terms__html}</span>");
}
//タグ
$tags = get_the_tags();
$tags__html = "";
if( !empty($tags) ){
  foreach( $tags as $tag ){
    $tags__html .= !empty($tag->slug) ? "<span class=\"tag {$tag->slug}\">".esc_html( $tag->name )."</span>" : "";
  }
  !empty($tags__html) && ( $tags__html = "<span class=\"flex tags\">{$tags__html}</span>");
}

//サムネイル
if( has_post_thumbnail($post->ID) ){
  $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' );
  $thumb__html = "<img src=\"{$thumb[0]}\" width=\"{$thumb[1]}\" height=\"{$thumb[2]}\" alt=\"{$title}\">";
  $image_class = "";
}else{
  $thumb__html = "";
  $image_class = ' noimage';
}
//詳細ページURL
$url = get_the_permalink($post->ID);

echo <<<HTML
    <a href="{$url}" id="post-{$post->ID}" class="flex between{$new}">
      <div class="image{$image_class}">{$thumb__html}</div>
      <div class="text">
        {$terms__html}{$tags__html}
        <h3>{$title}</h3>
        <span class="date">{$date}</span>
      </div>
    </a>
HTML;
