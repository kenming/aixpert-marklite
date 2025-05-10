<?php

namespace Thinksoft\AiXpertMarkLite;

class MarkItRender {

    /**
     * 啟用的插件列表
     */
    private $enabled_plugins = [];

    /**
     * 構造函數
     */
    public function __construct() {
        // 註冊腳本和樣式
        add_action('wp_enqueue_scripts', array($this, 'register_markdown_assets'));
        add_action('admin_enqueue_scripts', array($this, 'register_markdown_assets'));
    }

    /**
     * 設置啟用的插件列表
     * 
     * @param array $plugins 啟用的插件列表
     */
    public function set_enabled_plugins($plugins) {
        $this->enabled_plugins = $plugins;
    }    
    
    /**
     * 註冊 markdown-it 腳本和樣式
     */
    public function register_markdown_assets() {
        // 引入 markdown-it 庫 (從 CDN)
        wp_enqueue_script(
            'markdown-it',
            'https://cdn.jsdelivr.net/npm/markdown-it@14.1.0/dist/markdown-it.min.js',
            array(),
            '14.1.0',
            true
        );
        
        // 引入我們自己的 markdown 處理腳本
        wp_enqueue_script(
            'mdlite-renderer',
            plugin_dir_url(dirname(__FILE__)) . 'assets/js/markdown-render.js',
            array('markdown-it'),
            filemtime(plugin_dir_path(dirname(__FILE__)) . 'assets/js/markdown-render.js'),
            true
        );
        
        // 引入 Markdown 渲染樣式
        wp_enqueue_style(
            'mdlite-rendered-style',
            plugin_dir_url(dirname(__FILE__)) . 'assets/css/markdown-render.css',
            array(),
            filemtime(plugin_dir_path(dirname(__FILE__)) . 'assets/css/markdown-render.css')
        );

        // 載入啟用的插件（如果有的話）
        if (!empty($this->enabled_plugins)) {
            $this->load_markdown_plugins($this->enabled_plugins);
            // 傳遞啟用的插件到 JavaScript
            wp_localize_script(
                'mdlite-renderer',
                'mdliteSettings',
                array(
                    'enabledPlugins' => $this->enabled_plugins
                )
            );
        }        
    }

    /**
     * 載入 markdown-it 插件
     *
     * @param array $enabled_plugins 啟用的插件列表
     */
    public function load_markdown_plugins($enabled_plugins) {
        // 如果沒有啟用的插件，直接返回
        if (empty($enabled_plugins)) {
            return;
        }

        // 檢查是否需要載入表格插件
        if (in_array('table', $enabled_plugins)) {
            // 載入表格插件
            wp_enqueue_script(
                'markdown-it-table',
                'https://cdn.jsdelivr.net/npm/markdown-it-table@2.0.6/dist/markdown-it-table.min.js',
                array('markdown-it'),
                '2.0.6',
                true
            );
            
            // 載入表格樣式
            wp_enqueue_style(
                'mdlite-table-style',
                plugin_dir_url(dirname(__FILE__)) . 'assets/css/markdown-table.css',
                array(),
                filemtime(plugin_dir_path(dirname(__FILE__)) . 'assets/css/markdown-table.css')
            );
        }
        
        // 傳遞啟用的插件到 JavaScript
        wp_localize_script(
            'mdlite-renderer',
            'mdliteSettings',
            array(
                'enabledPlugins' => $enabled_plugins
            )
        );
        
        // 如果在編輯器中，也傳遞給編輯器腳本
        if (wp_script_is('mdlite-editor-script', 'registered')) {
            wp_localize_script(
                'mdlite-editor-script',
                'mdliteSettings',
                array(
                    'enabledPlugins' => $enabled_plugins
                )
            );
        }
    }    
    
    /**
     * 渲染 Markdown 區塊
     *
     * @param array $attributes 區塊屬性
     * @return string 渲染後的 HTML
     */
    public function render_markdown_block($attributes) {
        $content = isset($attributes['content']) ? $attributes['content'] : '';
        
        // 為了安全起見，對內容進行轉義
        $escaped_content = esc_html($content);
        
        // 使用 JavaScript 渲染 Markdown
        return '<div class="mdlite-content" data-markdown="' . esc_attr($escaped_content) . '">
                  <div class="mdlite-loading">載入中...</div>
                  <div class="mdlite-rendered" style="display:none;"></div>
               </div>';
    }
}