(function(wp) {
    var registerBlockType = wp.blocks.registerBlockType;
    var el = wp.element.createElement;
    var TextareaControl = wp.components.TextareaControl;
    
    registerBlockType('mdlite/markdown-editor', {
        title: 'AiXpert MarkLite Editor',
        icon: 'editor-code',
        category: 'formatting',
        // 添加關鍵字，使區塊更容易被搜尋到
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
            return el(
                'div', 
                { className: 'mdlite-editor' },
                el(TextareaControl, {
                    label: 'Markdown 內容',
                    value: props.attributes.content,
                    onChange: function(value) {
                        props.setAttributes({ content: value });
                    },
                    rows: 10
                })
            );
        },
        
        save: function() {
            // 使用 PHP 渲染，這裡返回 null
            return null;
        }
    });
})(window.wp);