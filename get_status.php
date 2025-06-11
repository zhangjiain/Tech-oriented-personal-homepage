<?php
header('Content-Type: application/json');

$indexFile = 'index.html';
if (!file_exists($indexFile)) {
    echo json_encode(['success' => false, 'message' => '文件不存在']);
    exit;
}

$content = file_get_contents($indexFile);

// 通过 id="statusField" 获取状态名
preg_match('/<span[^>]*id="statusField"[^>]*>([^<]+)<\/span>/', $content, $fieldMatch);

// 通过 id="statusText" 获取状态内容
preg_match('/<span[^>]*id="statusText"[^>]*>([^<]+)<\/span>/', $content, $textMatch);

$data = [
    'field' => $fieldMatch[1] ?? '牛马',
    'text' => $textMatch[1] ?? '睡觉中'
];

echo json_encode(['success' => true, 'data' => $data]);
?>