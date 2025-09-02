<?php
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
add_action( 'widgets_init', function() {
	register_sidebar( [
		'name'          => esc_html__( 'Sidebar', 'ks' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'ks' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	] );
	register_sidebar( [
		'name'          => esc_html__( 'Content header', 'ks' ),
		'id'            => 'content_header',
		'description'   => esc_html__( 'Add widgets here.', 'ks' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	] );
	register_sidebar( [
		'name'          => esc_html__( 'Content top', 'ks' ),
		'id'            => 'content_top',
		'description'   => esc_html__( 'Add widgets here.', 'ks' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	] );
	register_sidebar( [
		'name'          => esc_html__( 'Content bottom', 'ks' ),
		'id'            => 'content_bottom',
		'description'   => esc_html__( 'Add widgets here.', 'ks' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	] );
	register_sidebar( [
		'name'          => esc_html__( 'Content footer', 'ks' ),
		'id'            => 'content_footer',
		'description'   => esc_html__( 'Add widgets here.', 'ks' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	] );
	register_sidebar( [
		'name'          => esc_html__( 'header', 'ks' ),
		'id'            => 'header',
		'description'   => esc_html__( 'Add widgets here.', 'ks' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	] );
	register_sidebar( [
		'name'          => esc_html__( 'footer', 'ks' ),
		'id'            => 'footer',
		'description'   => esc_html__( 'Add widgets here.', 'ks' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	] );
/*	// 作成するカスタム投稿タイプ情報を読み込み
	$ks_post_type = new WP_ks_post_type();
    $ks_post_types = $ks_post_type->get();
	//配列を基にカスタム投稿タイプを設定`
	if( !empty($ks_post_types)){
		foreach( $ks_post_types as $key => $val ){
			register_sidebar( [
				'name'          => esc_html__( "{$key} sidebar", 'ks' ),
				'id'            => "{$key}_sidebar",
				'description'   => esc_html__( 'Add widgets here.', 'ks' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			] );
			register_sidebar( [
				'name'          => esc_html__( "{$key} Content header", 'ks' ),
				'id'            => "{$key}_header",
				'description'   => esc_html__( 'Add widgets here.', 'ks' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			] );
			register_sidebar( [
				'name'          => esc_html__( "{$key} Content top", 'ks' ),
				'id'            => "{$key}_top",
				'description'   => esc_html__( 'Add widgets here.', 'ks' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			] );
			register_sidebar( [
				'name'          => esc_html__( "{$key} Content bottom", 'ks' ),
				'id'            => "{$key}_bottom",
				'description'   => esc_html__( 'Add widgets here.', 'ks' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			] );
			register_sidebar( [
				'name'          => esc_html__( "{$key} Content footer", 'ks' ),
				'id'            => "{$key}_footer",
				'description'   => esc_html__( 'Add widgets here.', 'ks' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			] );
		}
	}*/
} );
