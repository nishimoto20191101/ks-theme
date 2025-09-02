<?php
/**
 * テーマ強化機能 wp_head 
 * @package ks
 */

/**
 * bodyタグにクラスを追加
 * @param array $classes Classes for the body element.
 * @return array
 */
add_filter('body_class', function( $classes ){
	if ( ! is_singular() ) {// hfeed のクラスを追加
		$classes[] = 'hfeed';
	}
	if ( ! is_active_sidebar('sidebar-1') ) {// サイドバーが存在しない場合に、サイドバーなしのクラスを追加
		$classes[] = 'no-sidebar';
	}
	return $classes;
});
//プラグインなどで読み込まれるcss、jsの整理
add_action('wp_enqueue_scripts', function(){
    if( is_singular() ) {
		//Gutenbergエディタを使用していないときは専用CSSファイルを読み込ませない
		if ( is_plugin_active('classic-editor/classic-editor.php') || ! ( function_exists( 'use_block_editor_for_post' ) && use_block_editor_for_post( $post ) ) ) {
			wp_deregister_style('wp-block-library');
		}
    }
	wp_deregister_script('jquery');	//wordpress実装jquery削除
}, 100 );
//追加CSSに個別CSSなどを追加し簡易minify
add_filter( 'wp_get_custom_css', function( $css ) {
	if( is_singular() || is_preview()) {
		$post = get_post();
		$css .= str_replace("\r\n", '',mb_convert_kana(get_post_meta($post->ID, 'css', true), 's', 'UTF-8'));//個別
	}
    if( !empty($css) ){
        // コメント削除
        $css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );
        // 改行、タブ削除
        $css = str_replace( ["\r\n", "\r", "\n", "\t" ], '', $css );
        // スペース処理
        $css = str_replace( [ '  ', '   ', '　' ], ' ', $css );
        // その他.
        $css = str_replace( ': ', ':', $css );
        $css = str_replace( ' :', ':', $css );
        $css = str_replace( ' }', '}', $css );
        $css = str_replace( '} ', '}', $css );
    }

    return $css;
});
//get_the_archive_titleでタイトルを取得する際に「アーカイブ:」を削除
add_filter('get_the_archive_title', function($title){
	$titleArray = explode(': ',$title);
	if(!empty($titleArray[1])):
		$title = $titleArray[1];
	endif;
	return $title;
});
//日付アーカイブのタイトル調整
add_filter('wp_title', function($title, $sep, $seplocation) {
     if ( is_date() ) {
		$title = trim( $title );
		$replaces = array(
            '/([1-9]{1}[0-9]{3})/' => '$1年',
            '/ ([0-9]{1,2}) /'     => ' $1日 ',
            '/ ([0-9]{1,2})$/'     => ' $1日',
            '/[\s]+/'              => ' '
        );
        $title = preg_replace( array_keys( $replaces ), $replaces, $title );
    }
    return $title;
}, 10, 3);

// 記事の自動整形を無効化
//remove_filter('the_content', 'wpautop');
/* 投稿ページで以下タグに囲われている箇所は自動整形が無効化される
<!-- wp:html --><!-- /wp:html -->
*/