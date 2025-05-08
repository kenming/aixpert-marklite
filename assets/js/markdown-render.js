// assets/js/markdown-render.js
document.addEventListener('DOMContentLoaded', function() {
    // 確保 markdown-it 已經載入
    if (typeof window.markdownit === 'undefined') {
        console.error('markdown-it 庫未載入');
        return;
    }
    
    // 初始化 markdown-it 解析器，啟用一些常用選項
    const md = window.markdownit({
        html: false,        // 禁用 HTML 標籤以增加安全性
        xhtmlOut: true,     // 使用 '/' 閉合單標籤 (<br />)
        breaks: true,       // 將換行符轉換為 <br>
        linkify: true,      // 自動轉換 URL 為連結
        typographer: true,  // 啟用一些語言中性的替換 + 引號美化
    });
    
    // 查找所有 Markdown 區塊並渲染
    const mdBlocks = document.querySelectorAll('.mdlite-content');
    mdBlocks.forEach(function(block) {
        const markdown = block.getAttribute('data-markdown');
        const renderedDiv = block.querySelector('.mdlite-rendered');
        const loadingDiv = block.querySelector('.mdlite-loading');
        
        if (markdown && renderedDiv) {
            // 渲染 Markdown 為 HTML
            const html = md.render(markdown);
            renderedDiv.innerHTML = html;
            
            // 隱藏載入提示，顯示渲染內容
            if (loadingDiv) loadingDiv.style.display = 'none';
            renderedDiv.style.display = 'block';
        }
    });
});