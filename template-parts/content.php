<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ks
 */

?>

<?php 
//ks_post_thumbnail(); 
$post_ID = get_the_ID();
$post_class = implode(" ", get_post_class());
$post_class = !empty($post_class) ? " class=\"$post_class\"" : "";
//投稿タイプ
$post_type = get_post_type(); 
//タイトル
$title = is_front_page() ? get_bloginfo( 'name' ) : get_the_title(); 
//投稿日
$date_format = get_option('date_format')." ".get_option('time_format');
$date = get_the_date($date_format);
//タクソノミー
$terms = get_categories("taxonomy=category") ? get_the_terms($post->ID, "category") : [];
$terms_org = get_categories("taxonomy={$post_type}_cat") ? get_the_terms($post->ID, "{$post_type}_cat") : [];
$terms = empty($terms) ? $terms_org : ( !empty($terms_org) ? array_merge($terms, $terms_org) : $terms );
$terms__html = "";
if(!empty($terms)){
	foreach( $terms as $key => $term){
		$terms__html .= !empty( $term->slug ) && $term->term_id != 1 ? "<a href=\"".get_term_link($term)."\"><span class=\"term {$term->slug}\">".esc_html( $term->name )."</span></a>" : "";
	}
  !empty($terms__html) && ( $terms__html = "<span class=\"flex terms\">{$terms__html}</span>");
}
//タグ
$tags = get_the_tags();
$tags__html = "";
if( $tags ){
  $tags__html = '';
  foreach( $tags as $tag ){
    $tags__html .= !empty($tag->slug) ? "<a href=\"".get_tag_link( $tag )."\"><span class=\"tag {$tag->slug}\">".esc_html( $tag->name )."</span></a>" : "";
  }
  !empty($tags__html) && ( $tags__html = "<span class=\"flex tags\">{$tags__html}</span>");
}
//permalink
$permalink = get_the_permalink($post->ID);
//シェアボタン
if( 1 ){
	$share__html =<<<HTML
			<div class="share">
				<a href="https://twitter.com/intent/tweet?url={$permalink}&text={$title}" target="_blank" rel="noopner"><svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_930_21416)"><path d="M18.2833 14.121L27.2178 3.72998H25.1006L17.3427 12.7524L11.1466 3.72998H4L13.3698 17.3734L4 28.27H6.11732L14.3098 18.7421L20.8534 28.27H28L18.2827 14.121H18.2833ZM15.3833 17.4936L14.4339 16.135L6.88022 5.32469H10.1323L16.2282 14.049L17.1776 15.4076L25.1016 26.7478H21.8495L15.3833 17.4941V17.4936Z" fill="#1B1B1E"></path></g><defs><clipPath id="clip0_930_21416"><rect width="24" height="24.54" fill="white" transform="translate(4 3.72998)"></rect></clipPath></defs></svg></a>
				<a href="https://www.facebook.com/sharer/sharer.php?u={$permalink}" target="_blank" rel="noopner" class="fb"><svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16 3C8.82045 3 3 8.85037 3 16.0668C3 22.618 7.80114 28.0271 14.0571 28.9721V19.5301H10.8408V16.0953H14.0571V13.8098C14.0571 10.0258 15.8913 8.36452 19.0201 8.36452C20.5187 8.36452 21.3111 8.47618 21.6863 8.52726V11.5255H19.552C18.2236 11.5255 17.7597 12.7912 17.7597 14.2179V16.0953H21.6526L21.1244 19.5301H17.7597V29C24.1049 28.1346 29 22.6816 29 16.0668C29 8.85037 23.1795 3 16 3Z" fill="#1B1B1E"></path></svg></a>
				<a href="https://social-plugins.line.me/lineit/share?url={$permalink}" target="_blank" rel="noopner" class="line" style="width:32px"><img src="https://goodplus-service.co.jp/_cms/wp-content/uploads/2024/02/line_logo.png" alt="LINE" width="156" height="150" data-src="https://goodplus-service.co.jp/_cms/wp-content/uploads/2024/02/line_logo.png" style="width:90%;display:block;margin:2px auto"></a>
			</div>
HTML;
}
echo<<<HTML
<article id="post-{$post_ID}"{$post_class}>
	<h1>{$title}</h1>
	<div id="description">
		<div class="flex">
			<div class="flex-wrap">
				<date>{$date}</date>
				{$terms__html}{$tags__html}
			</div>
{$share__html}
		</div>
	</div>
	<div id="tinymce" class="entry-content">
HTML;
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

		wp_link_pages( [
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ks' ),
			'after'  => '</div>',
		] );
echo <<<HTML
	</div><!-- .entry-content -->
</article><!-- #post-{$post_ID} -->
HTML;
