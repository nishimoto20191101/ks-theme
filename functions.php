<?php
/**
 * ks functions and definitions
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @package ks
 */
if ( ! function_exists( 'ks_setup' ) ) :
	function ks_setup() {
		// テーマ用のMOファイルをロード
		load_theme_textdomain( 'ks', get_template_directory().'/languages' );

		// wp_head()内にデフォルトのRSSフィードを出力
		add_theme_support( 'automatic-feed-links' );

		// ページ種類に応じてタイトルタグを自動的に表示（挿入）
		add_theme_support( 'title-tag' );

		// 投稿およびページでの投稿サムネイルのサポートを有効にする  * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		add_theme_support( 'post-thumbnails' );

		// ナビゲーションメニュー設定 ※ナビゲーションメニューを表示するには、wp_nav_menu()を使用
		register_nav_menus( [
			'menu-1' => esc_html__( 'Primary', 'ks' ),
		] );

		//HTML5サポート
		add_theme_support( 'html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption'] );

		// カスタム背景設定
		add_theme_support( 'custom-background', apply_filters( 'ks_custom_background_args', [ 'default-color' => 'ffffff', 'default-image' => '' ] ) );

		// ウィジェット再読み込み
		add_theme_support( 'customize-selective-refresh-widgets' );

		// カスタムロゴ設定 @link https://codex.wordpress.org/Theme_Logo
		add_theme_support( 'custom-logo', [ 'height' => 300, 'width' => 300, 'flex-width'  => true,	'flex-height' => true ] );
	}
endif;
add_action( 'after_setup_theme', 'ks_setup' );

// 動画や写真を投稿する際のコンテンツの最大幅を設定  @global int $content_width
add_action( 'after_setup_theme', function() {
	// @link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'ks_content_width', 640 );
}, 0 );

// キューにscripts と styles のデータを格納
add_action( 'wp_enqueue_scripts', function() {
	wp_enqueue_style( 'ks-style', get_stylesheet_uri() );
	//wp_enqueue_script( 'ks-navigation', get_template_directory_uri().'/js/navigation.js', [], '20151215', true );
	//wp_enqueue_script( 'ks-skip-link-focus-fix', get_template_directory_uri().'/js/skip-link-focus-fix.js', [], '20151215', true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
} );

/* コメント機能停止 */
//add_filter( 'comments_open', '__return_false' );

/** * Implement the Custom Header feature. */
require get_template_directory().'/inc/custom-header.php';

/** * Custom template tags for this theme. */
require get_template_directory().'/inc/template-tags.php';

/* テーマ強化機能 wp_head  */
require get_template_directory().'/inc/template-functions.php';

/* カスタマイザ */
require get_template_directory().'/inc/customizer.php';

/* 管理画面制御（テーマカスタマイズ除く） */
require get_template_directory().'/inc/custom-management.php';

/* カスタムフィールド */
require get_template_directory().'/inc/custom-field.php';

/* タクソノミー（カスタム投稿） */
require get_template_directory().'/inc/custom-taxonomy.php';

/* ウィジェット */
require get_template_directory().'/inc/custom-widgets.php';

/* プラグインカスタムコード */
require get_template_directory().'/inc/custom-plugins.php';

//スマホ判定
function _ua_smt (){
	$ua = $_SERVER['HTTP_USER_AGENT'];
	$ua_list = array('iPhone','iPad','iPod','Android');  //スマホと判定する文字リスト
	foreach ($ua_list as $ua_smt) {
		if (strpos($ua, $ua_smt) !== false) {
			return true;
		}
	} return false;
}