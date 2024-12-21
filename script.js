// 解析视频链接
document.getElementById('link').onclick = function() {
    document.getElementById('output').style.display = 'block';
};

document.getElementById('copyButtonA').onclick = function() {
    var inputA = document.getElementById('inputA').value;
    var fullUrlA = "https://jx.xmflv.com/?url=" + inputA;

    navigator.clipboard.writeText(fullUrlA).then(function() {
        alert('正在使用解析链接1,完整视频链接已复制到剪贴板：' + fullUrlA);
    }, function(err) {
        alert('复制失败！' + fullUrlA);
    });
};

document.getElementById('redirectButtonA').onclick = function() {
    var inputA = document.getElementById('inputA').value;
    var fullUrlA = "https://jx.xmflv.com/?url=" + inputA; // 生成链接
    window.location.href = fullUrlA; // 跳转至生成的链接
};

document.getElementById('copyButtonB').onclick = function() {
    var inputB = document.getElementById('inputB').value;
    var fullUrlB = "https://jx.xmflv.cc/?url=" + inputB;

    navigator.clipboard.writeText(fullUrlB).then(function() {
        alert('正在使用解析链接2,完整视频链接已复制到剪贴板：' + fullUrlB);
    }, function(err) {
        alert('复制失败！' + fullUrlB);
    });
};

document.getElementById('redirectButtonB').onclick = function() {
    var inputB = document.getElementById('inputB').value;
    var fullUrlB = "https://jx.xmflv.cc/?url=" + inputB; // 生成链接
    window.location.href = fullUrlB; // 跳转至生成的链接
};

window.onload = function() {
    // 获取所有背景图片
    const images = [
        '/images/fd.jpg',
        '/images/fd1.jpg', 
        '/images/fd2.jpg',
        '/images/fd3.jpg',
        '/images/fd4.jpg',
        '/images/fd5.jpg', 
        '/images/fd6.jpg',
        '/images/fd7.jpg'
    ];

    // 随机选择一张图片
    const randomImage = images[Math.floor(Math.random() * images.length)];

    // 设置背景图片
    const background = document.querySelector('.background');
    background.style.backgroundImage = `url(${randomImage})`;

    // 为背景添加加载后的效果
    background.classList.add('clear');

    // 添加景深动画效果
    setTimeout(() => {
        background.classList.add('loaded');
    }, 500); // 等待背景图加载一段时间后应用景深效果

    // 动态设置问候语
    const popupText = document.getElementById('popupText');
    const now = new Date();
    const hour = now.getHours();

    if (hour >= 5 && hour < 12) {
        popupText.textContent = "早上好，开始新的一天吧！☀️";
    } else if (hour >= 12 && hour < 18) {
        popupText.textContent = "下午好，继续努力加油！🌤️";
    } else if (hour >= 18 && hour < 22) {
        popupText.textContent = "晚上好，记得休息放松！🌙";
    } else {
        popupText.textContent = "夜深了，早点休息吧！✨";
    }
};
