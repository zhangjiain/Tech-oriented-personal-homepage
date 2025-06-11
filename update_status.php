<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$input = json_decode(file_get_contents('php://input'), true);
$type = $input['type'] ?? '';
$value = $input['value'] ?? '';

// 读取当前的 index.html
$indexFile = 'index.html';
if (!file_exists($indexFile)) {
    echo json_encode(['success' => false, 'message' => 'index.html 文件不存在']);
    exit;
}

$content = file_get_contents($indexFile);

if ($type === 'text') {
    // 修改 id="statusText" 的内容
    $content = preg_replace('/(<span[^>]*id="statusText"[^>]*>)[^<]+(<\/span>)/', '$1' . $value . '$2', $content);
} elseif ($type === 'field') {
    // 修改 id="statusField" 的内容
    $content = preg_replace('/(<span[^>]*id="statusField"[^>]*>)[^<]+(<\/span>)/', '$1' . $value . '$2', $content);
}

// 写入文件
if (file_put_contents($indexFile, $content)) {
    echo json_encode(['success' => true, 'message' => '更新成功']);
} else {
    echo json_encode(['success' => false, 'message' => '文件写入失败']);
}
?>