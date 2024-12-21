<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate"> 
    <meta http-equiv="pragma" content="no-cache"> 
    <meta http-equiv="expires" content="0"> 
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="author" content="deart-夕&幕伞科技">
    <title>留言板</title>
    <link rel="stylesheet" type="text/css" href="/style.css"> 
</head>
<body>
    <div class="message-board">
        <h1>痕迹</h1>
        
        <div class="message-form">
            <form action="save_message.php" method="post">
                <p>
                    <label for="name">昵称(最多6字):</label><br>
                    <input type="text" id="name" name="name" maxlength="6" required>
                </p>
                <p>
                    <label for="message">留言内容 (最多10字):</label><br>
                    <textarea id="message" name="message" maxlength="10" required></textarea>
                </p>
                <button type="submit">提交留言</button>
            </form>
        </div>

        <div id="messages">
            <?php
            $messages = file_exists("messages.txt") ? file("messages.txt") : [];
            $messages = array_reverse($messages); // 反转留言顺序
            $is_master = isset($_GET['master']); // 判断是否有 master 参数
            
            foreach($messages as $index => $message) {
                $data = json_decode($message, true);
                echo '<div class="message-note">';
                echo '<strong>' . htmlspecialchars($data['name']) . '</strong>';
                echo '<div class="message-time">' . $data['time'] . '</div>';
                echo '<p>' . nl2br(htmlspecialchars($data['message'])) . '</p>';
                
                if ($is_master) {
                    // 如果是 master，显示删除按钮
                    echo '<form action="delete_message.php" method="post" style="display:inline-block;">';
                    echo '<input type="hidden" name="index" value="' . $index . '">';
                    echo '<button type="submit" style="background:red;color:white;border:none;padding:5px;">删除</button>';
                    echo '</form>';
                }
                
                echo '</div>';
            }
            ?>
        </div>
    </div>
</body>
</html>
