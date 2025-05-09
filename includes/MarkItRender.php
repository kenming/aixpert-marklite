<?php

namespace Thinksoft\AiXpertMarkLite;

class MarkItRender {
    /**
     * 構造函數
     */
    public function __construct() {
        // 註冊腳本和樣式
        add_action('wp_enqueue_scripts', array($this, 'register_markdown_assets'));
        add_action('admin_enqueue_scripts', array($this, 'register_markdown_assets'));
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