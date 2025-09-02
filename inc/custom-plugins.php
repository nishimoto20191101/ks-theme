<?php
// テーマインストール時にプラグインを導入
if( ! class_exists('ks_plugins_install') ){
    class ks_plugins_install{
        private $plugins = [];
        public function __construct() {
            require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';
            $this->plugins = [// テーマに梱包するプラグイン
                [
                    'name'               => 'KS ショートコード', // プラグインの名前
                    'slug'               => 'ks-shortcode', // プラグインのスラッグ
                    'source'             => get_template_directory() . '/plugins/ks-shortcode.zip', // プラグインのパス
                    'required'           => false, // 必須プラグインかどうか
                    'version'            => '1.0.0', // 必要なバージョン
                    'force_activation'   => false, // テーマ有効化時に強制インストール
                    'force_deactivation' => false, // テーマ無効化時に強制無効化
                ]
            ];

            add_action('tgmpa_register', function() {
                $config = [
                    'id'           => 'ks',                       // 一意のID
                    'default_path' => '',                         // プラグインファイルのデフォルトパス
                    'menu'         => 'tgmpa-install-plugins',    // プラグインインストールページのメニュー名
                    'has_notices'  => true,                       // 管理画面通知を表示するか
                    'dismissable'  => true,                       // 通知を解除可能にするか
                    'is_automatic' => false,                      // プラグインを自動インストールするか
                ];
                tgmpa( $this->plugins, $config );
            });
        }
    }
    // テーマインストール時にプラグインを導入
    $plugins_install = new ks_plugins_install();
}
