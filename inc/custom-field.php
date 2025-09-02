<?php
/**
 * カスタムフィールド用セクションの宣言
 */
add_action('admin_menu', function(){
  $post_types = get_post_types(['public' => true,'_builtin' => false]);
  $post_types = array_merge(['post', 'page'], array_values($post_types));
  add_meta_box(
    'custom_css', //セクションのID
    'カスタムCSS', //セクションのタイトル
    'insert_custom_css', //フォーム部分を指定する関数
    $post_types, //投稿タイプ名
    'normal', //セクションの表示場所
    'default'  //優先度
  );
  add_meta_box(
    'custom_js', //セクションのID
    'カスタムJavaScript', //セクションのタイトル
    'insert_custom_js', //フォーム部分を指定する関数
    $post_types, //投稿タイプ名
    'normal', //セクションの表示場所
    'default'  //優先度
  );
});

/**
 * 入力フォーム
 */
function insert_custom_css($post){
  //nounceフィールドの追加
  wp_nonce_field('custom_field_save_meta_box_data', 'custom_field_meta_box_nonce');
  //すでに保存されているデータを取得
  $css = get_post_meta($post->ID, 'css', true);
  echo <<<HTML
  <textarea name="css" id="css" style="width:100%;height:20em">{$css}</textarea>
HTML;
}

function insert_custom_js($post){
  //すでに保存されているデータを取得
  $js = get_post_meta($post->ID, 'js', true);
  echo <<<HTML
  <textarea name="js" id="js" style="width:100%;height:20em">{$js}</textarea>
HTML;
}

/**
 * データの保存処理
 */
add_action('save_post', function($post_id){
  //nounce：セットされているか確認 && 正しいか検証
  if (!empty($_POST['custom_field_meta_box_nonce']) && !wp_verify_nonce($_POST['custom_field_meta_box_nonce'], 'custom_field_save_meta_box_data')){
    return;
  }
  //データ保存
  if(isset($_POST['css'])){ //css
    //$data = sanitize_textarea_field($_POST['css']);
    $data = $_POST['css'];
    update_post_meta($post_id, 'css', $data);
  }
  if(isset($_POST['js'])){ //js
    //$data = sanitize_textarea_field($_POST['js']);
    $data = $_POST['js'];
    $data = str_replace(":", "：", $data);
    update_post_meta($post_id, 'js', $data);
  }
});

/*
// カスタムフィールドを検索対象に含む(「-キーワード」のようなNOT検索にも対応)
add_filter( 'posts_search', function ( $orig_search, $query ){
	if ( $query->is_search() && $query->is_main_query() && is_admin() ){
		// 4.4のWP_Query::parse_search()の処理を流用。(検索語の分割処理などはすでにquery_vars上にセット済)
		global $wpdb;
		$q = $query->query_vars;
		$n = ! empty( $q['exact'] ) ? '' : '%';
		$searchand = '';
        if(is_array($q['search_terms'])){
            foreach ( $q['search_terms'] as $term ){
                $include = '-' !== substr( $term, 0, 1 );
                if ( $include ){
                    $like_op  = 'LIKE';
                    $andor_op = 'OR';
                } else {
                    $like_op  = 'NOT LIKE';
                    $andor_op = 'AND';
                    $term     = substr( $term, 1 );
                }
                $like = $n . $wpdb->esc_like( $term ) . $n;
                // カスタムフィールド用の検索条件を追加
                $search .= $wpdb->prepare( "{$searchand}(($wpdb->posts.post_title $like_op %s) $andor_op ($wpdb->posts.post_content $like_op %s) $andor_op (custom.meta_value $like_op %s))", $like, $like, $like );
                $searchand = ' AND ';
            }    
        }
		if ( ! empty( $search ) ){
			$search = " AND ({$search}) ";
			if ( ! is_user_logged_in() )
				$search .= " AND ($wpdb->posts.post_password = '') ";
		}
		return $search;
	}
	else {
		return $orig_search;
	}
}, 10, 2 );
// カスタムフィールド検索用のJOIN
add_filter( 'posts_join', function( $join, $query ){
	if ( $query->is_search() && $query->is_main_query() && is_admin() ){
		// group_concat()したmeta_valueをJOINすることでレコードの重複を除きつつ検索しやすくします。
		global $wpdb;
		$join .= " INNER JOIN ( ";
		$join .= " SELECT post_id, group_concat( meta_value separator ' ') AS meta_value FROM $wpdb->postmeta ";
		// $join .= " WHERE meta_key IN ( 'test' ) ";
		$join .= " GROUP BY post_id ";
		$join .= " ) AS custom ON ($wpdb->posts.ID = custom.post_id) ";
	}
	return $join;
}, 10, 2 );
*/