<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = $_POST['index'] ?? -1;
    
    if ($index >= 0 && file_exists("messages.txt")) {
        $messages = file("messages.txt");
        
        if (isset($messages[$index])) {
            unset($messages[$index]); // 删除指定的留言
            file_put_contents('messages.txt', implode('', $messages)); // 保存更新后的留言
        }
    }
    
    // 删除后重定向回主页面
    header('Location: main.php');
    exit;
}
?>
