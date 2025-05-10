// assets/js/markdown-render.js
document.addEventListener('DOMContentLoaded', function() {
    // 確保 markdown-it 已經載入
    if (typeof window.markdownit === 'undefined') {
        console.error('markdown-it 庫未載入');
        return;
    }
    
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
    
    // 尋找所有 Markdown 內容區塊
    const mdContainers = document.querySelectorAll('.mdlite-content');
    
    mdContainers.forEach(function(container) {
        const markdownContent = container.getAttribute('data-markdown');
        const loadingDiv = container.querySelector('.mdlite-loading');
        const renderedDiv = container.querySelector('.mdlite-rendered');
        
        if (markdownContent && renderedDiv) {
            // 渲染 Markdown 內容
            const renderedHTML = md.render(markdownContent);
            renderedDiv.innerHTML = renderedHTML;
            
            // 隱藏載入提示，顯示渲染結果
            if (loadingDiv) loadingDiv.style.display = 'none';
            renderedDiv.style.display = 'block';
        }
    });
});