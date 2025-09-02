<?php
/* =========================================== */
/* カスタム投稿タイプ 
* (例)
* $ks_post_types = [
*    'info'      => [ 'name' => 'お知らせ', 'category' => true, 'tag' => false, 'thumbnail' => true, 'editor' => true, 'archive' => true, 'public' => true ],
*    'faq'       => [ 'name' => 'よくある質問', 'category' => true, 'tag' => false, 'thumbnail' => false, 'editor' => true, 'archive' => true, 'public' => false ]
*    'home_main' => [ 'name' => 'HOMEメイン画像', 'category' => false, 'tag' => false, 'thumbnail' => false, 'editor' => false, 'archive' => false, 'public' => false ]
* 
/* =========================================== */
require_once get_template_directory().'/inc/class.WP_ks_post_type.php';

add_action( 'init', function(){
    $ks_post_types = [];
    // 作成するカスタム投稿タイプ情報を読み込み
    $ks_post_type = new WP_ks_post_type();
    $ks_post_types = $ks_post_type->get();

    if(empty($ks_post_types)){return false;}
    //配列を基にカスタム投稿タイプを設定`
    foreach( $ks_post_types as $key => $val ){
        $val->show_ui = isset($val->show_ui) ? $val->show_ui : true;
        $labels = [
            'name' => _x($val->name, 'post type general name'),
            'singular_name' => _x($val->name, 'post type singular name'),
            'add_new' => _x('新規追加', $key),
            'add_new_item' => __("新しい{$val->name}を追加"),
            'edit_item' => __("{$val->name}を編集"),
            'new_item' => __("新しい{$val->name}"),
            'view_item' => __("{$val->name}を表示"),
            'search_items' => __("{$val->name}で探す"),
            'not_found' => __("{$val->name}はありません"),
            'not_found_in_trash' => __("ゴミ箱に{$val->name}はありません"),
            'parent_item_colon' => ''
        ];
        $supports = ['title', 'revisions'];
        //コンテンツエディタ
        !empty($val->editor)    && ($supports[] = 'editor'); 
        //アイキャッチ設定
        !empty($val->thumbnail) && ($supports[] = 'thumbnail');
        //コメント
        !empty($val->comments) && ($supports[] = 'comments');
        //設定
        $capabilities = [
            "edit_posts" => "edit_{$key}", 
            "edit_others_posts" => "edit_others_{$key}", 
            "edit_private_posts" => "edit_private_{$key}", 
            "edit_published_posts" => "edit_published_{$key}", 
            'delete_posts' => "delete_{$key}", 
            'delete_private_posts' => "delete_private_{$key}", 
            'delete_others_posts' => "delete_others_{$key}", 
            'delete_published_posts' => "delete_published_{$key}", 
            'publish_posts' => "publish_{$key}", 
            'read_private_posts' => "read_private_{$key}"
        ];
        // 管理者に独自権限を付与
        $role = get_role( 'administrator' );
        foreach ( $capabilities as $cap ) {
            $role->add_cap( $cap );
        }
        if( empty($val->taxonomies) || ! is_array($val->taxonomies) ){
            $val->taxonomies = [];
            if( !empty($val->category_comm) ){
                $val->taxonomies[] = "category";
            }
            if( !empty($val->category) ){
                $val->taxonomies[] = "{$key}_cat";
            }
        }        
        $args = [
            'labels' => $labels,
            'public' => !empty($val->public),   /*詳細ページ生成 */
            'show_ui' => !empty($val->show_ui),
            'rewrite' => true,
            'rewrite_withfront' => true,
            'rewrite_hierarchical' => true,
            'query_var' => true,
            'has_archive' => !empty($val->archive),/* アーカイブ生成  */
            'hierarchical' => false,
            'exclude_from_search' => false,
            'capability_type' => "post_{$key}",
            'capabilities' => $capabilities,
            'map_meta_cap' => true,//デフォのメタ情報処理を利用の有無
            'publicly_queryable' => true,/* 投稿画面に表示 */
            'supports' => $supports,
            'taxonomies' => $val->taxonomies
        ];
        register_post_type($key, $args);
        //カテゴリ設定
        if( !empty($val->taxonomies) ){
            // タクソノミー
            foreach( $val->taxonomies as $category ){
                if( $category == "category"){continue;}
                $label =  "{$val->name}カテゴリー";
                $args_cat = [
                    'label' => $label,
                    'public' => true,
                    'show_ui' => true, /* 項目の表示 */
                    'query_var' => true,
                    'hierarchical' => true, /* 階層化あり */
                    'rewrite' => ['slug' => "{$key}/cat"],
                    'singular_label' => $val->name,
                    'update_count_callback' => '_update_post_term_count',
                ];
                register_taxonomy($category, $key, $args_cat);
                add_rewrite_rule($key.'/cat/([^/]+)/?$', 'index.php?'.$category.'=$matches[1]', 'top');//URL調整
            }
        }
        //タグ設定
        if( !empty($val->tag) ){
            $label = $val->tag == 1 || $val->tag === true ? "タグ" : $val->tag;
            $labels = [
                'name' => _x($label, 'post type general name'),
                'singular_name' => _x($label, 'post type singular name'),
                'add_new_item' => __("新しい{$label}を追加"),
                'edit_item' => __("{$label}を編集"),
                'new_item' => __('新規'.$label),
                'view_item' => __("{$label}を表示"),
                'search_items' => __("{$label}で探す"),
                'not_found' => __("{$label}はありません"),
                'not_found_in_trash' => __("ゴミ箱に{$label}はありません"),
                'parent_item_colon' => ''
            ];    
            $args_tag = [
                'label' => $label, //ダッシュボードに表示させる名前
                'public' => true,
                'show_ui' => true,
                'query_var' => true,
                'show_admin_column' => true,
                'hierarchical' => true, //階層化あり 投稿画面で一覧表示させるためには階層化されたタームであることが条件
                //'rewrite' => ['slug' => "{$key}/tag"],
                'rewrite' => ['slug' => "tag"],
                'singular_label' => $val->name,
                'update_count_callback' => '_update_post_term_count',               
                '_builtin' => true,
                'labels' => $labels
            ];
            register_taxonomy($key.'_tag', $key, $args_tag);
            add_rewrite_rule($key.'/tag/([^/]+)/?$', 'index.php?'.$key.'_tag=$matches[1]', 'top');//URL調整
        }
        //クイック編集
        add_filter( 'manage_'.$key.'_posts_columns', function( $defaults ) {
            $defaults['_comments'] = 'comments';
            return $defaults;
        });
        add_action( 'manage_cosmetic_posts_custom_column' , function( $column, $post_id ){
            echo 'hoge';
        }, 10, 2 );
    }
});
flush_rewrite_rules( false );



