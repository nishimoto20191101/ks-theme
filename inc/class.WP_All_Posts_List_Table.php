<?php
add_action( 'pre_get_posts', function ($query) {
  $query->set( 'posts_per_page', '20' );//表示件数をセット
});
class WP_All_Posts_List_Table extends WP_List_Table {
  public function __construct() {
    parent::__construct();
  }
  private function set_posts() {
    $result = [];
    $date_format = get_option('date_format')." ".get_option('time_format');
    $post_types = get_post_types(['public' => true,'_builtin' => false]);
    $post_types = array_merge(['post', 'page'], array_values($post_types));
    $paged = !empty($_GET['paged']) ? $_GET['paged'] : 1;
    //$per_page = get_option('posts_per_page'); //表示件数
    $args = [
        'post_type' => $post_types,
        //'per_page'  => $per_page,
        'orderby'   => !empty($_GET['orderby']) ? $_GET['orderby'] : "",
        'order'     => !empty($_GET['order']) ? $_GET['order'] : "",
        'paged'     => $paged
	  ];
    if(!empty($_GET['s'])){
      $args['s'] = $_GET['s'];
    }
    $wp_query = new WP_Query();
    $wp_query->query($args);
    if ( $wp_query->have_posts() ){
		  while( $wp_query->have_posts() ){
        $wp_query->the_post();
        $obj = new stdClass();
        $obj->id = get_the_id();
        $obj->title = get_the_title();
        $obj->post_type = get_post_type();
        $obj->date = get_the_time($date_format);
        array_push($result, $obj);
		  }
    }
    $num = $wp_query->found_posts;//投稿総数
    $per_page = $wp_query->get('posts_per_page'); //セットされている表示件数を取得
    if ( !is_null( $num ) ) { //ページネーション設定
      $this->set_pagination_args( [
        'total_items' => $num,
        'per_page' => $per_page
      ] );
    }
    return $result;
  }
  public function prepare_items() {
    $columns= $this->get_columns();
    $hidden= [];
    $sortable=  [
      'title' => ['post_title', true],
      'date'  => ['post_date' , true]
    ];
    $this->_column_headers = [$columns, $hidden, $sortable];
    $this->items = $this->set_posts();
  }
  public function get_columns() {
    return [
      //'cb' => 'checkbox',
      'id' => 'id',
      'title' => 'タイトル',
      'post_type' => '投稿タイプ',
      'date' => '日付'
    ];
  }
  public function single_row($item) {
    list($columns, $hidden, $sortable, $primary) = $this->get_column_info();
    $id = $item->id;
    $edit_url = admin_url()."post.php?post={$item->id}&action=edit";
    //$trash_url = wp_nonce_url( admin_url()."post.php?post={$item->id}&action=trash" );
    $disp_url = get_the_permalink($id);
    $title = esc_html($item->title);
    $post_type = esc_html($item->post_type);
    $post_type_url = admin_url()."edit.php?post_type={$post_type}";
    echo <<<HTML
        <tr>
            <!-- <th scope="row" class="check-column"><input type="checkbox" name="checked[]" value="{$item->id}" /></th> -->
            <td>{$item->id}</td>
            <td class="title column-title has-row-actions column-primary page-title" data-colname="タイトル">
              <a href="{$edit_url}" class="row-title">{$title}</a>
              <div class="row-actions">
                <span class="edit"><a href="{$edit_url}" aria-label="{$title} を編集">編集</a> | </span><span class="view"><a href="{$disp_url}" rel="bookmark" aria-label="{$title} を表示" target="_blank">表示</a></span>
              </div>
            </td>
            <td><a href="$post_type_url">{$post_type}</a></td>
            <td>{$item->date}</td>
        </tr>
HTML;
    }
}