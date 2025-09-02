<?php
/* =========================================== */
/* カスタム投稿タイプ 
   ・key    : カスタム投稿
   ・value
     name     : 管理画面などに表示されるカスタム投稿名
     category : カテゴリ (true or false)
     tag      : タグ (true or false)
     thumbnail: アイキャッチ (true or false)
     editor   : ブロックエディタ (true or false)
     archive  : アーカイブページ (true or false)
     public   : 詳細&アーカイブ、サイト内検索、メニュ(true or false)

 * 詳細&アーカイブ無、プログラムなどで呼び出し 'archive' => false, 'public' => false
 * 詳細ページ有、アーカイブ無                 'archive' => false, 'public' => true
$ks_post_types = [
    'info'      => [ 'name' => 'お知らせ', 'category' => true, 'tag' => false, 'thumbnail' => true, 'editor' => true, 'archive' => true, 'public' => true ],
    'faq'       => [ 'name' => 'よくある質問', 'category' => true, 'tag' => false, 'thumbnail' => false, 'editor' => true, 'archive' => true, 'public' => false ]
    'home_main' => [ 'name' => 'HOMEメイン画像', 'category' => false, 'tag' => false, 'thumbnail' => false, 'editor' => false, 'archive' => false, 'public' => false ]
];
/* =========================================== */
include_once('../../../../wp-load.php');
$filename = get_stylesheet_directory().'/config/taxonomy.json';
$tmp =  file_get_contents($filename);
header('Content-Type:application/octet-stream');
header('Content-Disposition:filename=taxonomy.json');
header('Content-Length:' . strlen($tmp));
echo $tmp;  //ダウンロード
exit;
