<?php
/**
 * ks Theme Customizer
 *
 * @package ks
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
add_action( "customize_register", function( $wp_customize ) {
	/* カスタマイザから削除 */
	$wp_customize->remove_section("title_tagline"); //サイト基本情報
	//$wp_customize->remove_section("colors"); //色
	$wp_customize->remove_control("header_image"); //ヘッダー画像
	$wp_customize->remove_section("background_image"); //背景画像
	$wp_customize->remove_panel("widgets"); //ウィジェット
	remove_action( 'customize_controls_enqueue_scripts', [$wp_customize->widgets, 'enqueue_scripts'] );
	//$wp_customize->remove_section("static_front_page"); //ホームページ設定
	//$wp_customize->remove_section("custom_css"); //追加CSS
	//$wp_customize->get_panel('nav_menus')->active_callback = '__return_false';
	
	// ▼ オリジナルパネル
	//common_disp	
	$wp_customize->add_section( 'common_disp', [
		'title'       => '画像、コピーライト', // 項目名
       	'description' => __('ロゴやnoImage画像を設定します。', 'mytheme'),
		'priority'    => 0, // 優先順位
	]);

	if(class_exists('WP_Customize_Image_Control')){
	  $wp_customize->add_setting('common_disp[logo]', [
		'type' => 'option',
		'transport' => 'postMessage', 
	  ]);
	  $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'common_disp_logo', [
		'settings' => 'common_disp[logo]',
		'label' => 'ヘッダーロゴ画像',
		'section' => 'common_disp',
		'extensions' => [ 'jpg', 'jpeg', 'gif', 'png', 'svg' ]
	  ]));

	  $wp_customize->add_setting('common_disp[footer_logo]', [
		'type' => 'option',
		'transport' => 'postMessage', 
	  ]);
	  $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'common_disp_footer_logo', [
		'settings' => 'common_disp[footer_logo]',
		'label' => 'フッターロゴ画像',
		'section' => 'common_disp',
		'extensions' => [ 'jpg', 'jpeg', 'gif', 'png', 'svg' ]
	  ]));

	  $wp_customize->add_setting('common_disp[noImage]', [
		'type' => 'option',
		'transport' => 'postMessage', 
	  ]);
	  $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'common_disp_noImage', [
		'settings' => 'common_disp[noImage]',
		'label' => 'noImage画像',
		'section' => 'common_disp',
		'extensions' => [ 'jpg', 'jpeg', 'gif', 'png', 'svg' ],
		'description' => '※.image.noimageの背景画像として設定されます。細かな表示調整はCSSで行ってください。'
	  ]));
	}

	$wp_customize->add_setting( 'common_disp[copyright]', [
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage', 
	]);
	$wp_customize->add_control( 'common_disp_copyright', [
		'settings'  => 'common_disp[copyright]', 
		'label'     => 'コピーライト', 
		'section'   => 'common_disp', 
		'type'      => 'text', 
	]);

	$wp_customize->add_setting( 'colors[body_bg]', [
		'default'   => '#fff',
		'type'      => 'option',
		'transport' => 'postMessage', 
	]);
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'colors_body_bg', [
		'settings'  => 'colors[body_bg]', 
		'label'     => '背景色', 
		'section'   => 'colors', 
	]));

	$wp_customize->add_setting( 'colors[header]', [
		'default'   => '#000',
		'type'      => 'option',
		'transport' => 'postMessage', 
	]);
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'colors_header', [
		'settings'  => 'colors[header]', 
		'label'     => 'ヘッダ文字色', 
		'section'   => 'colors', 
	]));

	$wp_customize->add_setting( 'colors[footer]', [
		'default'   => '#000',
		'type'      => 'option',
		'transport' => 'postMessage', 
	]);
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'colors_footer', [
		'settings'  => 'colors[footer]', 
		'label'     => 'フッタ文字色', 
		'section'   => 'colors', 
	]));

	$wp_customize->add_setting( 'colors[footer_bg]', [
		'default'   => 'transparent',
		'type'      => 'option',
		'transport' => 'postMessage', 
	]);
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'colors_footer_bg', [
		'settings'  => 'colors[footer_bg]', 
		'label'     => 'フッタ背景色', 
		'section'   => 'colors', 
	]));

	$wp_customize->add_setting( 'colors[copyright]', [
		'default'   => 'inherit',
		'type'      => 'option',
		'transport' => 'postMessage', 
	]);
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'colors_copyright', [
		'settings'  => 'colors[copyright]', 
		'label'     => 'コピーライト文字色', 
		'section'   => 'colors', 
	]));

	$wp_customize->add_setting( 'colors[copyright_bg]', [
		'default'   => 'transparent',
		'type'      => 'option',
		'transport' => 'postMessage', 
	]);
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'colors_copyright_bg', [
		'settings'  => 'colors[copyright_bg]', 
		'label'     => 'コピーライト背景色', 
		'section'   => 'colors', 
	]));

	//タグ情報
	$wp_customize->add_section( 'tags', [
		'title'     => 'タグ情報', // 項目名
		'priority'  => 200, // 優先順位
	]);

	$wp_customize->add_setting( 'tags[gtm]', [
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage', // 表示更新のタイミング。デフォルトは'refresh'（即時反映）
	]);
	$wp_customize->add_control( 'gtm', [
		'settings'  => 'tags[gtm]', // settingのキー
		'label'     => 'GTM ID', // ラベル名
		'section'   => 'tags', // sectionを指定
		'type'      => 'text', 
		'description' => '※Google tag ManagerのIDを入力してください。&lt;head&gt;タグ内と&lt;body&gt;タグ直後にコードが追記されます。'
	]);

	$wp_customize->add_setting( 'tags[head]', [
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage', // 表示更新のタイミング。デフォルトは'refresh'（即時反映）
	]);
	$wp_customize->add_control( 'head', [
		'settings'  => 'tags[head]', // settingのキー
		'label'     => '&lt;head&gt;タグ内', // ラベル名
		'section'   => 'tags', // sectionを指定
		'type'      => 'textarea', 
		'description' => '※&lt;head&gt;タグ内に追記するコードを記載してください。GTMの設定をされた場合はコードが自動生成されていますので重複に気を付けてください。'
	]);

	$wp_customize->add_setting( 'tags[body_IA]', [
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage', // 表示更新のタイミング。デフォルトは'refresh'（即時反映）
	]);
	$wp_customize->add_control( 'body_IA', [
		'settings'  => 'tags[body_IA]', // settingのキー
		'label'     => '&lt;body&gt;タグ直後', // ラベル名
		'section'   => 'tags', // sectionを指定
		'type'      => 'textarea', 
		'description' => '※&lt;head&gt;直後に追記するコードを記載してください。GTMの設定をされた場合は自動生成されたGTMコードの後に追記されます。'
	]);


	//corp_info
	$wp_customize->add_section( 'corp_info', [
		'title'       => '会社情報', // 項目名
       	'description' => __('ショートコードが使用できます。', 'mytheme'),
		'priority'    => 201, // 優先順位
	]);


	$wp_customize->add_setting( 'corp_info[inquiry_tel]', [
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage', 
	]);
	$wp_customize->add_control( 'ommon_disp_inquiry_tel', [
		'settings'  => 'corp_info[inquiry_tel]', 
		'label'     => '問い合わせ電話番号', 
		'section'   => 'corp_info', 
		'type'      => 'text', 
		'description' => '[ks_corp key=inquiry_tel] '
	]);

	$wp_customize->add_setting( 'corp_info[corp_name]', [
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage', 
	]);
	$wp_customize->add_control( 'ommon_disp_corp_name', [
		'settings'  => 'corp_info[corp_name]', 
		'label'     => '会社名', 
		'section'   => 'corp_info', 
		'type'      => 'text', 
		'description' => '[ks_corp key=corp_name] '
	]);

	$wp_customize->add_setting( 'corp_info[corp_zip]', [
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage', 
	]);
	$wp_customize->add_control( 'ommon_disp_corp_zip', [
		'settings'  => 'corp_info[corp_zip]', 
		'label'     => '郵便番号', 
		'section'   => 'corp_info', 
		'type'      => 'text', 
		'description' => '[ks_corp key=corp_zip] '
	]);

	$wp_customize->add_setting( 'corp_info[corp_addr]', [
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage', 
	]);
	$wp_customize->add_control( 'ommon_disp_corp_addr', [
		'settings'  => 'corp_info[corp_addr]', 
		'label'     => '住所', 
		'section'   => 'corp_info', 
		'type'      => 'text', 
		'description' => '[ks_corp key=corp_addr] '
	]);

	$wp_customize->add_setting( 'corp_info[corp_tel]', [
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage', 
	]);
	$wp_customize->add_control( 'ommon_disp_corp_tel', [
		'settings'  => 'corp_info[corp_tel]', 
		'label'     => '電話番号', 
		'section'   => 'corp_info', 
		'type'      => 'text', 
		'description' => '[ks_corp key=corp_tel] '
	]);

	$wp_customize->add_setting( 'corp_info[corp_fax]', [
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage', 
	]);
	$wp_customize->add_control( 'ommon_disp_corp_fax', [
		'settings'  => 'corp_info[corp_fax]', 
		'label'     => 'FAX番号', 
		'section'   => 'corp_info', 
		'type'      => 'text', 
		'description' => '[ks_corp key=corp_fax] '
	]);
	
	$wp_customize->add_setting( 'corp_info[corp_reception]', [
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage', 
	]);
	$wp_customize->add_control( 'corp_reception', [
		'settings'  => 'corp_info[corp_reception]', 
		'label'     => '営業時間', 
		'section'   => 'corp_info', 
		'type'      => 'text', 
		'description' => '[ks_corp key=corp_reception] '
	]);

	$wp_customize->add_setting( 'corp_info[corp_holiday]', [
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage', 
	]);
	$wp_customize->add_control( 'corp_holiday', [
		'settings'  => 'corp_info[corp_holiday]', 
		'label'     => '定休日', 
		'section'   => 'corp_info', 
		'type'      => 'text', 
		'description' => '[ks_corp key=corp_holiday] '
	]);


}, 11 );
/* 読み出し用shortcode */
add_shortcode('ks_corp', function($atts){
	 extract(shortcode_atts([
		'key' => ''
    ], $atts));
	$result = get_option('corp_info');
	return $result[$key];
});
