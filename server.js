const WebSocket = require('ws');

const wss = new WebSocket.Server({ port: 8080 });

wss.on('connection', (ws) => {
  ws.on('message', (message) => {
    console.log('Received: ', message);
    if (typeof message === 'string') { // テキストメッセージの場合のみ処理するように変更
        wss.clients.forEach((client) => {
            if (client !== ws && client.readyState === WebSocket.OPEN) {
                client.send(message);
            }
        });
    }
  });

  ws.on('error', (error) => {
    console.warn('Error: ', error);
  });
});
