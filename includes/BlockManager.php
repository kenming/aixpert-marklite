<?php

namespace Thinksoft\AiXpertMarkLite;

class BlockManager {
    /**
     * MarkItRender 實例
     */
    private $md_render;
    
    /**
     * 構造函數
     *
     * @param MarkItRender $md_render MarkItRender 實例
     */
    public function __construct(MarkItRender $md_render) {
        $this->md_render = $md_render;
        
        // 註冊區塊
        add_action('init', array($this, 'register_blocks'));

        // 載入編輯器資源
        add_action('enqueue_block_editor_assets', array($this, 'enqueue_editor_assets'));
        
    }
    
    /**
     * 註冊 Gutenberg 區塊
     */
    public function register_blocks() {
        // 註冊 Markdown 編輯器區塊，使用簡化名稱
        register_block_type('mdlite/markdown-editor', [
            'attributes' => [
                'content' => [
                    'type' => 'string',
                    'default' => '',
                ],
            ],
            'render_callback' => [$this, 'render_md_block'],
        ]);
    }

    public function enqueue_editor_assets() {        
        // 載入 JS
        wp_enqueue_script(
            'mdlite-editor-script',
            plugin_dir_url(dirname(__FILE__)) . 'assets/js/markdown-editor.js',
            array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'markdown-it'),
            filemtime(plugin_dir_path(dirname(__FILE__)) . 'assets/js/markdown-editor.js'),
            true
        );
        
        // 載入 CSS
        wp_enqueue_style(
            'mdlite-editor-style',
            plugin_dir_url(dirname(__FILE__)) . 'assets/css/markdown-editor.css',
            array(),
            filemtime(plugin_dir_path(dirname(__FILE__)) . 'assets/css/markdown-editor.css')
        );
    }
       

    /**
     * Markdown 區塊渲染函數
     *
     * @param array $attributes 區塊屬性
     * @return string 渲染後的 HTML
     */    
    public function render_md_block($attributes) {
        // 確保有內容要渲染
        $content = isset($attributes['content']) ? $attributes['content'] : '';
        
        // 調用 MarkItRender 的渲染方法
        return $this->md_render->render_markdown_block([
            'content' => $content
        ]);
    }
}