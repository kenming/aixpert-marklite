<?php
/**
 * 設定管理類
 */

namespace Thinksoft\AiXpertMarkLite;

/**
 * 設定管理類別
 */
class SettingManager {
    // 常量定義
    const SETTINGS_GROUP = 'aixpert-marklite-settings-group';
    const STYLE_OPTION = 'aixpert_marklite_style';
    
    /**
     * 建構函數
     */
    public function __construct() {
        // 僅添加最基本的初始化鉤子
        add_action('admin_menu', [$this, 'add_settings_page']);
    }
    
    /**
     * 添加設定頁面
     */
    public function add_settings_page() {
        add_options_page(
            __('AiXpert MarkLite 設定', 'aixpert-marklite'),
            __('AiXpert MarkLite', 'aixpert-marklite'),
            'manage_options',
            'aixpert-marklite-settings',
            [$this, 'render_settings_page']
        );
    }

    /**
     * 渲染設定頁面
     */
    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <p><?php _e('設定管理器測試頁面', 'aixpert-marklite'); ?></p>
        </div>
        <?php
    }
}