<?php
class WP_ks_post_type{
  /*################################################################################
    初期処理
  ################################################################################*/
  private $taxonomy_file;
  static function init(){
    return new self();
  }
  function __construct(){
    //config取得
    //$this->taxonomy_file = get_template_directory().'/config/taxonomy.json'; //親テーマディレクトリ
    $this->taxonomy_file = get_stylesheet_directory().'/config/taxonomy.json';
  }
  /*################################################################################
    ファイル
  ################################################################################*/
  //#### configパス ####//
  public function file_path(){
    return $taxonomy_file;
  }
  //#### config読み込み ####//
  public function get(){
    !file_exists($this->taxonomy_file) && file_put_contents($this->taxonomy_file, '');
    return json_decode( file_get_contents($this->taxonomy_file) );
  }
  //#### config書き込み ####//
  public function set($config){
    return file_put_contents($this->taxonomy_file , json_encode($config));
  }
  /*################################################################################
    表示
  ################################################################################*/
  //#### 一覧 ####//
  public function disp_list(){
    $result = '<a href="?page=ks_post_type&disp=edit" class="page-title-action">新規追加</a>';
    $ks_post_types = $this->get();
    $export_url = get_template_directory_uri()."/config/taxonomy.php";
    if(!empty($ks_post_types)){
        $result .=<<<HTML
      <table class="wp-list-table widefat fixed striped table-view-list posts" style="margin-top:1rem">
        <thead>
          <tr>
            <th>カスタム投稿名</th>
            <th>label</th>
            <th>カテゴリ</th>
            <th>専用カテゴリ</th>
            <th>タグ</th>
            <th>アイキャッチ</th>
            <th>アーカイブページ</th>
            <th>詳細ページ</th>
            <th style="width:3em"></th>
          </tr>
        </thead>
HTML;
        foreach($ks_post_types as $key => $val ){
            $category_comm = !empty($val->category_comm) ? "有" : "無";
            $category = !empty($val->category) ? "有" : "無";
            $tag = !empty($val->tag) ? "有" : "無";
            $thumbnail = !empty($val->thumbnail) ? "有" : "無";
            $archive = !empty($val->archive) ? "有" : "無";
            $public = !empty($val->public) ? "有" : "無";
            $result.=<<<HTML
          <tr>
            <td>{$key}</td>
            <td>{$val->name}</td>
            <td>{$category_comm}</td>
            <td>{$category}</td>
            <td>{$tag}</td>
            <td>{$thumbnail}</td>
            <td>{$archive}</td>
            <td>{$public}</td>
            <td><a href="?page=ks_post_type&disp=edit&key={$key}">編集</a></td>
        </tr>
HTML;
        }
        $result .=<<<HTML
    </table>
    <hr  style="margin:2rem 0" />
    <div>
      <h3 style="font-weight:400">登録データ</h3>
      <table class="form-table" id="post-type" style="width:fit-content">
        <tr>
          <th scope="row" style="font-weight:400"><label for="inputtext">エクスポート</label></th>
          <td><span>taxonomy.json</span></td>
          <td><a href="{$export_url}" target="_blank" class="button-primary">ダウンロード</a></td>
        </tr>
      </table>
			<form action="" method="post" enctype="multipart/form-data" >
        <table class="form-table" id="post-type" style="width:fit-content">
          <tr>
						<th scope="row" style="font-weight:400"><label for="inputtext">インポート</label></th>
						<td>
							<input type="file" name="configfile" accept=".json" required="required" class="required">
						</td>
            <td><input type="hidden" name="action" value="upload"> <input type="submit" class="button-primary" value="アップロード" style="display:none;" /></td>
					</tr>
				</table>
			</form>
    </div>
<script>
  (function ($) {
    $(document).on('change', '#post-type .required', function () {
      if( $('select[name=tbl]').val() != "" && $('input[name="configfile"]').val() != "" ){
        $('#post-type input[type="submit"]').css( 'display' , 'block');
      }else{
        $('#post-type input[type="submit"]').css( 'display' , 'none');
      }
    });
  })(window.jQuery);
</script>
HTML;
    }

    return $result;
  }
  //#### 編集 ####//
  public function disp_edit($key=""){
    $ks_post_types = $this->get();
    $keys = array_keys((array)$ks_post_types);
    $keys_js = "'".implode("', '", $keys)."'";
    $new       = empty($key) ? 1 : 0;
    $key       = !empty($ks_post_types->$key) ? $key : "";
    $key_type  = !empty($ks_post_types->$key) ? 'hidden' : 'text';
    $name      = !empty($ks_post_types->$key->name) ? $ks_post_types->$key->name : "";
    $category_comm  = !empty($ks_post_types->$key->category_comm) ? " checked" : "";
    $category  = !empty($ks_post_types->$key->category)  || !empty($new) ? " checked" : "";
    $tag       = !empty($ks_post_types->$key->tag)       || !empty($new) ? " checked" : "";
    $thumbnail = !empty($ks_post_types->$key->thumbnail) || !empty($new) ? " checked" : "";
    $archive   = !empty($ks_post_types->$key->archive)   || !empty($new) ? " checked" : "";
    $public    = !empty($ks_post_types->$key->public)    || !empty($new) ? " checked" : "";
    $key_name = !empty($key) ? $key : "[カスタム投稿名]";
    $result =<<<HTML
      <form action="?page=ks_post_type" method="post" style="padding-top:1em">
        <input type="hidden" name="disp" value="edit">
        <input type="hidden" name="new" value="{$new}">
        <span style="color:#f00">※</span>必須項目
        <dl>
          <dt>カスタム投稿名<span style="color:#f00">※</span></dt><dd><input type="{$key_type}" name="key" value="{$key}" placeholder="※半角英数字 最大28文字" maxlength="28" style="width:20em;max-width:100%" required><span>{$key}</span></dd>
          <dt>表示名<span style="color:#f00">※</span></dt><dd><input type="text" name="name" value="{$name}" style="width:20em;max-width:100%" required></dd>
          <dt>カテゴリー</dt><dd><label><input type="checkbox" name="category_comm" value="1"{$category_comm}>有</label></dd>
          <dt>専用カテゴリー</dt><dd><label><input type="checkbox" name="category" value="1"{$category}>有</label><span>※タクソノミー名：{$key_name}_cat</span></dd>
          <dt>タグ</dt><dd><label><input type="checkbox" name="tag" value="1"{$tag}>有</label></dd>
          <dt>アイキャッチ画像</dt><dd><label><input type="checkbox" name="thumbnail" value="1"{$thumbnail}>有</label></dd>
          <dt>一覧ページ</dt><dd><label><input type="checkbox" name="archive" value="1"{$archive}>有</label></dd>
          <dt>詳細ページ</dt><dd><label><input type="checkbox" name="public" value="1"{$public}>有</label></dd>
        </dl>
        <p class="submit">
          <button type="submit" name="action" class="button-primary" value="save">保存</button>
          <button type="submit" name="action" class="edit-slug button button-small del" value="del">削除</button>
        </p>
        <a href="?page=ks_post_type" style="display:inline-block;margin-bottom:1.5em">一覧へ</a>
    </form>
    <h3>注意点</h3>
    <ul style="margin-bottom:2rem">
        <li>・カスタム投稿名は登録後に変更できません。</li>
    </ul>
<style>
  form dl{display:flex;flex-wrap:wrap;max-width:100%;width:80em}
  form dt{width:9.5em;padding-top:10px;margin:7px 0}
  form dd{max-width:100%;min-width:200px;width:calc(100% - 9.5em);margin:12px 0}
  form dd>span{display:inline-block;padding:5px 10px}
  form dd label+label{margin-left:1rem}
  input[type="text"]{padding:5px 10px!important;}
</style>
<script>
  jQuery('input[name="key"]').on('blur',function(){
    var chk_ids = [{$keys_js}];
    if( chk_ids.indexOf(jQuery(this).val()) !== -1 ){      
      window.alert('既に登録されているカスタム登録名です。');
      jQuery(this).val('');
    }
  });
  jQuery("button.del").on('click',function(){
    if(window.confirm('削除してよろしいですか？')){
      return true;
    }else{
      window.alert('キャンセルされました。');
      return false; // 送信を中止
    }
  });
</script>
HTML;
    return $result;
  }
}
