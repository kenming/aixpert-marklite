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
    const PLUGIN_OPTIONS = 'aixpert_marklite_plugins';
    
    /**
     * 建構函數
     */
    public function __construct() {
        // 添加設定頁面和註冊設定
        add_action('admin_menu', [$this, 'add_settings_page']);
        add_action('admin_init', [$this, 'register_settings']);
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
     * 註冊設定
     */
    public function register_settings() {
        register_setting(
            self::SETTINGS_GROUP,
            self::PLUGIN_OPTIONS,
            ['sanitize_callback' => [$this, 'sanitize_plugin_options']]
        );

        add_settings_section(
            'aixpert_marklite_plugins_section',
            __('Markdown 插件設定', 'aixpert-marklite'),
            [$this, 'render_plugins_section'],
            'aixpert-marklite-settings'
        );

        add_settings_field(
            'table_plugin',
            __('表格支援', 'aixpert-marklite'),
            [$this, 'render_table_plugin_field'],
            'aixpert-marklite-settings',
            'aixpert_marklite_plugins_section'
        );
    }

    /**
     * 渲染插件設定區塊
     */
    public function render_plugins_section() {
        echo '<p>' . __('選擇要啟用的 markdown-it 插件', 'aixpert-marklite') . '</p>';
    }

    /**
     * 渲染表格插件選項
     */
    public function render_table_plugin_field() {
        $options = get_option(self::PLUGIN_OPTIONS, []);
        $table_enabled = isset($options['table']) ? $options['table'] : false;
        
        echo '<label><input type="checkbox" name="' . self::PLUGIN_OPTIONS . '[table]" value="1" ' . checked(1, $table_enabled, false) . '/>';
        echo __('啟用表格支援 (支援基本表格渲染)', 'aixpert-marklite') . '</label>';
    }

    /**
     * 驗證插件選項
     */
    public function sanitize_plugin_options($input) {
        $sanitized = [];
        $sanitized['table'] = isset($input['table']) ? 1 : 0;
        return $sanitized;
    }

    /**
     * 渲染設定頁面
     */
    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields(self::SETTINGS_GROUP);
                do_settings_sections('aixpert-marklite-settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }
    
    /**
     * 獲取啟用的插件列表
     * 
     * @return array 啟用的插件列表
     */
    public function get_enabled_plugins() {
        $options = get_option(self::PLUGIN_OPTIONS, []);
        $enabled_plugins = [];
        
        if (isset($options['table']) && $options['table']) {
            $enabled_plugins[] = 'table';
        }
        
        return $enabled_plugins;
    }
}