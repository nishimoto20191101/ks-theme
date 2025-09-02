<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ks
 */
//タイトル
$title = get_the_title();
//詳細ページURL
$url = get_the_permalink($post->ID);

echo <<<HTML
    <li><a href="{$url}" id="post-{$post->ID}"><span class="title">{$title}</span></a></li>
HTML;
