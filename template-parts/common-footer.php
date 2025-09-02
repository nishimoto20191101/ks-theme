<?php
wp_reset_query(); //have_posts()、query_posts()使用後の判定関数対策
$site_url = get_bloginfo('url');
$site_name = get_bloginfo('name');
$common_disp = get_option('common_disp');
if( !empty($common_disp['footer_logo']) ){
  $logo_size = getimagesize($common_disp['footer_logo']);
  $logo__html = "<img src=\"{$common_disp['footer_logo']}\" alt=\"{$site_name}\" {$logo_size[3]} class=\"logo\">";
}else{
  $logo__html = $site_name;
}
$copyright = !empty($common_disp['copyright']) ? $common_disp['copyright'] : "";
echo <<< HTML
<footer class="bg_grad_base">
  <div class="flex-wrap between align-center inner">
HTML;
if(is_active_sidebar('footer')){
  echo '<div class="insert" style="flex-basis:100%">';
  dynamic_sidebar('footer');
  echo '</div>';
} 
echo <<< HTML
    <div class="corp">
        <a href="{$site_url}">{$logo__html}</a>
    </div>
    <div>
HTML;
wp_nav_menu(['theme_location' => 'footer']);
echo <<< HTML
     </div>
  </div>
  <div class="copyright">{$copyright}</div>
</footer>
<div id="modal-window"><!--モーダルウインドウ -->
  <input type="checkbox" name="modal-show" id="modal-show" />
  <label for="modal-show">CLOSE</label>
  <div class="modal-inner">
    <label for="modal-show" class="close"><span>&times;</span></label>
    <div class="modal-content"></div>
  </div>
</div>
<a href="#" class="pageTop" aria-label="pageTOP"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path d="M0 12l10.975 11 2.848-2.828-6.176-6.176H24v-3.992H7.646l6.176-6.176L10.975 1 0 12z" fill="white"></path> </svg></a>
HTML;

?>