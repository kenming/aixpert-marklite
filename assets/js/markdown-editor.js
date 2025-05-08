(function(wp) {
    var registerBlockType = wp.blocks.registerBlockType;
    var el = wp.element.createElement;
    var TextareaControl = wp.components.TextareaControl;
    var Button = wp.components.Button;
    var ButtonGroup = wp.components.ButtonGroup;
    var useState = wp.element.useState;
    
    registerBlockType('mdlite/markdown-editor', {
        title: 'AiXpert MarkLite Editor',
        icon: 'editor-code',
        category: 'formatting',
        keywords: [
            'markdown',
            'md',
            'aixpert',
            '編輯器',
            'mdlite'
        ],        
        attributes: {
            content: {
                type: 'string',
                default: '',
            }
        },
        
        edit: function(props) {
            // 添加狀態來追蹤當前模式（編輯或預覽）
            var [isPreview, setIsPreview] = useState(false);
            
            // 渲染 Markdown 內容的函數
            function renderMarkdown(markdown) {
                // 確保 markdown-it 已載入
                if (typeof window.markdownit === 'undefined') {
                    return el('div', {}, '載入 Markdown 渲染器中...');
                }
                
                // 初始化 markdown-it 解析器
                var md = window.markdownit({
                    html: false,
                    xhtmlOut: true,
                    breaks: true,
                    linkify: true,
                    typographer: true,
                });
                
                // 渲染 Markdown
                var renderedHTML = md.render(markdown || '');
                
                return el('div', {
                    className: 'mdlite-preview',
                    dangerouslySetInnerHTML: { __html: renderedHTML }
                });
            }
            
            return el(
                'div', 
                { className: 'mdlite-editor' },
                [
                    // 模式切換按鈕
                    el(ButtonGroup, { className: 'mdlite-mode-toggle' }, [
                        el(Button, {
                            isPrimary: !isPreview,
                            isSecondary: isPreview,
                            onClick: function() { setIsPreview(false); }
                        }, '編輯'),
                        el(Button, {
                            isPrimary: isPreview,
                            isSecondary: !isPreview,
                            onClick: function() { setIsPreview(true); }
                        }, '預覽')
                    ]),
                    
                    // 根據當前模式顯示編輯器或預覽
                    isPreview ? 
                        renderMarkdown(props.attributes.content) : 
                        el(TextareaControl, {
                            label: '輸入 Markdown 內容',
                            value: props.attributes.content,
                            onChange: function(newContent) {
                                props.setAttributes({ content: newContent });
                            },
                            rows: 10
                        })
                ]
            );
        },
        
        save: function() {
            // 儲存函數返回 null，因為我們使用 PHP 進行渲染
            return null;
        }
    });
})(window.wp);