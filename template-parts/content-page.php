<!-- start #post-<?php the_ID(); ?> -->
<?php
//タイトル
$title = is_front_page() ? get_bloginfo( 'name' ) : get_the_title();
//投稿日
$date_format = get_option('date_format')." ".get_option('time_format');
$date = get_the_date($date_format);
//ページURL
$permalink = get_the_permalink($post->ID);
echo<<<HTML
<div id="description">
    <div class="flex">
        <date>{$date}</date>
        <div class="share">
            <a href="https://twitter.com/intent/tweet?url={$permalink}&text={$title}" target="_blank" rel="noopner"><svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_930_21416)"><path d="M18.2833 14.121L27.2178 3.72998H25.1006L17.3427 12.7524L11.1466 3.72998H4L13.3698 17.3734L4 28.27H6.11732L14.3098 18.7421L20.8534 28.27H28L18.2827 14.121H18.2833ZM15.3833 17.4936L14.4339 16.135L6.88022 5.32469H10.1323L16.2282 14.049L17.1776 15.4076L25.1016 26.7478H21.8495L15.3833 17.4941V17.4936Z" fill="#1B1B1E"></path></g><defs><clipPath id="clip0_930_21416"><rect width="24" height="24.54" fill="white" transform="translate(4 3.72998)"></rect></clipPath></defs></svg></a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={$permalink}" target="_blank" rel="noopner" class="fb"><svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16 3C8.82045 3 3 8.85037 3 16.0668C3 22.618 7.80114 28.0271 14.0571 28.9721V19.5301H10.8408V16.0953H14.0571V13.8098C14.0571 10.0258 15.8913 8.36452 19.0201 8.36452C20.5187 8.36452 21.3111 8.47618 21.6863 8.52726V11.5255H19.552C18.2236 11.5255 17.7597 12.7912 17.7597 14.2179V16.0953H21.6526L21.1244 19.5301H17.7597V29C24.1049 28.1346 29 22.6816 29 16.0668C29 8.85037 23.1795 3 16 3Z" fill="#1B1B1E"></path></svg></a>
            <a href="https://social-plugins.line.me/lineit/share?url={$permalink}" target="_blank" rel="noopner" class="line" style="width:32px"><img src="https://goodplus-service.co.jp/_cms/wp-content/uploads/2024/02/line_logo.png" alt="LINE" width="156" height="150" data-src="https://goodplus-service.co.jp/_cms/wp-content/uploads/2024/02/line_logo.png" style="width:90%;display:block;margin:2px auto"></a>
        </div>
    </div>
</div>
<div id="tinymce" class="entry-content">
HTML;
remove_filter ('the_content', 'wpautop');   //pタグ対策
the_content();
?>
<!-- end #post-<?php the_ID(); ?> -->
