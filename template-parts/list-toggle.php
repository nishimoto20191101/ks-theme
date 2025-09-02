<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ks
 */
$single_id = !empty($_GET['id']) ? $_GET['id'] : "";
//タイトル
$title = get_the_title();
//投稿日
$date = get_the_date(get_option('date_format'));
//詳細URL
$permalink = get_the_permalink();
//展開しておくかどうか
$checked = !empty($single_id) && $single_id == $post->ID ? ' checked' : "";

$content = nl2br(get_the_content());
echo <<<HTML
    <div class="full">
      <div class="wrap">
        <input type="checkbox" id="id-{$post->ID}" class="toggle"{$checked}>
        <label for="id-{$post->ID}"><h3>{$title}</h3></label>
        <div class="disp entry-content">
          {$content}
        </div>
      </div>
    </div>
HTML;
