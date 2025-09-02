<?php
//**********************************************************//
//*******************　管理画面表示調整  *******************//
//ログインロゴ
add_action('login_head', function(){
    $common_disp = get_option('common_disp');
    if(!empty($common_disp['logo'])){
        echo <<<HTML
 <style>
    .login h1 a{ background-image:url("{$common_disp['logo']}"); background-size:contain; width:320px; <height:10></height:100px;}
 </style>
HTML;
    }
});
// ロゴのリンク先を指定
add_filter( 'login_headerurl', function(){return get_bloginfo( 'url' );});
// ロゴのtitleテキストを指定
add_filter( 'login_headertitle', function(){return get_option( 'blogname' );});
//管理画面メニュー編集
add_action('admin_menu', function(){
  global $menu, $submenu;
  add_menu_page( 'すべての投稿', 'すべての投稿', 'manage_options',  'all',  'disp_all_posts_content',  'dashicons-menu-alt3', 3);
  add_options_page( 'カスタム投稿タイプ', 'カスタム投稿タイプ', 'manage_options',  'ks_post_type',  'disp_custom_post_type_content', 3);
  add_submenu_page('themes.php', '追加CSS例', '※追加CSS例', 'read', 'disp_sample_add_css', 'disp_sample_add_css', 'disp_sample_add_css', 21);
  add_submenu_page('themes.php', 'ウィジェットエリア', '※ウィジェットエリア', 'read', 'disp_widget_layout', 'disp_widget_layout', 'disp_widget_layout', 22);
  //サブメニュー並び替え
  $themes_menu = $submenu['themes.php']; //print_r($submenu['themes.php']);
  $submenu['themes.php'] = [ $themes_menu[5], $themes_menu[7], $themes_menu[21], $themes_menu[8], $themes_menu[22], $themes_menu[10] ];
});
if(! function_exists( 'ks_header_style')){
	function ks_header_style(){
		$header_text_color = get_header_textcolor();
		if( get_theme_support( 'custom-header', 'default-text-color') === $header_text_color ){return;}
		echo '<style>';
		if( !display_header_text() ){
			echo ".site-title,.site-description{position: absolute;clip: rect(1px, 1px, 1px, 1px)}";
		}else{
			$header_text_color = esc_attr( $header_text_color );
			echo ".site-title a, .site-description{color:#{$header_text_color}}";
		}
		echo '</style>';
	}
}
// すべての投稿一覧表示
function disp_all_posts_content() {
  require get_template_directory().'/inc/class.WP_All_Posts_List_Table.php';
  $list_table = new WP_All_Posts_List_Table();
  $list_table->prepare_items();
  $s = !empty($_GET['s']) ? $_GET['s'] : "";
  echo <<<HTML
    <div class="wrap">
      <h1 class="wp-heading-inline">すべての投稿</h1>
      <form method="get">
        <p class="search-box">
          <label class="screen-reader-text" for="post-search-input">探す:</label>
          <input type="hidden" name="page" value="all">
          <input type="search" id="post-search-input" name="s" value="{$s}">
          <input type="submit" id="search-submit" class="button" value="探す">
        </p>
      </form>
HTML;
  $list_table->display();
  echo <<<HTML
    </div>
<style>
  th#id{width:3.5em}
  th#post_type{width:10em}
</style>
HTML;
}
// カスタム投稿タイプ
function disp_custom_post_type_content(){
  $result = "";
  $action = "";
  $ks_post_types = new WP_ks_post_type();
  $ks_post_type = new WP_ks_post_type();
  $disp = !empty($_REQUEST["disp"]) ? $_REQUEST["disp"] : "";
  $key = !empty($_REQUEST["key"]) ? $_REQUEST["key"] : "";
  if(!empty($_POST['action'])){
    $ks_post_types = $ks_post_type->get();
    if( $_POST['action'] == "upload"){
      $action = "インポート";
      $uploadfile = $ks_post_types->get_file_path();
      if(!empty($uploadfile) && !empty($_FILES["configfile"]) && is_uploaded_file($_FILES["configfile"]["tmp_name"] )){
        $file_tmp_name = $_FILES["configfile"]["tmp_name"];
				$file_name = $_FILES["configfile"]["name"];
        if( move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile) ) {
          $message = "{$action}完了しました。";
          $status = "updated";
        }else{
          $message = "{$action}失敗しました。";
          $status = "error";
        }
      }
    }else if( !empty($_POST['key']) ){
      if( $_POST['action'] == "del" ){
        unset($ks_post_types->$key); //array_splice($sched_data, $_POST["sched_no"], 1);
        $action = "削除";
        $disp = "list";
      }else{
        empty($ks_post_types) && ( $ks_post_types = (object)[] );
        $ks_post_types->$key = (object)[]; (object)[];
        $ks_post_types->$key->name = $_POST['name'];
        $ks_post_types->$key->category_comm = !empty($_POST['category_comm']) ? 1 : '';        
        $ks_post_types->$key->category = !empty($_POST['category']) ? 1 : '';
        $ks_post_types->$key->tag_comm = !empty($_POST['tag_comm']) ? 1 : '';        
        $ks_post_types->$key->tag = !empty($_POST['tag']) ? 1 : '';
        $ks_post_types->$key->thumbnail = !empty($_POST['thumbnail']) ? 1 : '';
        $ks_post_types->$key->editor = !empty($_POST['public']) ? 1 : '';
        $ks_post_types->$key->archive = !empty($_POST['archive']) ? 1 : '';
        $ks_post_types->$key->public = !empty($_POST['public']) ? 1 : '';
        $action = !empty($_POST["new"]) ? "登録" : "更新";
      }
      $flg = $ks_post_type->set($ks_post_types);
      $message = "{$action}完了しました。";
      $status = "updated";
    }
    if( !empty($action) ){
			$result .= <<<HTML
			<div id="message" class="notice notice-{$status} is-dismissible inline notice-alt {$status}" data-slug="post_types-slug">
				<p>{$message}</p>
			</div>
HTML;
    }
  }
  $result .= <<<HTML
    <div class="wrap">
			<h2 style="margin-bottom:2rem">カスタム投稿タイプ</h2>
HTML;
  switch($disp){
    case "edit" :
      $result .= $ks_post_type->disp_edit($key);
      break;
    default :
      $result .= $ks_post_type->disp_list();
      break;
  }
  echo $result;
}
//表示：追加CSS入力例
function disp_sample_add_css(){
  $sample_css = file_get_contents( get_stylesheet_directory().'/css/sample.css' );
  $sample_css = str_replace( '<', '&lt;', $sample_css );
  $sample_css = str_replace( '>', '&gt;', $sample_css );
  echo <<<HTML
    <div class="wrap">
     <h1>追加CSS例</h1>
<pre style="display:block;white-space:pre;width:calc(100% - 40px);background-color:#000;color:#fff;padding:1rem">{$sample_css}</pre>
    </div>
HTML;
}
//表示：ウィジェットエリア
function disp_widget_layout(){
  echo <<<HTML
    <div class="wrap">
     <h1>ウィジェットエリア</h1>
     <p>以下の構成でウィジェットエリアが配置されます。<br>※デフォルトテンプレートを選択した場合の配置になります。<br>※[]内の文字列がウィジェットエリア名です。<br><!--※カスタム投稿タイプを作成した場合は、カスタム投稿タイプ用ウィジェットエリアが生成されます。<br>※カスタム投稿タイプ用ウィジェットエリア名は、先頭にカスタム投稿タイプ名がつきます。<br>※カスタム投稿タイプ用ウィジェットエリアが設定されていない場合は、デフォルトのウィジェットエリアが表示されます。--></p>
     <div class="ks_layout">
        <div style="flex-basis:100%">
          header
          <div class="widget" style="flex-basis:100%">[header]</div>
        </div>
        <div class="widget" style="flex-basis:100%">[Contant header]</div>
        <div style="flex:1">
          <div class="widget">[Content top]</div>
          <div style="line-height:4em">投稿内容</div>
          <div class="widget">[Content bottom]</div>
        </div>
        <div class="widget" style="flex-basis:20%"><span style="display:block;position:relative;top:50%;transform:translateY(-50%)">[Sidebar]</span></div>
        <div class="widget" style="flex-basis:100%">[Content footer]</div>
        <div style="flex-basis:100%">
          <div class="widget" style="flex-basis:100%">[footer]</div>
          footer
        </div>
     </div>
    </div>
    <style>
  .ks_layout{display:flex;flex-wrap:wrap;max-width:100%;width:60em;text-align:center}
  .ks_layout div{border:1px #000 solid;line-height:3em;margin:5px}
  .ks_layout .widget{background-color:#e0e0e0}
</style>
HTML;
}
//ビジュアルエディタcss制御
add_action('admin_init', function(){
  $style_uri = get_template_directory_uri();
  //add_editor_style( $style_uri.'/css/common.min.css' );
  add_editor_style( $style_uri.'/css/editor-style.min.css?202506' );
});
//ビジュアルエディタ調整（空の span タグや i タグが消されるのを防止、追加css反映）
if ( ! function_exists('tinymce_init') ) {
  add_filter( 'tiny_mce_before_init', function( $init ) {
    $init['verify_html'] = false; // 空タグや属性なしのタグを削除しない
    $init['valid_children'] = '+body[style], +div[div|span|a], +span[span]'; // 指定の子要素を削除しない
    $common_css = file_get_contents(get_template_directory().'/css/common.min.css');
    $css = json_encode($common_css.wp_get_custom_css());
    echo <<<HTML
<script>
function ks_add_css( ed ){
  var css_base = "";
  ed.onInit.add( function() {
    tinyMCE.activeEditor.dom.addStyle({$css});  //追加CSS
    css_base = document.querySelector("#content_ifr").contentDocument.querySelector("#mceDefaultStyles").textContent;
    tinyMCE.activeEditor.dom.addStyle(document.getElementById('css').value);  //カスタムフィールド
  });
  document.querySelector("#css").addEventListener("change", function(e) {
    document.querySelector("#content_ifr").contentDocument.querySelector("#mceDefaultStyles").textContent = css_base;
    tinyMCE.activeEditor.dom.addStyle(e.target.value);  //カスタムフィールド
  });
}
</script>
HTML;
    //if(wp_default_editor() == 'tinymce'){
      $init['setup'] = 'ks_add_css';
    //}
    return $init;
  }, 100 );
}
//拡張子許可設定
add_filter('upload_mimes', function( $existing_mimes=[] ) {
   $existing_mimes['ico'] = 'image/vnd.microsoft.icon';
   $existing_mimes['svg'] = 'image/svg+xml';
   $existing_mimes['webp'] = 'image/webp';
   return $existing_mimes;
 });
//許可HTMLタグ設定
add_filter('wp_kses_allowed_html', function($tags, $context){
	$tags['img']['src'] = true;
	$tags['script']['src'] = true;
	$tags['link']['href'] = true;
	$tags['input']['value'] = true;
	return $tags;
}, 10, 2 );
//スラッグ名に全角文字が含まれる場合、自動的にidへ変更（スラッグを設定した場合は適用しない）
add_filter( 'wp_unique_post_slug', function( $slug, $post_ID, $post_status, $post_type ){
    if( preg_match( '/(%[0-9a-f]{2})+/', $slug ) ){
        $slug = $post_ID;
    }
    return $slug;
}, 10, 4  );
//カスタムフィールドの変更内容をプレビューに反映
add_action('wp_insert_post', function ($postId) {
	if ( wp_is_post_revision( $postId ) ) {
		// カスタムフィールドのキー名
		$job_meta_ary = ["css", "js"];
		foreach ($job_meta_ary as $value) {
      if(!empty($_POST[$value])){
  			update_metadata('post', $postId, $value, $_POST[$value]);
      }
	  }
	  do_action( 'save_preview_postmeta', $postId );
	}
});
