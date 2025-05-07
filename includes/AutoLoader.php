<?php

namespace Thinksoft\AiXpertMarkLite;

spl_autoload_register(function (string $class) {
    // 確保類別屬於插件命名空間
    if (strpos($class, __NAMESPACE__) !== 0) {
        return;
    }

    // 移除命名空間並轉換為檔案路徑
    $relative_class = str_replace(__NAMESPACE__ . '\\', '', $class);
    $file = AIXPERT_MARKLITE_PLUGIN_DIR . 'includes/' . str_replace('\\', '/', $relative_class) . '.php';
    
    // 調試信息
    //error_log("嘗試加載類: $class");
    //error_log("檔案路徑: $file");
    //error_log("檔案存在: " . (file_exists($file) ? '是' : '否'));

    // 引入檔案
    if (file_exists($file)) {
        require_once $file;
    }
});