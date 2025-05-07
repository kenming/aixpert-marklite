<?php

/**
 * Plugin Name: AiXpert MarkLite
 * Plugin URI: https://github.com/kenming/wp-plugin-aixpert-marklite
 * Description: 一個輕量級的 Markdown 編輯器插件，支援從外部編輯器複製內容
 *              並使用 markdown-it 引擎進行渲染。
 * Version: 0.1.0
 * Author: Kenming Wang
 * Author URI: https://www.kenming.idv.tw
 * License: GPLv3
 * Text Domain: aixpert-marklite
 * 
 * Created: 2025/05/06
 * Last Updated: 2025/05/07
 * 
 * -----
 * Changelog:
 * v0.1.0 (2025-05-05) - 初始版本
 */

// 如果直接訪問此文件，則退出
if (!defined('ABSPATH')) {
    exit;
}

// 定義常量
define('AIXPERT_MARKLITE_VERSION', '1.0.0');
define('AIXPERT_MARKLITE_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('AIXPERT_MARKLITE_PLUGIN_URL', plugin_dir_url(__FILE__));

// 自動載入器
require_once AIXPERT_MARKLITE_PLUGIN_DIR . 'includes/AutoLoader.php';

// 基本啟動函數
function aixpert_marklite_init() {
    
    // 這裡可以載入核心類別或執行初始化邏輯
    $loader = new \Thinksoft\AiXpertMarkLite\Core\Loader();
    $loader->init();
    
    // 現在可以通過 Loader 的靜態方法訪問各個組件
    // 例如: \Thinksoft\AiXpertMarkLite\Core\Loader::get_renderer()
}

// 在 WordPress 初始化時運行我們的插件
add_action('plugins_loaded', 'aixpert_marklite_init');

// 激活插件時的鉤子
register_activation_hook(__FILE__, function() {
    // 激活時的代碼
});

// 停用插件時的鉤子
register_deactivation_hook(__FILE__, function() {
    // 停用時的代碼
});