<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ks
 */
$site_url = get_bloginfo('url');
$class = implode(" ", get_post_class() );
echo <<<HTML
<article id="primaly">
	<section style="text-align:center">
		<h1><span class="jp" style="display:block">ページが見つかりません</span><span class="en" style="color:#bfbfbf">404 NOT FOUND</span></h1>
		<p>お探しのページは存在しないか、<br class="sp-only">移動・削除された可能性がございます。<br>
			大変お手数をおかけ致しますが、<br class="sp-only">再度URLをご確認いただくか、<br>
			メニューからお探しいただきますよう、<br class="sp-only">お願い申し上げます。
		</p>
		<a href="{$site_url}" class="button page trans" style="margin:2rem auto"><span>トップページ</span></a>
	</section>
</article>
HTML;