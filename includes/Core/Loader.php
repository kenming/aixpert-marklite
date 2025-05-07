<?php

namespace Thinksoft\AiXpertMarkLite\Core;

class Loader {
    /**
     * 各組件的單例實例
     */
    private static $render = null;
    private static $settings_manager = null;
    private static $block_manager = null;
    
    /**
     * 初始化所有組件
     */
    public function init() {
        // 初始化邏輯
        error_log('AiXpert MarkLite Plugin Initialized!');

        // 初始化各組件
        $this->init_render();
        $this->init_settings_manager();
        $this->init_block_manager();
    }
    
    /**
     * 初始化 MDRenderer 類別
     */
    private function init_render() {
        if (self::$render === null) {
            // 實例化 MDRenderer
            self::$render = new \Thinksoft\AiXpertMarkLite\MDRender();
            
            // 註冊短代碼以測試 render_markdown_block 方法
            add_shortcode('mdlite', function($atts) {
                return self::$render->render_markdown_block($atts);
            });
        }
    }

    /**
     * 初始化設定管理器
     */
    private function init_settings_manager() {
        if (self::$settings_manager === null) {
            self::$settings_manager = new \Thinksoft\AiXpertMarkLite\SettingManager();
            // 不需要額外的操作，建構函數已經註冊了必要的鉤子
        }
    }

    /**
     * 初始化區塊管理器
     */
    private function init_block_manager() {
        if (self::$block_manager === null) {
            // 使用已經初始化的渲染器實例
            self::$block_manager = new \Thinksoft\AiXpertMarkLite\BlockManager(self::$render);
        }
    }
    
    /**
     * 獲取渲染器實例
     */
    public static function get_renderer() {
        return self::$render;
    }
    
    /**
     * 獲取設定管理器實例
     */
    public static function get_settings_manager() {
        return self::$settings_manager;
    }
    
    /**
     * 獲取區塊管理器實例
     */
    public static function get_block_manager() {
        return self::$block_manager;
    }
}