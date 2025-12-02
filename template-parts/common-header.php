<?php
wp_reset_query(); //have_posts()、query_posts()使用後の判定関数対策
$site_url = get_bloginfo('url');
$site_name = get_bloginfo('name');
$common_disp = get_option('common_disp');
if( !empty($common_disp['logo']) ){
  $logo_size = getimagesize($common_disp['logo']);
  $logo__html = "<img src=\"{$common_disp['logo']}\" alt=\"{$site_name}\" {$logo_size[3]} class=\"logo\">";
}else{
  $logo__html = $site_name;
}
//ヘッダーメニュー
echo <<<HTML
<input id="nav-input" type="checkbox" class="nav-unshown">
<header>
  <div class="inner flex between align-center">
    <a href="{$site_url}" class="logo" aria-label="HOME">{$logo__html}</a>
      <div id="nav-drawer">
      <label id="nav-open" for="nav-input"><span></span><div></div></label>
      <label class="nav-unshown" id="nav-close" for="nav-input"></label>
      <div id="nav-content"><div class="nav">
HTML;
wp_nav_menu(['theme_location' => 'header']);
echo <<<HTML
      </div></div>
    </div>
HTML;
if(is_active_sidebar('header')){
  echo '<div class="insert">';
  dynamic_sidebar('header');
  echo '</div>';
} 
echo <<<HTML
  </div>
</header>
HTML;
