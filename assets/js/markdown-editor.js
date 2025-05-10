(function(wp) {
    var registerBlockType = wp.blocks.registerBlockType;
    var el = wp.element.createElement;
    var TextareaControl = wp.components.TextareaControl;
    var Button = wp.components.Button;
    var ButtonGroup = wp.components.ButtonGroup;
    var useState = wp.element.useState;
    
    // 初始化 markdown-it
    let md = window.markdownit({
        html: true,
        linkify: true,
        typographer: true
    });
    
    // 檢查並載入啟用的插件
    if (typeof mdliteSettings !== 'undefined' && mdliteSettings.enabledPlugins) {
        // 啟用表格插件
        if (mdliteSettings.enabledPlugins.includes('table') && typeof window.markdownitTable !== 'undefined') {
            md = md.use(window.markdownitTable);
        }
    }
    
    registerBlockType('mdlite/markdown-editor', {
        title: 'AiXpert MarkLite Editor',
        icon: 'editor-code',
        category: 'formatting',
        keywords: [
            'markdown',
            'md',
            'editor'
        ],
        attributes: {
            content: {
                type: 'string',
                default: ''
            }
        },
        
        edit: function(props) {
            var content = props.attributes.content;
            var setContent = function(newContent) {
                props.setAttributes({ content: newContent });
            };
            
            // 使用 React Hook 來管理視圖狀態
            var [isPreview, setIsPreview] = useState(false);
            
            // 切換到編輯視圖
            var showEditor = function() {
                setIsPreview(false);
            };
            
            // 切換到預覽視圖
            var showPreview = function() {
                setIsPreview(true);
            };
            
            // 渲染 Markdown 內容為 HTML
            var renderMarkdown = function(markdownContent) {
                return { __html: md.render(markdownContent || '') };
            };
            
            // 編輯器視圖
            var editorView = el(
                'div',
                { className: 'mdlite-editor' },
                el(
                    ButtonGroup,
                    { className: 'mdlite-editor-controls' },
                    el(
                        Button,
                        { 
                            isPrimary: !isPreview,
                            onClick: showEditor
                        },
                        '編輯'
                    ),
                    el(
                        Button,
                        {
                            isPrimary: isPreview,
                            onClick: showPreview
                        },
                        '預覽'
                    )
                ),
                isPreview ?
                    el('div', {
                        className: 'mdlite-preview',
                        dangerouslySetInnerHTML: renderMarkdown(content)
                    }) :
                    el(TextareaControl, {
                        label: 'Markdown 內容',
                        value: content,
                        onChange: setContent,
                        rows: 10
                    })
            );
            
            return editorView;
        },
        
        save: function() {
            // 動態渲染，所以這裡返回 null
            return null;
        }
    });
})(window.wp);