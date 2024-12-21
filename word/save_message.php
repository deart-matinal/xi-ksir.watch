<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $message = $_POST['message'] ?? '';
    
    // 获取用户的IP地址
    $ip = $_SERVER['REMOTE_ADDR'];
    
    if ($name && $message) {
        $data = array(
            'name' => $name,
            'message' => $message,
            'time' => date('Y-m-d H:i:s'),
            'ip' => $ip  // 将IP地址保存到数据中
        );
        
        $json = json_encode($data) . "\n";
        file_put_contents('messages.txt', $json, FILE_APPEND);
    }
    
    // 重定向回主页面
    header('Location: main.php');
    exit;
}
?>
