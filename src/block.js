/**
 * AiXpert Markdown Block
 * 
 * 一個簡單的 Markdown 編輯器區塊，提供編輯與預覽功能。
 * 使用 markdown-it 引擎來轉換 Markdown 為 HTML。
 * 
 * @package AiXpert-MarkLite
 */

const { registerBlockType } = wp.blocks;
const { __ } = wp.i18n;
const { RichText, PlainText } = wp.blockEditor;
const { TabPanel } = wp.components;

registerBlockType('aixpert-marklite/markdown', {
    title: __('AiXpert Markdown', 'aixpert-marklite'),
    icon: 'editor-code',
    category: 'formatting',
    keywords: [
        __('markdown', 'aixpert-marklite'),
        __('text', 'aixpert-marklite'),
        __('aixpert', 'aixpert-marklite'),
    ],
    attributes: {
        content: {
            type: 'string',
            default: '',
        },
    },

    edit: function(props) {
        const { attributes, setAttributes } = props;
        const { content } = attributes;

        // 當內容變更時更新屬性
        const onChangeContent = (newContent) => {
            setAttributes({ content: newContent });
        };

        // 預覽 Markdown
        const renderPreview = () => {
            if (!window.markdownit) {
                return <div>Markdown 引擎載入中...</div>;
            }

            const md = window.markdownit();
            const renderedHTML = md.render(content || '');

            return (
                <div
                    className="aixpert-marklite-preview"
                    dangerouslySetInnerHTML={{ __html: renderedHTML }}
                />
            );
        };

        return (
            <div className="aixpert-marklite-editor">
                <TabPanel
                    className="aixpert-marklite-tabs"
                    activeClass="active-tab"
                    tabs={[
                        {
                            name: 'markdown',
                            title: __('Markdown', 'aixpert-marklite'),
                            className: 'aixpert-marklite-tab',
                        },
                        {
                            name: 'preview',
                            title: __('預覽', 'aixpert-marklite'),
                            className: 'aixpert-marklite-tab',
                        },
                    ]}
                >
                    {(tab) => {
                        if (tab.name === 'markdown') {
                            return (
                                <PlainText
                                    value={content}
                                    onChange={onChangeContent}
                                    placeholder={__('在此輸入 Markdown 內容或從外部編輯器貼上...', 'aixpert-marklite')}
                                    className="aixpert-marklite-textarea"
                                />
                            );
                        } else {
                            return renderPreview();
                        }
                    }}
                </TabPanel>
            </div>
        );
    },

    save: function() {
        // 使用動態渲染，因此此處返回 null
        return null;
    },
});