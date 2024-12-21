const messages = []; // 用于存储对话历史

document.getElementById('sendButton').addEventListener('click', async () => {
    const prompt = document.getElementById('chatbox').value;
    const dialogueDiv = document.getElementById('dialogue');

    if (!prompt.trim()) return; // 确保用户输入非空

    // 添加用户消息到对话历史
    messages.push({ role: "user", content: prompt });
    appendMessage('user', prompt);
    document.getElementById('chatbox').value = ""; // 清空输入框

    const url = "https://api.gptgod.online/v1/chat/completions";
    const headers = {
        "Authorization": `sk-qKpNLdPvrX0Cl0hR4Hp9GSXPT4fcXbYHUJy3bHWG1PF78wYF`,  // 请替换为您的 API 密钥
        "Content-Type": "application/json"
    };
    const data = {
        model: "gpt-4o-mini",
        messages: [
            { role: "system", content: "You are a helpful assistant." },
            ...messages // 将对话历史传递给模型
        ]
    };

    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: headers,
            body: JSON.stringify(data)
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const jsonResponse = await response.json();
        // 提取助手的回复并展示
        const assistantMessage = jsonResponse.choices[0].message.content;
        appendMessage('assistant', assistantMessage); // 添加助手消息到对话框
    } catch (error) {
        console.error(error);
        appendMessage('assistant', "Error: " + error.message); // 处理错误
    }
});

function appendMessage(role, content) {
    const dialogueDiv = document.getElementById('dialogue');
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${role}`;
    messageDiv.textContent = content;
    dialogueDiv.appendChild(messageDiv);
    dialogueDiv.scrollTop = dialogueDiv.scrollHeight; // 自动滚动到对话底部
}