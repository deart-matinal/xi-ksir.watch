<?php
// 定义图片存储目录
$image_dir = __DIR__ . '/imageLibrary';
$image_url_base = 'imagemain'; // 供浏览器访问的路径

// 检查并创建目录（如果不存在）
if (!is_dir($image_dir)) {
    mkdir($image_dir, 0755, true);
}

// 防止页面缓存
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// 处理图片上传
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $upload_file = $_FILES['image'];
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $file_type = mime_content_type($upload_file['tmp_name']);
    $file_ext = pathinfo($upload_file['name'], PATHINFO_EXTENSION);

    if (in_array($file_type, $allowed_types)) {
        $new_name = time() . '_' . uniqid() . '.' . $file_ext; // 生成唯一文件名
        $target_path = $image_dir . '/' . $new_name;

        if (move_uploaded_file($upload_file['tmp_name'], $target_path)) {
            // 使用 PRG 模式，防止重复提交
            header("Location: " . $_SERVER['REQUEST_URI'] . "?success=1");
            exit();
        } else {
            $message = "图片上传失败，请重试。";
        }
    } else {
        $message = "仅支持 JPG, PNG, GIF, WEBP 格式的图片。";
    }
}

// 获取图片列表
$images = [];
if (is_dir($image_dir)) {
    $files = scandir($image_dir);
    foreach ($files as $file) {
        if (preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file)) {
            $images[] = $file;
        }
    }
}

// 分页参数
$images_per_page = 1;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $images_per_page;

// 当前页的图片
$current_page_images = array_slice($images, $offset, $images_per_page);
$total_images = count($images);
$total_pages = ceil($total_images / $images_per_page);

// 检查是否启用上传功能
$show_upload_form = isset($_GET['control']);
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>daily</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin: 0; padding: 0; }
        .image-container { margin: 20px auto; }
        img { max-width: 100%; height: auto; border: 1px solid #ddd; box-shadow: 0 0 5px rgba(0, 0, 0, 0.2); }
        .pagination { margin: 20px 0; font-size: 18px; }
        .pagination a { text-decoration: none; color: #007BFF; margin: 0 10px; }
        .pagination span { color: #555; }
        form { margin: 20px auto; }
        input, button { font-size: 16px; margin: 5px; }
        .message { color: green; margin: 10px 0; }
    </style>
</head>
<body>
    <h1>secret</h1>

    <!-- 提示信息 -->
    <?php if (isset($_GET['success'])): ?>
        <p class="message">图片上传成功！</p>
    <?php elseif (!empty($message)): ?>
        <p class="message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <!-- 上传表单，仅在 ?control 参数存在时显示 -->
    <?php if ($show_upload_form): ?>
        <form method="POST" enctype="multipart/form-data">
            <label for="image">选择要上传的图片：</label>
            <input type="file" name="image" id="image" accept="image/jpeg, image/png, image/gif, image/webp" required>
            <button type="submit">上传图片</button>
        </form>
    <?php else: ?>
        <p style="color: #888;">上传功能已关闭，请联系管理员。</p>
    <?php endif; ?>

    <!-- 图片展示 -->
    <div class="image-container">
        <?php if (!empty($current_page_images)): ?>
            <?php foreach ($current_page_images as $image): ?>
                <img src="<?php echo htmlspecialchars($image_url_base . '/' . $image); ?>" alt="图片展示">
            <?php endforeach; ?>
        <?php else: ?>
            <p>暂无图片。</p>
        <?php endif; ?>
    </div>

    <!-- 分页导航 -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>">← 上一页</a>
        <?php endif; ?>
        <span>第 <?php echo $page; ?> 页 / 共 <?php echo $total_pages; ?> 页</span>
        <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo $page + 1; ?>">下一页 →</a>
        <?php endif; ?>
    </div>
</body>
</html>